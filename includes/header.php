<?php

require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");


if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else {
    header("Location: register.php");
}

?>


<html>
<head>
<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="assets/js/bootstrap.js"> </script>
<script src="assets/js/bootbox.min.js"> </script>
<script src="assets/js/demo.js"> </script>
<script src="assets/js/jcrop_bits.js"> </script>
<script src="assets/js/jquery.Jcrop.js"> </script>

<!-- CSS -->

<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>

<body>
    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Swirlfeed</a>
        </div>
       <nav>

        <?php
            $notifications = new Notification($con, $userLoggedIn);
            $num_notifications = $notifications->getUnreadNumber();
        ?>


       <a href="<?php echo $userLoggedIn ?>">
               <?php echo $user['first_name']; ?>
            </a>
           <a href="index.php">
               <i class="fa fa-home fa-lg"></i></a>
           <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn ?>', 'message')">
               <i class="fa fa-envelope fa-lg"></i>
                
            </a>
           <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn ?>', 'notification')">
               <i class="fa fa-bell-o fa-lg"></i>
               <?php
                   echo '<span class="notification-badge" id="unread_notification">' . $num_notifications . '</span>';
                ?></a>
            <a href="requests.php">
               <i class="fa fa-users fa-lg"></i></a>
           <a href="#">
               <i class="fa fa-cog fa-lg"></i></a>
            <a href="includes/handlers/logout.php">
                <i class="fa fa-sign-out-alt fa-lg"></i></a>
       </nav>

        <div class="dropdown_data_window">
            <input type="hidden" id="dropdown_data_type" value="">
        </div>

    </div>

    <div class="wrapper">
