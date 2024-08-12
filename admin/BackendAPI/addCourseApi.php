<?php
include "../components/includes/connection.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw JSON data from the request body
    $json_data = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($json_data, true);

    // Check if decoding was successful
    if ($data !== null) {
        // Access the values using the keys
        $courseName = $data['courseName'];
        $description = $data['description'];

        $stmt = $mysql_connection->prepare("INSERT INTO course (Name, Disc) VALUES (?, ?)");
        $stmt->bind_param("ss", $courseName, $description);

        if ($stmt->execute()) {
            // Insertion successful
            echo json_encode(['status' => 'success', 'message' => 'Course Added Successfully!']);
        } else {
            // Insertion failed
            echo json_encode(['status' => 'error', 'message' => 'Error Adding Course!']);
        }

        // Close the database connection
        $stmt->close();
        $mysql_connection->close();
    } else {
        // JSON decoding failed
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
    }
} else {
    // Not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}