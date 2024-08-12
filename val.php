<?php
include "components/includes/connection.php";

// Get the POST data
$postData = json_decode(file_get_contents('php://input'), true);

// Extract student ID, exam ID, and answers from the POST data
$studentId = $postData['studentId'];
$examId = $postData['examId'];
$answers = $postData['answers'];

$correct = 0;
$wrong = 0;
$notans = 0;

// Fetch positive and negative marks from the database for the exam
$sql = "SELECT posititve, negaitve FROM exams WHERE id = ?";
$stmt = $mysql_connection->prepare($sql);
$stmt->bind_param("i", $examId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $positiveMark = (float) $row['posititve'];
    $negativeMark = (float) $row['negaitve'];

} else {
    echo "Error: Exam details not found!";
    exit;
}
$mxtot = 0.0;
$totalScore = 0.0;

// Calculate the total score based on the student's answers
foreach ($answers as $section => &$questions) {
    foreach ($questions as $question => &$answer) {
        // If the answer contains "uploads/" and ends with ".jpg", remove these parts
        $answe = str_replace('uploads/', '', $answer);
        $answer = $answe;

        // Retrieve the correct answer from the database
        $query = "SELECT correct_answer FROM question_{$examId} WHERE exam_id = ? AND question = ?";
        $stmt = $mysql_connection->prepare($query);
        $stmt->bind_param("is", $examId, $question);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $correctAnswer = $row['correct_answer'];
            $mxtot = $mxtot + $positiveMark;

            // Compare the student's answer with the correct answer and update the total score accordingly
            if ($answe == $correctAnswer) {
                $totalScore += $positiveMark;
                $correct += 1;
            } else if ($answe == "") {
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

// Insert student ID, exam ID, answers, and total score into the database
$insertSql = "INSERT INTO submissions (student_id, exam_id, answers, total,correct, wrong,notans) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysql_connection->prepare($insertSql);
$stmt->bind_param("iisdiii", $studentId, $examId, $jsonAnswers, $finalCnt, $correct, $wrong, $notans);

if ($stmt->execute()) {
    echo "Answers submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysql_connection->close();
?>