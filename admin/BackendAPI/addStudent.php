<?php
include "../components/includes/connection.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Specify the upload directory
    // Generate a unique identifier for the folder name
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

            // Check if img2 is also uploaded
            if (isset($_FILES['img2']['name']) && !empty($_FILES['img2']['name'])) {
                // Handle the second image upload
                $img2Name = $_FILES['img2']['name'];
                $img2TmpName = $_FILES['img2']['tmp_name'];
                $img2TargetPath = $uploadDirectory . basename($img2Name);

                // Move uploaded file to the specified directory
                if (move_uploaded_file($img2TmpName, $img2TargetPath)) {
                    echo "Image 2 uploaded successfully.<br>";

                    // Handle other form fields
                    $studentName = $_POST['exampleInputName1'];
                    $email = $_POST['exampleInputEmail3'];
                    $phoneNumber = $_POST['exampleInputMobile'];
                    $password = md5($_POST['exampleInputPassword4']);
                    $gender = $_POST['exampleSelectGender'];
                    $courses = isset($_POST['course']) ? json_encode($_POST['course']) : ""; // Encode courses array to JSON
                    $birthDate = $_POST['exampleInputBirth'];
                    $address = $_POST['exampleInputCity1'];

                    // Prepare and bind the SQL statement
                    $stmt = $mysql_connection->prepare("INSERT INTO students (name, email, phone, password, gender, birth_date, address, Simage, Ssign, courses, created_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
                    $status = 2; // Assuming status is an integer value
                    $stmt->bind_param("ssssssssssi", $studentName, $email, $phoneNumber, $password, $gender, $birthDate, $address, $img1TargetPath, $img2TargetPath, $courses, $status);


                    // Execute the SQL statement
                    if ($stmt->execute()) {
                        // echo "Student data saved successfully.<br>";
                        header("location: ../addStudent.php?msg=success");
                        exit;
                    } else {
                        // echo "Error: " . $stmt->error . "<br>";
                        header("location: ../addStudent.php?msg=Error");
                        exit;
                    }
                    $stmt->close();
                } else {
                    header("location: ../addStudent.php?msg=Fimg2");
                    exit;
                }
            } else {
                header("location: ../addStudent.php?msg=Fimg1");
                exit;
            }
        } else {
            header("location: ../addStudent.php?msg=Fimgf");
            exit;
        }
    } else {
        header("location: ../addStudent.php?msg=Failed");
        exit;
    }
} else {
    header("location: ../addStudent.php?msg=FFailed");
    exit;
}
?>