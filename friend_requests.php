<?php
    require 'includes/dbConnect.php';
    include  'includes/Users.php';
    include 'includes/Posts.php';
    include 'includes/header.php';

?>
    <div class="request-page-container">
        
        <div class="request-container">
            <?php 

            $query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$loggedInUser'");

            if(mysqli_num_rows($query) ==0){
                echo "Nemate pozive za prijateljstvo";
            }
            else{
                while($row = mysqli_fetch_array($query)){
                    $user_from = $row['user_from'];
                    $user_from_obj = new User($con, $user_from);

                    echo $user_from_obj->getFullName() . " vam je poslao poziv za prijateljstvo!";

                    $user_from_friend_array = $user->getFriendArray();

                    if(isset($_POST['accept_request' . $user_from])){
                        //Azurira listu prijatelja
                        $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username = '$loggedInUser'");
                        $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$loggedInUser,') WHERE username = '$user_from'");
                        //Brise friend request
                        $delete_query= mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$loggedInUser' AND user_from = '$user_from'");
                        header("Location: index.php");


                    }
                    if(isset($_POST['decline_request' . $user_from])){
                        $delete_query= mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$loggedInUser' AND user_from = '$user_from'");
                        header("Location: index.php");
                        
                    }}
                    
                
                }
                    ?>
                    <form class="request-btn-container" action="friend_requests.php" method="POST">
                        <input type = "submit" name="accept_request<?php echo $user_from; ?>" class="btn" value ="Accept">
                        <input type = "submit" name="decline_request<?php echo $user_from; ?>" class="btn-red" value ="Ignore">
                    </form>

        </div>
    </div>
            
    

</body>
</html>