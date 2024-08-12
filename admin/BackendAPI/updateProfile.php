<?php
include "../components/includes/connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];

    $randomFolderName = uniqid();

    // Specify the upload directory with the random name folder
    $uploadDirectory = "../uploads/" . $randomFolderName . "/";

    // Check if the directory exists, if not create it
    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    // Check if img1 is uploaded
    if (isset($_FILES['img1']['name']) && !empty($_FILES['img1']['name'])) {
        // Handle the first image upload
        $img1Name = $_FILES['img1']['name'];
        $img1TmpName = $_FILES['img1']['tmp_name'];
        $img1TargetPath = $uploadDirectory . basename($img1Name);

        // Move uploaded file to the specified directory
        if (move_uploaded_file($img1TmpName, $img1TargetPath)) {
            echo "Image 1 uploaded successfully.<br>";
            $sqq1 = "UPDATE `students` SET `Simage` = '$img1TargetPath' WHERE `students`.`id` = '$id'";
            $resu1 = $mysql_connection->query($sqq1);
            if ($resu1 == true) {
                echo "Uploaded img 1 to database<br>";
            } else {
                echo "Failed to upload img 1 to database<br>";
            }

            // Check if img2 is also uploaded
            if (isset($_FILES['img2']['name']) && !empty($_FILES['img2']['name'])) {
                // Handle the second image upload
                $img2Name = $_FILES['img2']['name'];
                $img2TmpName = $_FILES['img2']['tmp_name'];
                $img2TargetPath = $uploadDirectory . basename($img2Name);

                // Move uploaded file to the specified directory
                if (move_uploaded_file($img2TmpName, $img2TargetPath)) {
                    echo "Image 2 uploaded successfully.<br>";

                    $sqq2 = "UPDATE `students` SET `Ssign` = '$img2TargetPath' WHERE `students`.`id` = '$id'";
                    $resu2 = $mysql_connection->query($sqq2);
                    if ($resu2 == true) {
                        echo "Uploaded img 2 to database<br>";
                    } else {
                        echo "Failed to upload img 2 to database<br>";
                    }
                } else {
                    echo "Error in uploading while moving img2<br>";
                }
            }
            header("Location: ../updateImg.php?id=$id&msg=success");
            exit;
        } else {
            header("Location: ../updateImg.php?id=$id&msg=failed");
            exit;
        }
    } else {
        header("Location: ../updateImg.php?id=$id&msg=success");
        exit;
    }
} else {
    header("Location: ../updateImg.php?id=$id&msg=success");
    exit;
}
?>