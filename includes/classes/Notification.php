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
}

?>