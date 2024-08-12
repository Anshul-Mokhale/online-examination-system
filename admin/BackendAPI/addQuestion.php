<?php
include "../components/includes/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle main image upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uploadDir = '../uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFileName = uniqid('img_', true) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $imagePath = "uploads/" . $newFileName;
        } else {
            echo json_encode(["status" => "failed", "error" => "Failed to upload main image"]);
            exit;
        }
    }

    // Fetch and sanitize POST data
    $examName = $mysql_connection->real_escape_string($_POST['examName']);
    $section = intval($_POST['section']);
    $description = $mysql_connection->real_escape_string($_POST['paragraph']);
    $question = $mysql_connection->real_escape_string($_POST['question']);
    $explanation = $mysql_connection->real_escape_string($_POST['explanation']);
    $correctAnswer = isset($_POST['correctAnswer']) ? $mysql_connection->real_escape_string($_POST['correctAnswer']) : '';
    $choices = isset($_POST['choices']) ? json_decode($_POST['choices'], true) : [];

    // Validate choices
    $processedChoices = [];
    if (is_array($choices)) {
        foreach ($choices as $key => $choice) {
            if (isset($choice['type']) && $choice['type'] == 'text' && !empty($choice['value'])) {
                $processedChoices[] = ['type' => 'text', 'value' => $mysql_connection->real_escape_string($choice['value'])];
            } elseif (isset($choice['type']) && $choice['type'] == 'image') {
                // Handling dynamically named file uploads for choices
                $fileKey = $choice['value']; // Get the dynamic file key from choice data
                if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
                    $fileName = basename($_FILES[$fileKey]['name']);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $newFileName = $fileKey;
                    $destPath = '../uploads/' . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $processedChoices[] = ['type' => 'image', 'value' => "uploads/" . $newFileName];
                    } else {
                        echo json_encode(["status" => "failed", "error" => "Failed to upload choice image"]);
                        exit;
                    }
                }
            }
        }
    } else {
        echo json_encode(["status" => "failed", "error" => "Choices data is not valid"]);
        exit;
    }

    // Validate correct answer
    if (empty($correctAnswer)) {
        echo json_encode(["status" => "failed", "error" => "Correct answer not provided"]);
        exit;
    }

    // Check if the question table exists
    $checkTableQuery = "SHOW TABLES LIKE 'question_" . $examName . "'";
    $tableResult = $mysql_connection->query($checkTableQuery);
    if ($tableResult->num_rows == 0) {
        $createTableQuery = "CREATE TABLE question_" . $examName . " (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            exam_id INT(6) UNSIGNED,
            image_path VARCHAR(255) NULL,
            description TEXT,
            question TEXT,
            choices TEXT,
            correct_answer VARCHAR(255),
            explanation TEXT,
            section INT(11)
        )";
        if ($mysql_connection->query($createTableQuery) !== TRUE) {
            echo json_encode(["status" => "failed", "error" => "Error creating table: " . $mysql_connection->error]);
            exit;
        }
    }

    // Insert data into the question table
    $processedChoicesJson = json_encode($processedChoices);
    $insertQuery = "INSERT INTO question_" . $examName . " (exam_id, image_path, description, question, choices, correct_answer, explanation, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysql_connection->prepare($insertQuery);
    if ($stmt) {
        $stmt->bind_param('issssssi', $examName, $imagePath, $description, $question, $processedChoicesJson, $correctAnswer, $explanation, $section);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Question added successfully"]);
        } else {
            echo json_encode(["status" => "failed", "error" => "Error inserting data: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "failed", "error" => "Error preparing statement: " . $mysql_connection->error]);
    }
    $mysql_connection->close();
}
?>