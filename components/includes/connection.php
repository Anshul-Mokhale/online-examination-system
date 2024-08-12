<?php
// $dbServername = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "starkins_vastu";

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "starkina_vastu";
$mysql_connection = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName) or die;
session_start();
date_default_timezone_set('Asia/Kolkata');
if (isset($_SESSION['email'])) {
    $email = $_SESSION["email"];
    $id = $_SESSION['id'];
} else {
    $email = "No User";
}
