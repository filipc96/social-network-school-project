<!DOCTYPE html>

<?php
// Proveravamo da li ima korisnika da ne bi prijavio gresku vec preusmerio na register_page.php
$are_there_users = mysqli_query($con,'SELECT * FROM users');
$row_number = mysqli_num_rows($are_there_users);
if ($row_number<1) {
    header("Location: register_page.php");
}else{
    if (isset($_SESSION['username'])) {
        //Ciscenje sesija registracije
        $_SESSION['reg_uname'] ="";
        $_SESSION['reg_fname'] ="";
        $_SESSION['reg_lname'] ="";
        $_SESSION['reg_email'] ="";

        $loggedInUser = $_SESSION['username'];
        $user = new User($con, $loggedInUser);
        $userID = $user->getUserID();
        // Inicijalizacija podesvanja korisnika ako ne postoje podesavanja sa tim id-om
        $check_db = mysqli_query($con, "SELECT * FROM settings WHERE user_id=$userID");
        $num_rows =  mysqli_num_rows($check_db);

        if($num_rows<1){
            mysqli_query($con, "INSERT INTO settings VALUES('', '','','','', $userID)");
        }

    }else{
        header("Location: register_page.php");
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="main.js" defer></script>

    <title>Social</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav__left">
                <a href="index.php"><img src="assets/images/logo_social.png" class="logo" ></a>
                <ul>
                    <li><img src="assets/images/notification.png" alt=""></li>
                    <li><a href="friend_requests.php"><img src="assets/images/friends.png" alt=""></a></li>
                    <li><a href="logout.php"><img src="assets/images/logout.png" alt=""></a></li>
                    
                </ul>
            </div>
            <div class="nav__right">
                <div class="search-box">   
                    <img src="assets/images/search.png" alt="">
                    <input type="text" placeholder="Pretraga" name="" id="search-box-input"></input>
            </div>
                <div class="user-icon">
                <a href='<?php echo $loggedInUser ?>'> <img src="<?php echo $user->getProfilePic()?>" alt=""></a>
                </div>
            </div> 
        </nav>
    </header>

