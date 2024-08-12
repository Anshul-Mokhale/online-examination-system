<?php
// Include the database connection file
include "../components/includes/connection.php";

if (isset($_GET['id'], $_GET['sec'])) {
    // Sanitize input to prevent SQL injection
    $id = $mysql_connection->real_escape_string($_GET['id']);
    $sec = $mysql_connection->real_escape_string($_GET['sec']);

    // Check if questions exist in question_$id table with exam_id = $id and section = $sec
    $query_check_questions = "SELECT * FROM demoq_$id WHERE exam_id = '$id' AND section = '$sec'";
    $result_check_questions = $mysql_connection->query($query_check_questions);

    // If there are no questions or if the query fails, delete the section directly
    if ($result_check_questions === false || $result_check_questions->num_rows === 0) {
        // Delete corresponding row in sections table
        $query_delete_section = "DELETE FROM demosections WHERE id = '$id' AND sr = '$sec'";
        if ($mysql_connection->query($query_delete_section)) {
            // echo "";
            header("location: ../addDemoSection.php?id=$id&sec=$sec");
        } else {
            // echo "Error deleting section: " . $mysql_connection->error;
            header("location: ../addDemoSection.php?id=$id&sec=$sec");
        }
    } else {
        // If questions exist, delete them from question_$id table and then delete the section
        $query_delete_questions = "DELETE FROM demoq_$id WHERE exam_id = '$id' AND section = '$sec'";
        if ($mysql_connection->query($query_delete_questions)) {
            // If questions are deleted successfully, delete corresponding row in sections table
            $query_delete_section = "DELETE FROM demosections WHERE id = '$id' AND sr = '$sec'";
            if ($mysql_connection->query($query_delete_section)) {
                // echo "Questions and corresponding section deleted successfully.";
                header("location: ../addDemoSection.php?id=$id&sec=$sec");
            } else {
                // echo "Error deleting section: " . $mysql_connection->error;
                header("location: ../addDemoSection.php?id=$id&sec=$sec");
            }
        } else {
            // echo "Error deleting questions: " . $mysql_connection->error;
            header("location: ../addDemoSection.php?id=$id&sec=$sec");
        }
    }
} else {
    // echo "Invalid parameters provided.";
    header("location: ../addDemoSection.php?id=$id&sec=$sec");
}

// Close the database connection
$mysql_connection->close();
?>