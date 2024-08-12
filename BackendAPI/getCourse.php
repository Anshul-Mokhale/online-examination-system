<?php
include "../components/includes/connection.php";

// Set the default response content type to JSON
header('Content-Type: application/json');

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if 'id' parameter is present in the URL
    if (isset($_GET['id'])) {
        // Store the 'id' value in a variable
        $id = $_GET['id'];



        // Simulating some response data
        $responseData = array(
            'id' => $id,
            'message' => 'Data fetched successfully' // You can replace this with actual fetched data
        );

        // Sending the response in JSON format
        echo json_encode($responseData);
    } else {
        // Handle if 'id' parameter is not present
        $errorResponse = array('error' => 'ID parameter is missing.');
        echo json_encode($errorResponse);
    }
} else {
    // Handle if request method is not GET
    $errorResponse = array('error' => 'This endpoint only accepts GET requests.');
    echo json_encode($errorResponse);
}
?>