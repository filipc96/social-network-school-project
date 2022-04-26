<?php
class User {

    private $user;
    private $conn;

    public function __construct($con, $user) {
        $this->conn = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }
    
    public function getUserID() {
        return $this->user['id'];
    }

    public function getUserName() {
        return $this->user['username'];
    }
    
    public function getNumPosts() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT num_posts FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    }

    public function getFullName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
    public function isFriend($username_to_check) {
        $usernameComma = "," . $username_to_check . ",";
        if (strstr($this->user['friend_array'], $usernameComma)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getProfilePic() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT profile_pic FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['profile_pic'];
    }

    public function getNumLikes(){
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT num_likes FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_likes'];
    }

    public function didReceiveReq($user_from){
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->conn, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");

		if(mysqli_num_rows($check_request_query) > 0){
			return true;
		}
		else{
			return false;
		}

	}

	public function didSendReq($user_to){
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->conn, "SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");

		if(mysqli_num_rows($check_request_query) > 0){
			return true;
		}
		else{
			return false;
		}

	}

	public function removeFriend($user_to_remove){
		$logged_in_user = $this->user['username'];
		$query = mysqli_query($this->conn, "SELECT friend_array FROM users WHERE username='$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_username = $row['friend_array'];

		$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
		$remove_friend = mysqli_query($this->conn, "UPDATE users SET friend_array='$new_friend_array' WHERE username = '$logged_in_user'");

		$new_friend_array = str_replace($logged_in_user . ",", "", $friend_array_username);
		$remove_friend = mysqli_query($this->conn, "UPDATE users SET friend_array='$new_friend_array' WHERE username = '$user_to_remove'");

	}

	public function sendFriendReq($user_to){
		$user_from = $this->user['username'];
		$query= mysqli_query($this->conn, "INSERT INTO friend_requests VALUES('','$user_to', '$user_from')");

	}

    public function getFriendArray() {
		$username = $this->user['username'];
		$query = mysqli_query($this->conn, "SELECT friend_array FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['friend_array'];
	}


} ?>