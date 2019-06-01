<?php

 class Notification {

    private $user_obj;
    private $con;

    function __construct($con, $user)
    {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function getUnreadNumber() {
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "SELECT * FROM Notifications WHERE user_to = '$userLoggedIn' and viewed='no'");
        return mysqli_num_rows($query);
    }

    public function insertNotification($post_id, $user_to, $type) {
        $userLoggedIn = $this->user_obj->getUsername();
        $userLoggedInName = $this->user_obj->getFirstAndLastName();

        $date_time = new DateTime("Y-m-d H:i:s");

        switch($type) {
            case 'comment':
                $message = $userLoggedIn . "commented your post";
                break;
            case 'like':
                $message = $userLoggedIn . "liked your post";
                break;
            case 'profile_post':
                $message = $userLoggedIn . "posted on your profile";
                break;
            case 'comment_non_owner':
                $message = $userLoggedIn . "commented on a post you commented on";
                break;
            case 'profile_comment':
                $message = $userLoggedIn . "commented on your profile's post";
                break;
        }

        $link = "post.php?=" . $post_id;
        $insert_query = mysqli_query($this->con, "INSERT INTO notifications VALUES ('', '$user_to', '$userLoggedIn', '$message', '$link'
        , '$date_time', 'no', 'no')");
    }
}

?>