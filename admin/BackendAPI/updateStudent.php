<?php
include_once('../components/includes/connection.php');

// Set content type to JSON
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['data'])) {
        $data = json_decode($_POST['data'], true);

        // Extracting form data
        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $phoneNumber = $data['phoneNumber'];
        $gender = $data['gender'];
        $courses = json_encode($data['courses']);
        $birthDate = $data['birthDate'];
        $address = $data['address'];

        // Check if the password is provided
        if (isset($data['password'])) {
            $password = md5($data['password']);
            $updateSql = "UPDATE students SET name='$name', email='$email', phone='$phoneNumber', password='$password', gender='$gender', birth_date='$birthDate', address='$address', courses='$courses' WHERE id='$id'";
        } else {
            // If password is not provided, update without modifying the password
            $updateSql = "UPDATE students SET name='$name', email='$email', phone='$phoneNumber', gender='$gender', birth_date='$birthDate', address='$address', courses='$courses' WHERE id='$id'";
        }

        if ($mysql_connection->query($updateSql) === TRUE) {
            $response['status'] = "success";
            $response['message'] = "Student data updated successfully!";
        } else {
            $response['status'] = "error";
            $response['message'] = "Error updating student data: " . $mysql_connection->error;
        }
    } else {
        $response['status'] = "error";
        $response['message'] = "Data key not found in the POST request.";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
}

// Encode the response as JSON and output
echo json_encode($response);
?>