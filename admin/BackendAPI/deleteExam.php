<?php
// Include the database connection file
include "../components/includes/connection.php";

// Check if the course ID is provided in the POST request
if (isset($_POST['id'])) {
    // Sanitize the input to prevent SQL injection
    $examId = mysqli_real_escape_string($mysql_connection, $_POST['id']);

    // Query to delete the section from sections table
    $deleteSectionQuery = "DELETE FROM sections WHERE id = '$examId'";

    // Execute the delete query for sections
    if (!$mysql_connection->query($deleteSectionQuery)) {
        // If an error occurs during deletion of section, send an error response
        echo json_encode(array('error' => 'Error deleting section: ' . mysqli_error($mysql_connection)));
        exit; // Exit the script if there's an error in deleting the section
    }

    // Check if the question_$id table exists
    $questionTable = "question_$examId";
    $checkTableQuery = "SHOW TABLES LIKE '$questionTable'";
    $result = $mysql_connection->query($checkTableQuery);

    if ($result->num_rows > 0) {
        // If the table exists, drop it
        $dropTableQuery = "DROP TABLE $questionTable";
        if (!$mysql_connection->query($dropTableQuery)) {
            // If an error occurs during dropping the table, send an error response
            echo json_encode(array('error' => 'Error dropping question table: ' . mysqli_error($mysql_connection)));
            exit; // Exit the script if there's an error in dropping the table
        }
    }

    // Query to delete the exam with the specified ID
    $deleteQuery = "DELETE FROM exams WHERE id = '$examId'";

    // Execute the delete query for exam
    if ($mysql_connection->query($deleteQuery)) {
        // If deletion is successful, send a success response
        echo json_encode(array('status' => 'success', 'msg' => 'Deleted Successfully!'));
    } else {
        // If an error occurs during deletion of exam, send an error response
        echo json_encode(array('error' => 'Error deleting exam: ' . mysqli_error($mysql_connection)));
    }
} else {
    // If the course ID is not provided, send an error response
    echo json_encode(array('error' => 'Course ID not provided'));
}

// Close the database connection
$mysql_connection->close();
?>