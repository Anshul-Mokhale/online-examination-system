<?php
// Include the database connection file
include "../components/includes/connection.php";

// Assuming you have a connection object named $conn

// Check if the course ID is provided in the POST request
if (isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $courseId = mysqli_real_escape_string($mysql_connection, $_POST['id']);

    // Query to delete the course with the specified ID
    $deleteQuery = "DELETE FROM course WHERE id = '$courseId'";

    // Execute the delete query
    if ($mysql_connection->query($deleteQuery)) {
        // If deletion is successful, send a success response
        echo json_encode(array('status' => 'success', 'msg' => 'deleted Successfully!'));
    } else {
        // If an error occurs during deletion, send an error response
        echo json_encode(array('error' => 'Error deleting course: ' . mysqli_error($mysql_connection)));
    }
} else {
    // If the course ID is not provided, send an error response
    echo json_encode(array('error' => 'Course ID not provided'));
}

// Close the database connection
$mysql_connection->close();