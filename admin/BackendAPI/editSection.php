<?php
// Include the database connection file
include "../components/includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $sec = isset($_POST['sec']) ? $_POST['sec'] : null; // Corrected variable name
    $section = isset($_POST['section']) ? $_POST['section'] : null;

    // Check if both id and section are not empty
    if (!empty($id) && !empty($section)) {
        // Prepare the SQL statement
        $sql = "UPDATE `sections` SET `name` = ? WHERE `sections`.`sr` = ?";

        // Prepare the SQL statement
        $stmt = $mysql_connection->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("si", $section, $sec); // Changed variable name from $sec to $id
            $result = $stmt->execute();

            // Check if the query was successful
            if ($result) {
                // Redirect to the desired page
                header("Location: ../addQuestion.php?sec=$sec&id=$id");
                exit(); // Ensure that no further code is executed after redirection
            } else {
                // Redirect with an error message if the query fails
                header("Location: ../addQuestion.php?sec=$sec&id=$id&error=update_failed");
                exit(); // Ensure that no further code is executed after redirection
            }
        } else {
            // Redirect with an error message if statement preparation fails
            header("Location: ../addQuestion.php?sec=$sec&id=$id&error=prepare_failed");
            exit(); // Ensure that no further code is executed after redirection
        }
    } else {
        // Redirect with an error message if either id or section is empty
        header("Location: ../addQuestion.php?sec=$sec&id=$id&error=empty_fields");
        exit(); // Ensure that no further code is executed after redirection
    }
}

// Close the database connection
$mysql_connection->close();
?>