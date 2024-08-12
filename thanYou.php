<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['ab'])) {
    $msg = $_GET['ab'];
} else {
    $msg = "";
}
$studentId = 2;
$examId = 10;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Exam</title>
    <link rel="stylesheet" href="exam.css">
</head>
<style>
    .thank {
        padding: 3em;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .thank img {
        width: 30%;
    }
</style>

<body>
    <nav class="NavBar">
        <img src="assets/images/IMAGELOGO.svg" alt=""> Test Exam 1
        <a class="nav-link" style="color:white;">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
    </nav>
    <div class="thank">
        <img src="assets/images/green_double_circle_check_mark.svg" alt="">
        <h1>Thank You for submitting the test</h1>
    </div>
    </div>



    <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
</body>

</html>