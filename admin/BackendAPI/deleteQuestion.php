<?php
// Include the database connection file
include "../components/includes/connection.php";

// Check if exam ID and question ID are provided in the POST request
if (isset($_POST['examId'], $_POST['questionId'])) {
    // Sanitize and validate input
    $examId = $_POST['examId'];
    $questionId = $_POST['questionId'];

    // Query to delete the question from the database
    $deleteQuery = "DELETE FROM question_$examId WHERE id = '$questionId'";

    // Execute the delete query
    if ($mysql_connection->query($deleteQuery)) {
        // If deletion is successful, send a success response
        echo json_encode(array('status' => 'success'));
    } else {
        // If an error occurs during deletion, send an error response
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete question.'));
    }
} else {
    // If exam ID or question ID is not provided, send an error response
    echo json_encode(array('status' => 'error', 'message' => 'Exam ID or question ID not provided.'));
}

// Close the database connection
$mysql_connection->close();
?>