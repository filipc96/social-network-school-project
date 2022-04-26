<!DOCTYPE html>
<?php
    require 'includes/dbConnect.php';
    require 'includes/register.php';
    require 'includes/login.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/forms_style.css">

    <script src="forms.js" defer></script>

    <title>Document</title>
</head>

<body>
    <?php
        if(isset($_POST['login_btn'])) {
            echo "
            <script>
                document.addEventListener('DOMContentLoaded',()=>{

                    const loginForm = document.querySelector('#login');
                    const createForm = document.querySelector('#create');
                    
                    createForm.classList.add('form__hidden');
                    loginForm.classList.remove('form__hidden');
                
            
                })
            </script>
            ";
        }
    ?>
    <div class="container">
        <div class="panel">
            <!-- Create Account -->
            <div id="create">
                <form class="form" action="register_page.php" method="POST">
                    <h1 class="form__title">Napravite Nalog</h1>
                    <!-- First Name -->
                    <div class="error-message"><?php echo $error_messages['fname'];?></div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="text" name="reg_fname" placeholder="Ime" value="<?php
                    if (isset($_SESSION['reg_fname'])) {
                        echo $_SESSION['reg_fname'];
                    }
                    ?>" required>
                    </div>

                    <!-- Last Name -->
                    <div class="error-message"><?php echo $error_messages['lname'];?></div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="text" name="reg_lname" placeholder="Prezime" value="<?php
                            if (isset($_SESSION['reg_lname'])) {
                                echo $_SESSION['reg_lname'];
                            }
                            ?>" required>
                    </div>
                    <!-- Username -->
                    <div class="error-message"><?php echo $error_messages['username'];?></div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="text" name="reg_uname" placeholder="Korisničko Ime"
                            value="<?php
                            if (isset($_SESSION['reg_uname'])) {
                                echo $_SESSION['reg_uname'];
                            }
                            ?>" required>
                    </div>
                    <!-- Email -->

                    <div class="error-message"><?php echo $error_messages['email'];?></div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="text" name="reg_email" placeholder="Imejl" value="<?php
                            if (isset($_SESSION['reg_email'])) {
                                echo $_SESSION['reg_email'];
                            }
                            ?>" required>
                    </div>
                    <!-- Password -->
                    <div class="error-message"><?php echo $error_messages['pw'];?></div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="password" name="reg_pw" placeholder="Šifra" required>
                    </div>
                    <div class="form__input-group">
                        <input class="form__input-field" type="password" name="reg_repeatpw" placeholder="Potvrda Šifre"
                            required>
                    </div>
                    <!-- Submit button -->
                    <input class="form__button" type="submit" name="reg_btn" value="Registruj se">
                    <br>
                    <p class="form__text">
                        <a href="#" class="form__link" id="linkLogIn">Vec imate nalog?</a>
                    </p>

                </form>
            </div>
            <!-- Log in -->
            <div id="login" class="form__hidden">
                <h1 class="form__title">Ulogujte se</h1>
                <form class="form" action="register_page.php" method="POST">
                    <!-- Email -->
                    <div class="form__input-group">
                        <input class="form__input-field"  type="text" name="login_email" placeholder="Imejl" value="<?php
                            //Ako nema kolacica uzimamo e-adresu iz sesije
                            if(isset($_COOKIE["login_email"])) { echo $_COOKIE["login_email"]; }
                               else{ 
                                if (isset($_SESSION['login_email'])) {
                                    echo $_SESSION['login_email'];
                                    }}
                            ?>" 
                        required>
                    </div>
                    <!-- Password -->
                    <div class="form__input-group">
                        <input class="form__input-field" type="text" name="login_pw" placeholder="Šifra" value="<?php
                            //Ako nema kolacica uzimamo sifru iz sesije
                            if(isset($_COOKIE["login_pw"])) { echo $_COOKIE["login_pw"]; }
                            else{
                                if (isset($_SESSION['login_pw'])) {
                                    echo $_SESSION['login_pw'];
                                }
                            }
                            ?>" 
                        required>
                    </ddiv>
                    <div class="error-message"><?php echo $error_message;?></div>
                    <br>
                    <!-- Remember me -->
                    <div class="form__remeber-me">
                        <input type="checkbox" name="remember" 
                            <?php if(isset($_COOKIE["login_email"])) { echo 'checked'; } ?>>
                        <label>Zapamti me</label>
                    </div>
                    
                    <!-- Submit Button -->
                    <input class="form__button" type="submit" name="login_btn" value="Nastavite">
                    <p class="form__text">
                        <a href="#" id="linkCreateAccount">Nemate nalog? </a>
                    </p>
                    
                </form>
            </div>
        </div>

    </div>
</body>

</html>