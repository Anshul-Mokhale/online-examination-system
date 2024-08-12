<?php include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
// Retrieve the exam ID from the GET request
if (isset($_GET['exam_id'])) {
    $examId = $_GET['exam_id'];
} else {
    // Handle the case when exam_id is not provided
    echo "Error: Exam ID not provided";
    exit; // Terminate script execution
}

$answers = $_GET;

// Construct the table name based on the exam ID
$questionTableName = "question_$examId";


?>

<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <style>
            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .row {
                margin-top: 2em !important;
            }
        </style>
        <div class="main-panel">
            <div class="content-wrapper">

                <section>
                    <div class='container-fluid'>
                        <div class='row' id="message">

                        </div>
                    </div>
                </section>
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                        </span> Results
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
                    <?php
                    $examId = mysqli_real_escape_string($mysql_connection, $examId);

                    $queee = "SELECT * FROM sections WHERE id = '$examId'";
                    $reu = $mysql_connection->query($queee);
                    $rowses = array();
                    $swooss = array();
                    $num = 0;

                    if ($reu) {
                        // Check if any rows were returned
                        if ($reu->num_rows > 0) {
                            while ($rowee = $reu->fetch_assoc()) {
                                // Store each row in an array
                                $rowses[] = $rowee;
                                $num++;
                                $tempno = $rowee['sr'];
                            }
                        }
                    }

                    for ($v = 0; $v < count($rowses); $v++) {
                        $section = $rowses[$v]['sr']; // corrected variable name
                        echo "Section: " . $rowses[$v]['name']; // corrected variable name
                        echo "<br>";
                        $veddd = "SELECT * FROM $questionTableName WHERE section = '$section'";
                        $restultt = $mysql_connection->query($veddd);
                        if ($restultt->num_rows > 0) {
                            $abb = 0;
                            while ($swss = $restultt->fetch_assoc()) {
                                // Store each row in an array
                                $swooss[] = $swss;
                                echo $swss['question'];
                                echo "<br>";
                                echo $swss['correct_answer'];
                                echo "<br>";
                                $vaeeee = 'section' . $v . '_question' . $abb;
                                if (isset($answers[$vaeeee]) && $answers[$vaeeee] !== "") {
                                    echo "attempted answer: " . $answers[$vaeeee];
                                } else {
                                    echo "attempted answer: Not Answered";
                                }
                                echo "<br>";
                                $abb++;
                            }
                        }
                        echo "<br>";

                    }

                    ?>
                </div>

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php'); ?>