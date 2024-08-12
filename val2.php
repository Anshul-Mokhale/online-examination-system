<?php
include "components/includes/connection.php";

// Get the POST data
$postData = json_decode(file_get_contents('php://input'), true);

// Extract student ID, exam ID, and answers from the POST data
$studentId = $postData['studentId'];
$examId = $postData['examId'];
$examno = $postData['examNo'];
$answers = $postData['answers'];

$correct = 0;
$wrong = 0;
$notans = 0;

// Fetch positive and negative marks from the database for the exam
$sql = "SELECT pMark, nMark FROM demoexam WHERE id = ?";
$stmt = $mysql_connection->prepare($sql);
$stmt->bind_param("i", $examId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $positiveMark = (float) $row['pMark'];
    $negativeMark = (float) $row['nMark'];

} else {
    echo "Error: Exam details not found!";
    exit;
}
$mxtot = 0.0;
$totalScore = 0.0;

// Calculate the total score based on the student's answers
foreach ($answers as $section => &$questions) {
    foreach ($questions as $question => &$answer) {
        // Retrieve the correct answer from the database
        $answe = str_replace('uploads/', '', $answer);
        $answer = $answe;

        $query = "SELECT correct_answer FROM demoq_{$examId} WHERE exam_id = ? AND question = ?";
        $stmt = $mysql_connection->prepare($query);
        $stmt->bind_param("is", $examId, $question);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $correctAnswer = $row['correct_answer'];
            $mxtot = $mxtot + $positiveMark;
            // Compare the student's answer with the correct answer and update the total score accordingly
            if ($answer == $correctAnswer) {
                $totalScore += $positiveMark;
                $correct += 1;
            } else if ($answer == "") {
                $notans += 1;
            } else {
                $totalScore -= $negativeMark;
                $wrong += 1;
            }
        } else {
            echo "Error: Question details not found!";
            exit;
        }
    }
}
$count = ($totalScore / $mxtot) * 100;
$finalCnt = $count < 0 ? 0 : $count;

// Encode answers to JSON
$jsonAnswers = json_encode($answers);


$sqleeee = "SELECT * FROM msub WHERE student_id = '$studentId' AND exam_id = '$examId' AND examNo = '$examno'";
$reuslt = $mysql_connection->query($sqleeee);
if ($reuslt->num_rows > 0) {
    $rowseees = $reuslt->fetch_assoc();
    $subId = $rowseees['submission_id'];
    $updateSql = "UPDATE `msub` SET `answers` = '$jsonAnswers', `total` = '$finalCnt', `correct` = '$correct', `wrong` = '$wrong', `notans` = '$notans' WHERE `msub`.`submission_id` = '$subId'";
    $lastSr = $mysql_connection->query($updateSql);
    if ($lastSr = true) {
        echo "Answers resubmitted successfully!";
    } else {
        echo "Error: Some Thing error";
    }
} else {
    // Insert student ID, exam ID, answers, and total score into the database
    $insertSql = "INSERT INTO msub (student_id, exam_id, examNo, answers, total,correct, wrong,notans) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $mysql_connection->prepare($insertSql);
    $stmt->bind_param("iiisdiii", $studentId, $examId, $examno, $jsonAnswers, $finalCnt, $correct, $wrong, $notans);

    if ($stmt->execute()) {
        echo "Answers submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

}

$stmt->close();
$mysql_connection->close();
?>