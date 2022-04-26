<?php
$session_username =$loggedInUser = $_SESSION['username'];
$user_object= new User($con,$loggedInUser);
$userLoggedIn = $user_object->getUserName();
$likes = $user_object->getNumLikes();

// Get id of post
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    
    $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['added_by'];

    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
    $row = mysqli_fetch_array($user_details_query);
    $total_user_likes = $row['num_likes'];
    
    // Like Button
    if (isset($_POST['like_button'])) {
        $total_likes++;
        
        $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
        $total_user_likes++;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "INSERT INTO likes VALUES('','$userLoggedIn','$post_id')");
        
        header("location: index.php");

    }

    // Unlike Button
    if (isset($_POST['unlike_button'])) {
        $total_likes--;
        $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
        $total_user_likes--;
        $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
        $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");

        header("location: index.php");
    }
}
    
    
// Funkcija za output lajkuj dugmeta i broja lajkova
function getLikes($con, $post_id,$userLoggedIn){
    $like_str='';

    $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    // Check for previous likes
    $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
    $num_rows = mysqli_num_rows($check_query);

    if ($num_rows > 0) {
        $like_str .=  '<form action="index.php" method="POST"><input type="submit" class="btn-just-text" name="unlike_button" value="Unlike"><label> (' . $total_likes . ')<label>';
    } else {
        $like_str .=  '<form action="index.php" method="POST"><input type="submit" class="btn-just-text" name="like_button" value="Like"><label> (' . $total_likes . ')</label>';
    }
    return $like_str;
}
?>