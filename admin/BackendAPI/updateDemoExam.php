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
    $numofexam = $_POST['numofexam'];
    $time = $_POST['timeLimit'];
    $noq = $_POST['numberOfQuestions'];
    $pmark = $_POST['pMark'];
    $nmark = $_POST['nMark'];

    $sql1 = "UPDATE `demoexam` SET `course` = '$course' , `examName` = '$examName' , `numofexam` = '$numofexam', `timeLimit` = '$time', `numberOfQuestions` = '$noq', `pMark` = '$pmark' , `nMark` = '$nmark' WHERE `demoexam`.`id` = '$id'";
    $res = $mysql_connection->query($sql1);
    if ($res == true) {
        $response['status'] = "success";
        $response['message'] = "Exam updated successfully";
    } else {
        $response['status'] = "Failed";
        $response['message'] = "Error updating exam in Live mode";
    }
} else {
    $response['status'] = "Failed";
    $response['message'] = "No Data Found";
}

// Encode the response as JSON and output
echo json_encode($response);
?>