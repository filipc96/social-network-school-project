<?php
    $error_message="";
    if(isset($_POST['login_btn'])){
        $email = filter_var($_POST['login_email'],FILTER_SANITIZE_EMAIL);

        $_SESSION['login_email'] = $email;
        $pw = md5($_POST['login_pw']);
        $check_db = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND pw='$pw'");
        $num_rows =  mysqli_num_rows($check_db);

        if ($num_rows ==1) {
            $profile_ar = mysqli_fetch_array($check_db); 
            $username = $profile_ar['username'];
            $_SESSION['username'] = $username;

            //Setovanje zapamti me kolacica
            if(!empty($_POST["remember"]))   
            {  
             setcookie("login_email",$email,time()+(86400*30));
             setcookie("login_pw",$_POST['login_pw'],time()+ (86400*30));
            }else{  
             if(isset($_COOKIE["login_email"]))   
             {  
              setcookie ("login_email","");  
             }  
             if(isset($_COOKIE["login_pw"]))   
             {  
              setcookie ("login_pw","");  
             }  
            }    



            header("Location: index.php");
            exit();
        }else{
            $error_message= "Neispravna sifra ili imejl";
        }

    }
?>