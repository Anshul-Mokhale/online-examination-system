<?php
// Include the database connection file
include "../components/includes/connection.php";

// Assuming you have a connection object named $conn

// Query to fetch data from the "course" table
$query = "SELECT * FROM demoexam";
$result = $mysql_connection->query($query);

// Check if the query was successful
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch all rows as an associative array
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        // Convert data to JSON format
        $json_data = json_encode($rows);

        // Output JSON data
        echo $json_data;
    } else {
        // If no rows were returned
        echo json_encode(array('message' => 'No records found'));
    }
} else {
    // If the query fails, handle the error (you may want to log or send an appropriate response)
    echo json_encode(array('error' => 'Error executing query: ' . mysqli_error($mysql_connection)));
}

// Close the database connection after fetching data
$mysql_connection->close();
