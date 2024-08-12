<?php
include 'components/includes/connection.php';
if (isset($_GET['id'])) {
    $sid = $_GET['id'];
    $examId = $_GET['examId'];
    $exno = $_GET['no'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sudarsansir Master Academy</title>
    <link rel="shortcut icon" href="assets/images/lefere.svg" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="print.css" media="print">
    <style>
        .log {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .log img {
            width: 240px !important;
            display: block;
        }

        .flexShow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row;

        }

        /* 
        .flexShow .card-body {
            padding: 1rem !important;
        } */

        .out {
            padding: 0 !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class='col-md-12' style="margin-bottom: 1em;">
                <div class="log">
                    <img src="assets/images/IMAGELOGO.svg" alt="">
                    <div class="text-center">
                        <button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
                    </div>
                </div>
                <div class='card flexShow'>
                    <div class='card-body' style="align-items:start">
                        <?php

                        $rwwo = "SELECT * FROM demosections WHERE id = '$examId'";
                        $rwwosult = $mysql_connection->query($rwwo);
                        $numofSection = 0;
                        if ($rwwosult->num_rows > 0) {
                            while ($nu = $rwwosult->fetch_assoc()) {
                                $numofSection++;
                            }
                        }

                        $sqe = "SELECT numberOfQuestions FROM demoexam WHERE id = '$examId'";
                        $re = $mysql_connection->query($sqe);

                        $rowCount = 0; // Default row count to 0
                        
                        if ($re) {
                            $row = $re->fetch_assoc();
                            $rowCount = $row['numberOfQuestions'];
                        } else {
                            echo "Error: " . $mysql_connection->error;
                        }


                        $swq = "SELECT * FROM demoexam WHERE id = ?";
                        $stmt1 = $mysql_connection->prepare($swq);
                        $stmt1->bind_param("i", $examId);
                        $stmt1->execute();
                        $result1 = $stmt1->get_result();

                        if ($result1->num_rows > 0) {
                            $deta1 = $result1->fetch_assoc();
                        }

                        $swq2 = "SELECT * FROM msub WHERE student_id = ? AND exam_id = ? AND examNo= ?";
                        $stmt2 = $mysql_connection->prepare($swq2);
                        $stmt2->bind_param("iii", $sid, $examId, $exno);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();

                        if ($result2->num_rows > 0) {
                            $deta2 = $result2->fetch_assoc();
                        }
                        ?>
                        <h4>Course Name:
                            <?= $deta1['course'] ?>
                        </h4>
                        <h4>Exam Name:
                            <?= $deta1['examName'] . $exno ?>
                        </h4>
                        <h4>Correct Answer Marking:
                            <?= $deta1['pMark'] ?>
                        </h4>
                        <h4>Negative Marking:
                            <?= $deta1['nMark'] ?>
                        </h4>
                        <h4>Total Percentage:
                            <?= number_format($deta2['total'], 2) ?>%
                        </h4>

                    </div>
                    <div class='card-body' style="align-items:start">
                        <!-- Second column with 6 units (half of 12) -->
                        <h4>Total No. of Question:
                            <?= $rowCount * $numofSection ?>
                        </h4>
                        <h4>Correct Answer:
                            <?= $deta2['correct'] ?>
                        </h4>
                        <h4>Wrong Answer:
                            <?= $deta2['wrong'] ?>
                        </h4>
                        <h4>Not Attempted:
                            <?= $deta2['notans'] ?>
                        </h4>
                    </div>
                </div>
                <div class='col-md-12 out'>
                    <div class='card'>
                        <div class='card-body' style="align-items:start">
                            <?php

                            $answers = array();

                            $getAnswer = "SELECT answers FROM msub WHERE student_id = ? AND exam_id = ?";
                            $stmt3 = $mysql_connection->prepare($getAnswer);
                            $stmt3->bind_param("ii", $sid, $examId);
                            $stmt3->execute();
                            $result3 = $stmt3->get_result();


                            if ($result3->num_rows > 0) {
                                $row = $result3->fetch_assoc();
                                $answers = json_decode($row['answers'], true);
                            }
                            // print_r($answers);
                            
                            $queee = "SELECT * FROM demosections WHERE id = ?";
                            $stmt4 = $mysql_connection->prepare($queee);
                            $stmt4->bind_param("i", $examId);
                            $stmt4->execute();
                            $result4 = $stmt4->get_result();

                            $rowses = array();
                            $swooss = array();
                            $section = "";

                            if ($result4->num_rows > 0) {
                                while ($rowee = $result4->fetch_assoc()) {
                                    $rowses[] = $rowee;
                                    $section = $rowee['name'];
                                }
                            }
                            $v = 0;

                            foreach ($answers as $sectionKey => $section_answers) {
                                echo "<h1>Section: $sectionKey </h1>";
                                foreach ($section_answers as $question => $answer) {
                                    $escapedQuestion = $mysql_connection->real_escape_string($question);
                                    // echo $question;
                                    $veddd = "SELECT * FROM demoq_{$examId} WHERE question = '$escapedQuestion'";
                                    $result5 = $mysql_connection->query($veddd);


                                    if ($result5->num_rows > 0) {
                                        while ($swss = $result5->fetch_assoc()) {
                                            // $swooss[] = $swss;
                                            if (isset($swss['description']) && $swss['description'] != "") {
                                                echo "<h5>Description: " . $swss['description'] . "</h5>";
                                            }
                                            echo "<h5>Question: " . $swss['question'] . "</h5>";
                                            echo '<ul>';
                                            $choices = json_decode($swss['choices'], true);
                                            foreach ($choices as $choice) {
                                                if (!empty($choice)) { // Check if the choice is not empty
                                                    if ($choice['type'] === 'text') {
                                                        // Display text choice
                                                        if ($choice['value'] == $swss['correct_answer']) {
                                                            echo "<li style='color:green; font-weight:bold;'>{$choice['value']}</li>";
                                                        } else {
                                                            echo "<li>{$choice['value']}</li>";
                                                        }
                                                    } elseif ($choice['type'] === 'image') {
                                                        // Display image choice
                                                        $imagePath = str_replace('uploads/', '', $choice['value']); // Remove 'uploads/' prefix
                                                        if ($imagePath == $swss['correct_answer']) {
                                                            echo "<li style='color:green; font-weight:bold;'><img src='admin/{$choice['value']}' alt='choice image' style='max-width:100px;'></li>";
                                                        } else {
                                                            echo "<li><img src='admin/{$choice['value']}' alt='choice image' style='max-width:100px;'></li>";
                                                        }
                                                    }
                                                }
                                            }

                                            echo '</ul>';

                                            if ($answer == $swss['correct_answer']) {
                                                echo "<p>Given Anwer: " . $answer . " <i class='fa-solid fa-check'></i></p>";
                                            } else if ($answer == '') {
                                                echo "<p>Given Anwer: Not Answered</p>";
                                            } else {
                                                echo "<p>Given Anwer: " . $answer . " <i class='fa-solid fa-xmark'></i></p>";
                                            }
                                            if (isset($swss['explanation']) & $swss['explanation'] != "") {
                                                echo "<p><strong>Explanation: <strong>" . $swss['explanation'] . "</p>";
                                            }
                                            echo "<br>";
                                        }
                                    }
                                }
                                echo "<br>";
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
</body>

</html>