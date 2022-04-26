<?php

class Post {

    private $user_object;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $this->user_object = new User($con, $user);
    }

    public function submitPost($body) {
        $submit_body = strip_tags($body); // sklanjamo html tagove
        $submit_body = mysqli_real_escape_string($this->con, $submit_body);
        $check_empty = str_replace(' ', '', $body);; // Brisemo razmake da bi mogli da proverimao da li ima ikakvog teksta
        if ($check_empty != "") {

            // Vreme dodavanja
            $date_added = date("Y-m-d H:i:s");
            // Ko je dodao
            $added_by = $this->user_object->getUserName();
            //Id za strani kljuc
            $id=$this->user_object->getUserID();
            // Ubacuje post
            mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by',  '$date_added', 'no', 'no', '0','$id')");

            // Broj postova
            $num_posts = $this->user_object->getNumPosts();
            $num_posts++;
            //Azurira broj postova
            mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
            //Da ne bi pitao za ponovni post
            header("Location: index.php");
        }
    }
    
    // Ucitava postove ulogovanog korisnika i njegovih prijatelja    
    public function loadFriendPosts(){
        $str_output = "";
        $userLoggedIn = $this->user_object->getUserName();
        $data = mysqli_query($this->con, "SELECT * FROM posts ORDER BY id DESC");

        //Dok postoji output
        while($row = mysqli_fetch_array($data)){
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added']; $logged_user_obj = new User($this->con, $userLoggedIn);
            if ($logged_user_obj->isFriend($added_by) || $added_by == $logged_user_obj->getUserName()) {

                $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                $user_row = mysqli_fetch_array($user_details_query);

                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];
                $full_name = $first_name . " " . $last_name;
                $comment_count= getCommentCount($this->con,$id);
                
                //$comment_output='';
                $comment_output = getComments($this->con, $id);
                $like_output = getLikes($this->con,$id,$userLoggedIn);
                $str_output.= '
                <div class="post-container">
                    <div class="write-post__user">
                        <img src="'.$profile_pic.'" alt="">
                        <div class="text-container">
                            <a href="'.$added_by.'" ?>' . 
                                $full_name . '
                            </a>
                            <span style="font-size: 1.3rem; color:#dddd">' . $date_time. '</span>
                        </div>
                        
                        
                    </div>
                    <p>'.$body.'</p>
                    <form action="index.php" method="POST" id="post_form" class="write-post__input-container">
                    
                        
                        <input type="submit" name="post_comment" class="btn" value="Komentarisi"  id="submit_form"></input>
                        <input type="hidden" name="post_id" value="'. $id.'" />       
                    </form>
                    <div class="like-comment-container">
                        <span><button class="btn-just-text" id="comment_show">Komentari</button> ('.$comment_count.')</span>
                        '.$like_output.'
                        
                        <input type="hidden" name="post_id" value="'. $id.'" />       
                        </form>
                    </div>
                    <div class="" id="commentArea">
                        '.$comment_output.'

                    </div>
          
                </div>';  // Pre comment_output dodajemo hidden input sa vrednosti post_id-a i  zatvaramo formu iz likes.php getLikes() output-a

        }}
        echo $str_output;
    }

    //Ucitava samo postove ulogovanog korisnika
    public function loadUserPosts(){
        $str_output = "";
        $userLoggedIn = $this->user_object->getUserName();
        $data = mysqli_query($this->con, "SELECT * FROM posts ORDER BY id DESC");

        //Dok postoji output
        while($row = mysqli_fetch_array($data)){
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added']; $logged_user_obj = new User($this->con, $userLoggedIn);
            if ($added_by == $logged_user_obj->getUserName()) {

                $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                $user_row = mysqli_fetch_array($user_details_query);

                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];
                $full_name = $first_name . " " . $last_name;
                $comment_count= getCommentCount($this->con,$id);
                
                //$comment_output='';
                $comment_output = getComments($this->con, $id);
                $like_output = getLikes($this->con,$id,$userLoggedIn);
                $str_output.= '
                <div class="post-container">
                    <div class="write-post__user">
                        <img src="'.$profile_pic.'" alt="">
                        <div class="text-container">
                            <a href="$added_by" ?>' . 
                                $full_name . '
                            </a>
                            <span style="font-size: 1.3rem; color:#dddd">' . $date_time. '</span>
                        </div>
                        
                        
                    </div>
                    <p>'.$body.'</p>
                    <form action="index.php" method="POST" id="post_form" class="write-post__input-container">
                    
                        <textarea name="comment_body" placeholder="Ostavite komentar" rows="3"></textarea>
                        <input type="submit" name="post_comment" class="btn" value="Komentarisi"  id="submit_form"></input>
                        <input type="hidden" name="post_id" value="'. $id.'" />       
                    </form>
                    <div class="like-comment-container">
                        <span><button class="btn-just-text" onclick=toggleComments()>Komentari</button> ('.$comment_count.')</span>
                        '.$like_output.'
                        
                        <input type="hidden" name="post_id" value="'. $id.'" />       
                        </form>
                    </div>
                    <div class="" id="commentArea">
                        '.$comment_output.'
                    </div>
          
                </div>';  // Pre comment_output dodajemo hidden input sa vrednosti post_id-a i zatvaramo formu koju prosledjuje getLikes()

        }}
        echo $str_output;
    }
}
?>