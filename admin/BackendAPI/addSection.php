<?php
include "../components/includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $section = isset($_POST['section']) ? $_POST['section'] : null;

    // Sanitize the input to prevent SQL injection and other vulnerabilities
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $section = filter_var($section, FILTER_SANITIZE_STRING);

    // Check if both id and section are not empty
    if (!empty($id) && !empty($section)) {
        // You can perform your database operations here
        $sql = "INSERT INTO sections (name, id) VALUES (?, ?)";

        // Prepare the SQL statement
        $stmt = $mysql_connection->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ss", $section, $id);
            $result = $stmt->execute();

            // Check if the query was successful
            if ($result) {
                // echo "success";
                header("Location: ../addSection.php?id=$id");

            } else {
                // echo "Error: " . $stmt->error; // Output the error message if query fails
                header("Location: ../addSection.php?id=$id");
            }

            // Close the statement
            $stmt->close();
        } else {
            header("Location: ../addSection.php?id=$id");
            // echo "Error: " . $mysql_connection->error; // Output the error message if statement preparation fails
        }
    } else {
        // If either id or section is empty, return an error message
        // echo "Error: ID or section is empty.";
        header("Location: ../addSection.php?id=$id");
    }
}

// Close the database connection
$mysql_connection->close();
?>