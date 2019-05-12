<?php
include "includes/header.php";
include "includes/classes/User.php";
include "includes/classes/Post.php";

if (isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details_query);

    $num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
}


if (isset($_POST['remove_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->removeFriend($username);
}

if (isset($_POST['add_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->sendRequest($username);
}

if (isset($_POST['respond_request'])) {
    header("Location: requests.php");
}

?>

<style type="text/css">
.wrapper {
    padding: 0;
    margin: 0;
}

</style>


<div class="profile_left">
    <img src="<?php echo $user_array['profile_pic']; ?>" alt="">
    <div class="profile_info">
      <p>  <?php echo "Username: " . $username; ?></p>

        <p><?php echo "Posts: " . $user_array['num_posts']; ?></p>
        <p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
        <p><?php echo "Friends: " . $num_friends; ?></p>
    </div>
    <form action="<?php echo $username; ?>" method="POST">
       <?php $profile_user_obj = new User($con, $username); 
       if ($profile_user_obj->isClosed()) {
           header("Location: user_closed.php");
       }
       
       $logged_user_obj = new User($con, $userLoggedIn);

       if ($userLoggedIn != $username) {

        if ($logged_user_obj->isFriend($username)) {
            echo '<input type="submit" name="remove_friend" class="danger" value="Remove friend"><br>';
        }
        else if ($logged_user_obj->didReceiveRequest($username)) {
            echo '<input type="submit" name="respond_request" class="danger" value="Respond to request"><br>';
        }
        else if ($logged_user_obj->didSendRequest($username)) {
            echo '<input type="submit" name="" class="default" value="Request sent"><br>';
        }
        else
        echo '<input type="submit" name="add_friend" class="success" value="Add friend"><br>';
    }
       ?>

    </form>

    <input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post something">

    <?php 
    
    if ($userLoggedIn != $username) {
      echo '<div class="profile_info_bottom">';
        echo $logged_user_obj->getMutualFriends($username) . "Mutual";
          echo '</div>';
    }

    ?>

</div>




<div class="main_column column">
<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">


</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post something!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This will apear somewhere.</p>
      </div>

    <form action="" class="profile_post" method="POST">
        <div class="form_group">
            <textarea name="post_body" class="form-control"></textarea>
            <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
            <input type="hidden" name="user_to" value="<?php echo $username; ?>">

        </div>
    </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">P0ST</button>
      </div>
    </div>
  </div>
</div>

</div>

<script>
$(function(){
 
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
  var profileUsername = '<?php echo $username; ?>'
	var inProgress = false;
 
	loadPosts(); //Load first posts
 
    $(window).scroll(function() {
    	var bottomElement = $(".status_post").last();
    	var noMorePosts = $('.posts_area').find('.noMorePosts').val();
 
        // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
        if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
            loadPosts();
        }
    });
 
    function loadPosts() {
        if(inProgress) { //If it is already in the process of loading some posts, just return
			return;
		}
		
		inProgress = true;
		$('#loading').show();
 
		var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
 
		$.ajax({
			url: "includes/handlers/ajax_load_profile_posts.php",
			type: "POST",
			data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
			cache:false,
 
			success: function(response) {
				$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
				$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
				$('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 
 
				$('#loading').hide();
				$(".posts_area").append(response);
 
				inProgress = false;
			}
		});
    }
 
    //Check if the element is in view
    function isElementInView (el) {
        var rect = el.getBoundingClientRect();
 
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
        );
    }
});
 
</script>








</body>
</html>