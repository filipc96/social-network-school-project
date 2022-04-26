<?php
    require 'includes/dbConnect.php';
    include  'includes/Users.php';
    include 'includes/Posts.php';
    include 'includes/comment.php';
    //include 'includes/populate_people.php';
    include 'includes/likes.php';
    include 'includes/header.php';
    include 'includes/load_friends.php';  
    
    if (isset($_POST['post'])) {
        
        $post = new Post($con , $loggedInUser);
        $post->submitPost($_POST['post_text']);
    }


    if(isset($_GET['profile_username'])){
        $username = $_GET['profile_username'];
        //Spajamo tabele
        $join_query = mysqli_query($con,'SELECT users.friend_array,users.username, users.profile_pic, users.first_name,last_name,users.num_posts,num_likes,settings.gender,settings.country,settings.date_birth,settings.description FROM users INNER JOIN settings ON users.id=settings.user_id;');
        while ($row=mysqli_fetch_array($join_query)) {
            if ($row['username']==$username) {
                $full_name = $row['first_name'] . ' ' .$row['last_name'];
                $date_birth= $row['date_birth'];
                $description = $row['description'];

                $num_likes= $row['num_likes'];
                $num_post= $row['num_posts'];

                $gender = $row['gender'];
                $country = $row['country'];
                $profile_pic= $row['profile_pic'];

                $num_friends = (substr_count($row['friend_array'],",")) - 1;// Broj prijatelja, oduzimamo jedan zbog prvog praznog elementa
            }
        }


        if(isset($_POST['remove_friend'])){
            $user->removeFriend($username);
            header("location: index.php");
    
        }
    
        if(isset($_POST['add_friend'])){
            $user->sendFriendReq($username);
        }
    
        if(isset($_POST['respond_request'])){
            header("Location: requests.php");
        }
    }


    
    
    //$user_all_details=mysqli_fetch_array($con,$join_query);
    

    $string ='<img src="'.$profile_pic.'" alt="" class="profile-pic">
    <h2>
        '.$full_name.'
    </h2>
    <p>
    @'.$username.'
    </p>
    <p>Posts:'.$num_post.' </p>
    <p>Broj prijatelja: '.$num_friends.'</p>
    <p>Pol: '.$gender.'</p>
    <p>Datum rodjenja:'.$date_birth.' </p>
    <p>Mesto stanovanja:'.$country.' </p>
    <p>Opis:'.$description.' </p>
    ';
    
    if ($loggedInUser!=$username) {
        if ($user->isFriend($username)) {
            $string.='<form action="'.$username.'" method="POST"><input type="submit" class="btn-red" name="remove_friend" value="Ukloni Prijatelja"></input></form>';
        }
        elseif($user->didReceiveReq($username)){
            $string.='<a href="friend_requests.php"><button type="submit" class="btn-gray" value="">Prihvati prijatelja</button></a>';
        }
        
        elseif($user->didSendReq($username)){
            $string.='<a href="friend_requests.php"><button type="submit" class="btn-gray" value="">Čeka se odgovor</button></a>';
        }
        else{
            $string.='<form action="'.$username.'" method="POST"><input type="submit" class="btn" name="add_friend" value="Dodaj Prijatelja"></input></form>';}       
    }else{
        $string.='<a href="settings.php"><button class="btn">Uredi Profil</button></a>
            <a href="upload.php"><button class="btn">Promeni Sliku</button></a>
            <a href="delete.php"><button class="btn-red">Izbrisi Profil</button></a>
        ';
    }

?>
    <div class="container">
        <div class="left-sidebar">
            <?php
                echo $string;
            ?>
        </div>
        <!-- Main content -->
        <div class="main-content">
            <div class="write-post">
                <div class="write-post__user">
                    <img src="<?php echo $user->getProfilePic()?>" alt="">
                    <a href='<?php echo "profile.php?profile_username=$loggedInUser" ?>'>
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
            $post = new Post($con,$username);
            $post->loadUserPosts();
            ?>
            
            

        </div>
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h2>Prijatelji</h2>
            <?php
                loadFriends($con,$user);
            ?>

        </div>
    </div>

</body>
</html>