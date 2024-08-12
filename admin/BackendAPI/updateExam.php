<?php
include_once('../components/includes/connection.php');

// Set content type to JSON
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data directly from $_POST
    $id = $_POST['id'];
    $course = $_POST['course'];
    $examName = $_POST['examName'];
    $inst = $_POST['instructions'];
    $mode = $_POST['mode'];
    if (isset($_POST['dateTime'], $_POST['dateTime2'])) {
        $dateTime1 = $_POST['dateTime'];
        $dateTime2 = $_POST['dateTime2'];
    }
    $dateTime11 = "0000-00-00 00:00:00";
    $dateTime22 = "0000-00-00 00:00:00";



    $time = $_POST['timeLimit'];
    $noq = $_POST['numberOfQuestions'];
    $pmark = $_POST['pMark'];
    $nmark = $_POST['nMark'];

    // Update the database based on the mode
    if ($mode == 'Live') {
        $sql1 = "UPDATE `exams` SET `course_name` = '$course' , `exam_name` = '$examName' , `instructions` = '$inst', `mode` = '$mode',`date_time`='$dateTime11', `date_time2` = '$dateTime22', `time_limit` = '$time', `number_of_questions` = '$noq', `posititve` = '$pmark' , `negaitve` = '$nmark' WHERE `exams`.`id` = '$id'";
        $res = $mysql_connection->query($sql1);
        if ($res == true) {
            $response['status'] = "success";
            $response['message'] = "Exam updated successfully";
        } else {
            $response['status'] = "Failed";
            $response['message'] = "Error updating exam in Live mode";
        }
    } else if ($mode == 'Scheduled') {
        $sql1 = "UPDATE `exams` SET `course_name` = '$course' , `exam_name` = '$examName' , `instructions` = '$inst', `mode` = '$mode',`date_time`='$dateTime1', `date_time2` = '$dateTime2', `time_limit` = '$time', `number_of_questions` = '$noq', `posititve` = '$pmark' , `negaitve` = '$nmark' WHERE `exams`.`id` = '$id'";
        $res = $mysql_connection->query($sql1);
        if ($res == true) {
            $response['status'] = "success";
            $response['message'] = "Exam updated successfully";
        } else {
            $response['status'] = "Failed";
            $response['message'] = "Error updating exam in Scheduled mode";
        }
    } else {
        $response['status'] = "Failed";
        $response['message'] = "Invalid mode";
    }
} else {
    $response['status'] = "Failed";
    $response['message'] = "No Data Found";
}

// Encode the response as JSON and output
echo json_encode($response);
?>