<?php
     require 'includes/dbConnect.php';
     include  'includes/Users.php';
     include 'includes/header.php';

    if (isset($_POST['delete'])) {
        $delete_query = mysqli_query($con,"DELETE FROM users WHERE username='$loggedInUser'");
        session_start();
        session_destroy();
        header("location:register_page.php");
    }


?>
    <div class="request-page-container">
        
        <div class="request-container">
        <h2>Da li ste sigurni da zelite da izbrisete profil?</h2>
            <form  action="delete.php" method="POST">
                        <input type="submit" class="btn btn-wide" value="Da" name="delete">    
            </form>
            <a href="index.php"><button class="btn-red btn-wide">Ne</button></a></div>
    </div>
            
    

</body>
</html>