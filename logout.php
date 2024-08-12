<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
session_start();
session_unset();
session_destroy();
header("Location: login.php");
?>