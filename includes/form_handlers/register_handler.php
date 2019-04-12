<?php

// Declaring variables
$fname = "";
$lname = "";
$email = "";
$email2 = "";
$password = "";
$password2 = "";
$date ="";
$error_array = array();

if (isset($_POST['register_button'])) {

// REGISTRATION VALUES

$fname = strip_tags($_POST['reg_fname']);
$fname = str_replace(' ', '', $fname);
$fname = ucfirst(strtolower($fname));
$_SESSION['reg_fname'] = $fname; // Store into session variable


$lname = strip_tags($_POST['reg_lname']);
$lname = str_replace(' ', '', $lname);
$lname = ucfirst(strtolower($lname));
$_SESSION['reg_lname'] = $lname; // Store into session variable


$password = strip_tags($_POST['reg_password']);
$password2 = strip_tags($_POST['reg_password2']);
$_SESSION['reg_password'] = $password; // Store into session variable


$email = strip_tags($_POST['reg_email']);
$email = str_replace(' ', '', $email);
$email = ucfirst(strtolower($email));
$_SESSION['reg_email'] = $email; // Store into session variable


$email2 = strip_tags($_POST['reg_email2']);
$email2 = str_replace(' ', '', $email2);
$email2 = ucfirst(strtolower($email2));
$_SESSION['reg_email2'] = $email2; // Store into session variable


$date = date("Y-m-d"); // current date

if ($email == $email2) {

if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $em_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

    $num_rows = mysqli_num_rows($em_check);

    if ($num_rows > 0) {
        echo array_push($error_array, "Email already in use<br>");
    }
} else array_push($error_array, "Invalid email format<br>");

} else array_push($error_array,"Emails don't match!<br>");

if(strlen($fname) > 25 || strlen($fname) < 2) {
    array_push($error_array,"Too long or too short first name<br>");
}

if(strlen($lname) > 25 || strlen($lname) < 2) {
    array_push($error_array,"Too long or too short last name<br>");
}

if($password != $password2) {
    array_push($error_array,"Passwords do not match<br>");
} else {
    if(preg_match('/[^A-Za-z0-9]/', $password)) {
        array_push($error_array,"Your password can only contain english characters or numbers<br>");
    }
}

if (strlen($password > 30 || strlen($password) < 5)) {
    array_push($error_array,"Your password must be between 5 and 30 characters<br>");
}

if (empty($error_array)) {
    $password = md5($password); // Encrypt password before sending to database
// generate username by concatenating first name and last name
    $username = strtolower($fname . "_" . $lname);
    $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

    $i = 0;
// if username exists add a number
    while(mysqli_num_rows($check_username_query) != 0) {
        $i++;
        $username = $username . "_" . $i;
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
    }

    // Profile picture managment
    $rand = rand(1, 2); 

    if ($rand == 1)
    $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";

    else if ($rand == 2) {
    $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png"; }

    $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

    array_push($error_array, "<span style='color: #14C800;'> You registered correctly. </span><br>");

    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
} 


}

?>