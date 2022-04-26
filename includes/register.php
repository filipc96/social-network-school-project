<?php
//Deklaracija promenljivih
$fname = ""; //Ime
$lname = ""; //Prezime
$username = "";//Korisnicko ime
$email = ""; //Email
$pw = ""; //Sifra
$pw_repeat = ""; // Potvrda Sifre
$date = ""; //Datum
$error_messages=array('email'=> "",'username'=>"", 'pw'=>"", 'fname'=>"",'lname'=>""); // Cuva poruke o greskama

if(isset($_POST['reg_btn'])){
    // Setovanje promenljivih, strip_tag -> za sigurnost, sklanja html tagove
    //Ime
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(" ","",$fname); // sklanja razmake
    $fname = ucfirst(strtolower($fname)); // konvertuje sve u mala slova pa onda konvertuje prvo slovo u veliko
    $_SESSION['reg_fname'] = $fname;
    //Prezime
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(" ","",$lname); 
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;
    //Korisnicko ime
    $username = strip_tags($_POST['reg_uname']);
    $username = str_replace(" ","",$username);    
    $_SESSION['reg_uname'] = $username; 
    //Email
    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(" ","",$email);
    $email = strtolower($email);
    $_SESSION['reg_email'] = $email; 
    
    //Sifra
    $pw = strip_tags($_POST['reg_pw']);
    $pw_repeat = strip_tags($_POST['reg_repeatpw']);
    
    $date = date("Y-m-d"); // setuje trenutni datum

    //Potvrda i validacija sifre
    if ($pw == $pw_repeat) {

        $uppercase = preg_match('/[A-Z]/', $pw);
        $lowercase = preg_match('/[a-z]/', $pw);
        $number    = preg_match('/[0-9]/', $pw);
        $specialChars = preg_match('/[\W]/', $pw);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pw)>30 || strlen($pw)<8 ){
            $error_messages['pw'] = 'Šifra mora da ima izmedju 8 i 30 karaktera i da sadrzi jedan broj, jedno veliko slovo i jedan karakter.';
        }else{
            //code...
        }

    }else{
        $error_messages['pw'] = "Šifre se ne poklapaju";
    }

    //Validacija korisnickog imena
    if (preg_match('/[\W]/',$username)) {
        $error_messages['username'] = "Korisnicko ime ne moze da sadrzi specijalne karaktere";
        $_SESSION['reg_uname'] ="";
    }else{
        //Proveravamo da li korisnicko ime postoji
        $uname_check = mysqli_query($con, "SELECT email FROM users WHERE username='$username'");
        //Broj rezultata
        $row_result = mysqli_num_rows($uname_check);
        //
        if ($row_result > 0) {
            $error_messages['username'] = "Korisnicko ime je vec u upotrebi!";
            $_SESSION['reg_uname'] ="";
        }
    }

    //Validacija mejla
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        //Proveravamo da li imejl postoji
        $email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
        //Broj rezultata
        $row_result = mysqli_num_rows($email_check);
        //
        if ($row_result > 0) {
            $error_messages['email'] = "Imejl je vec u upotrebi!";
            $_SESSION['reg_email'] ="";
        }
    
    }else{
        $error_messages['email'] = "Los format";
        $_SESSION['reg_email'] ="";
    }

    //Validacija imena
    if (strlen($fname)<=1 || strlen($fname)>30) {
        $error_messages['fname'] = "Ime mora da bude izmedju 2 i 30 karaktera";
        $_SESSION['reg_fname'] ="";

    }

    //Validacija prezime
    if (strlen($fname)<=1 || strlen($fname)>30) {
        $error_messages['lname'] = "Prezime mora da bude izmedju 2 i 30 karaktera";
        $_SESSION['reg_lname'] ="";
    }
    
    if ($error_messages['email']=="" && $error_messages['username']=="" && $error_messages['pw']=="" && $error_messages['fname']=="" && $error_messages['lname']=="" ) {
        $pw = md5($pw);
        $profile_img = "assets/images/profile_images/default.png";
        //(id, first_name, last_name, username, email, pw,signup_date,profile_pic,num_posts,num_likes,user_closed, friend_array) 
        $sql="INSERT INTO users VALUES('' ,'$fname', '$lname', '$username', '$email', '$pw', '$date', '$profile_img', '0', '0', 'no', ',')";
        $query = mysqli_query($con, $sql);
        
        $_SESSION['username'] = $username;
        header("location:succesful_register.php");             
    }
}
?>
