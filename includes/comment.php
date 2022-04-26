<?php
// GetId
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_query = mysqli_query($con, "SELECT added_by FROM posts WHERE id='$post_id'");
    $row = mysqli_fetch_row($user_query);
    $posted_to = $row[0];
    $posted_by = $_SESSION['username'];

    if (isset($_POST['post_comment'])) {
        $comment_body = mysqli_escape_string($con, $_POST['comment_body']);
        if (!empty($comment_body)) {
            $date_time_now = date("Y-m-d H:i:s");
            $insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$comment_body', '$posted_by', '$posted_to', '$date_time_now', 'no', '$post_id')");
            //Da ne bi pitao za ponovni post
            header("Location: index.php");
        }
    }
}

//Povlacimo broj komentara
function getCommentCount($con,$post_id){
    $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
    $count = mysqli_num_rows($get_comments);
    return $count;
}
// Povlacenje komentara
function getComments($con, $post_id){
    $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
    $count = getCommentCount($con,$post_id);
    // Load comments
    
    $comment_str = ''; 
    if ($count != 0) {
    while ($comment = mysqli_fetch_array($get_comments)) {
        $comment_body = $comment['post_body'];
        $posted_by = $comment['posted_by'];
        $date_added = $comment['date_added'];
        $user_obj = new User($con, $posted_by);
        $profile_p = $user_obj->getProfilePic();
        $name_full = $user_obj->getFullName();
        
        $comment_str .= '
        
        <div class="comment-container">
            <div class="write-post__user">
                <img src="'.$profile_p.'">
                <div class="text-container">
                    <a href="'. $posted_by.' ?>">'.$name_full.'</a>
                    <span style="font-size: 1.3rem; color:#dddd">' . $date_added . '</span>
                </div>
                </div>
             <p>'.$comment_body.'<p>
             
        </div>';
       
    } return $comment_str;}else {
            $comment_str .= '<center><br><br>Nema komentara da se prilaze</center>';
            return $comment_str;
        }
}

?>