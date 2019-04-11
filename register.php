<?php
session_start();

$user = "root"; $passR = ""; $name = "localhost"; $db = "social";

$con = mysqli_connect($name, $user, $passR, $db);

if (mysqli_connect_errno()) {
    echo "Fail to connect" . mysqli_connect_errorno();
}

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




}


?>




<html>

<head>

</head>



<body>

    <form action="register.php" method="POST">

        <input type="text" name="reg_fname" placeholder="First Name" value="<?php
        if(isset($_SESSION['reg_fname'])) {
            echo $_SESSION['reg_fname'];
        } ?>" required>
        <br>

        <?php if (in_array("Too long or too short first name", $error_array)) echo "Too long or too short first name<br>"; ?>

        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        } ?>" required>
        <br>

        <?php if (in_array("Too long or too short last name<br>", $error_array)) echo "Too long or too short last name<br>"; ?>


        <input type="email" name="reg_email" placeholder="Email" value="<?php
        if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
        } ?>" required>
        <br>

        <input type="email" name="reg_email2" placeholder="Confirm email" value="<?php
        if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
        } ?>" required>
        <br>

        <?php if (in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
        else if (in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>"; 
        else if (in_array("Emails don't match!<br>", $error_array)) echo "Emails don't match!<br>"; ?>


        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>

        <?php if (in_array("Passwords do not match<br>", $error_array)) echo "Passwords do not match<br>"; 
        else if (in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>"; 
        else if (in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>"; ?>

        <input type="submit" name="register_button" value="Register">
    </form>


</body>



</html>