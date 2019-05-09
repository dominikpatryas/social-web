<?php

include "includes/header.php";
include "includes/classes/User.php";
include "includes/classes/Post.php";

?>


<div id="main_column" class="main_column column">

<h4>Friend requests</h4>

<?php
$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
if (mysqli_num_rows($query) == 0) {
    echo "You have no friend requests at this time!";
}
else {
    while($row = mysqli_fetch_array($query)) {
        $user_from = $row['user_from'];
        $user_from_obj = new User($con, $user_from);
        
        echo $user_from_obj->getFirstAndLastName() . " sent you a friend request.";

       $user_from_friend_array =  $user_from_obj->getFriendArray();
    }
}

?>

</div>