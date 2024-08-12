<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');

$msg = '';

if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
} else {
    $msg = "";
}

$sid = $_GET['id'];
$examId = $_GET['examId'];
$exno = $_GET['no'];
?>

<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <style>
            .container-scroller {
                font-family: 'Nunito Sans', sans-serif !important;
            }

            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .row {
                margin-top: 2em !important;
            }

            .remove-icon {
                margin-left: 5px;
                cursor: pointer;
            }

            .scroll-top-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                display: none;
                /* Initially hide the button */
                z-index: 9999;
                /* Set a high z-index to ensure it appears above other elements */
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">
                <?php if ($msg) { ?>
                    <section>
                        <div class='container-fluid'>
                            <div class='row'>
                                <?= $msg ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                <section>
                    <div class='container-fluid'>
                        <div class='row' id="message">

                        </div>
                    </div>
                </section>

                <div class="page-header">
                    <h3 class="page-title">
                        <a href="moreResult.php?id=<?= $sid ?>" class="txt-primary"
                            style="font-size: 30px !important;"><i class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i
                                    class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="row">
                    <div class='col-md-12' style="margin-bottom: 1em;">
                        <div class='card'>
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

                                $swq2 = "SELECT * FROM msub WHERE student_id = ? AND exam_id = ? AND examNo = ?";
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
                                    <?= $deta1['examName'] . " " . $exno ?>
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
                            <!--  -->
                        </div>
                        <div class='col-md-12'>
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
                                                        if ($choice !== "") {
                                                            if ($choice == $swss['correct_answer']) {
                                                                echo "<li style='color:green; font-weight:bold;'>$choice</li>";
                                                            } else {
                                                                echo "<li>$choice</li>";
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
                        <button id="scrollTopBtn" class="btn btn-primary scroll-top-btn" title="Go to top"><i
                                class="mdi mdi-arrow-up"></i></button>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        $(window).scroll(function () {
                            // If user has scrolled more than 20px from the top
                            if ($(this).scrollTop() > 20) {
                                // Show the scroll-to-top button
                                $('#scrollTopBtn').fadeIn();
                            } else {
                                // Otherwise, hide the button
                                $('#scrollTopBtn').fadeOut();
                            }
                        });

                        // Function to handle button click
                        $('#scrollTopBtn').click(function () {
                            // Scroll to the top of the page with animation
                            $('html, body').animate({ scrollTop: 0 }, 800);
                        });
                    </script>
                    <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
                    <?php include_once('components/footer.php'); ?>