<?php
     require 'includes/dbConnect.php';
     include  'includes/Users.php';
     include 'includes/header.php';

    if (isset($_POST['upload'])) {
        $image = $_FILES['image'];

        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name']; 
        $image_size = $_FILES['image']['size']; 
        $image_error = $_FILES['image']['error'];    
        
        $file_ext = explode('.',$image_name); 
        $file_actual_ext = strtolower(end($file_ext));
        
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($file_actual_ext,$allowed)) {
            if($image_error===0){
                if($image_size<1000000000){
                    $image_new_name = $user->getUserName().$file_actual_ext;
                    $file_destination = 'assets/images/profile_images'.$image_new_name;
                    move_uploaded_file($image_tmp_name,$file_destination);

                    $update_pic_query = mysqli_query($con,"UPDATE users SET profile_pic='$file_destination' WHERE username='$loggedInUser'");

                    header("location: $loggedInUser");
                }else{echo "Previse velika datoteka";}
            }else{
                echo "Greska pri postavljanju slike";
            }
        }else{
            echo "Losa ekstenzija fajla";
        }
    }

?>
    <div class="settings-page-container">
        
        <div class="settings-container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="image">
                    <button class="btn" type="submit" name="upload"> Promeni</button>
                </form>
        
        </div>
    </div>
            
    

</body>
</html>