<?php
    require 'includes/dbConnect.php';
    include  'includes/Users.php';
    include 'includes/Posts.php';
    include 'includes/comment.php';
    include 'includes/likes.php';
    include 'includes/header.php';
    include 'includes/load_friends.php'; 
    
    if (isset($_POST['post'])) {
        
        $post = new Post($con , $loggedInUser);
        $post->submitPost($_POST['post_text']);
    }
    
?>
    <div class="container">
        <div class="left-sidebar">
            <img src="<?php echo $user->getProfilePic()?>" alt="" class="profile-pic">
            <a href='<?php echo $loggedInUser ?>'><h2><?php
                echo $user->getFullName();
            ?></h2></a>
            <p><?php
                echo '@' . $user->getUserName();
            ?></p>
            <p>Posts: <?php
                echo $user->getNumPosts();
            ?></p>
            <p>Friends: 5</p>
            
            <a href="logout.php"><button class="btn">Odjavi se</button></a>
        </div>
        <!-- Main content -->
        <div class="main-content">
            <div class="write-post">
                <div class="write-post__user">
                    <img src="<?php echo $user->getProfilePic()?>" alt="">
                    <a href='<?php echo "$loggedInUser" ?>'>
                        <?php
                            echo $user->getFullName();
                        ?>
                    </a>
                </div>
                <!-- Form -->
                <form action="index.php" method="POST" id='post_form'class="write-post__input-container">
                    <textarea name="post_text" placeholder="Sta vam je na umu?" rows="3"></textarea>
                    <input type="submit" name='post' class="btn" value="Postavi"  id="submit_form"></input>        
                </form>
                <div class="error-message" id="error-msg"></div>
            </div>
            
            <?php
            $post = new Post($con,$loggedInUser);
            $post->loadFriendPosts();
            ?>
            
            

        </div>
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h2>Ljudi</h2>
            <?php
                loadAllPeople($con,$user);
            ?>

        </div>
    </div>

</body>
</html>