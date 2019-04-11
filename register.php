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
$error_array = "";

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
        echo "Email already exists!";
    }
} else echo "Invalid Format";

} else echo "Emails don't match!";

if(strlen($fname) > 25 || strlen($fname) < 2) {
    echo "Too long or too short first name";
}

if(strlen($lname) > 25 || strlen($lname) < 2) {
    echo "Too long or too short last name";
}

if($password != $password2) {
    echo "Passwords do not match";
} else {
    if(preg_match('/[^A-Za-z0-9]/', $password)) {
        echo "Your password can only contain english characters or numbers";
    }
}

if (strlen($password > 30 || strlen($password) < 5)) {
    echo "Your password must be between 5 and 30 characters";
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
        }
         ?>" required>
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        }
         ?>"  required>
        <br>

        <input type="email" name="reg_email" placeholder="Email" value="<?php
        if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
        }
         ?>"  required>
        <br>

        <input type="email" name="reg_email2" placeholder="Confirm email" value="<?php
        if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
        }
         ?>"  required>
        <br>
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <input type="submit" name="register_button" value="Register">
    </form>


</body>



</html>