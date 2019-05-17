<?php

include("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if (isset($_GET['u'])) {
    $user_to = $_GET['u'];
} else {
    $user_to = $message_obj->getMostRecentUser();
    if ($user_to == false) 
        $user_to = 'new';
}

if ($user_to != "new") {
    $user_to_obj = new User($con, $user_to);
}

    if (isset($_POST['post_message'])) {

        if (isset($_POST['message_body'])) {
            $body = mysqli_real_escape_string($con, $_POST['message_body']);
            $date = date("Y-m-d H:i:s");
            $message_obj->sendMessage($user_to, $body, $date);
        }
    }
?>


<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $user['num_posts']. "<br>"; 
			echo "Likes: " . $user['num_likes'];

			?>
		</div>

    </div>
    
    <div class="main_column column">
        <?php 
            if ($user_to != "new") {
                echo "<h4> You and <a href='$user_to'>" . $user_to_obj->getFirstAndLastName() . "</a></h4><hr><br>";
                echo "<div class='loaded_messages' id='scroll_message'>";
                echo $message_obj->getMessages($user_to);
                echo "</div>";
            }
            else {
                echo "<h4>New message</h4>";
            }
        ?>


<div class="messages_post">
    <form action="" method="POST">
        <?php
            if ($user_to == "new") {
                echo "Select friend";
                echo "To: <input type='text'>";
                echo "<div class='results'></div>";
            } 
            else {
                echo "<textarea name='message_body' id='message_area' placeholder='Write you message.....'> </textarea>";
                echo "<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>";
            }
        ?>
    </form>
</div>

<script>
                    // Scroll to newest message
    var div = document.getElementById("scroll_message");
    div.scrollTop = div.scrollHeight;
</script>

       
    </div>

    <div class="user_details column" id="conversations">
            <h4>Conversations</h4>

            <div class="loaded_conversations">
                <?php 
                    echo $message_obj->getConvos();
                ?>
                <br>
                <a href="messages.php?u=new"> New Message</a>
            </div>
        </div>