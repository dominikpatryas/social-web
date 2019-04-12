<?php
ob_start(); // Turns on output buffering
session_start();

$time = date_default_timezone_set("Europe/London");

$user = "root"; $passR = ""; $name = "localhost"; $db = "social";

$con = mysqli_connect($name, $user, $passR, $db);

if (mysqli_connect_errno()) {
    echo "Fail to connect" . mysqli_connect_errorno();
}
?>