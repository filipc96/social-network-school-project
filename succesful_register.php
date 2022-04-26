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
    <div class="container">
        <div class="panel">
            <div style="text-align: center; margin-bottom:2rem;">
                <h2 style="color:var(--color-success);">Uspesna registracija</h2>
                <?php
                        echo 'Korisnicko ime: ' . $_SESSION['reg_uname'] .'<br>';
                        echo 'Ime: ' . $_SESSION['reg_fname'] .'<br>';
                        echo 'Prezime ime: ' . $_SESSION['reg_lname'] .'<br>';
                        echo 'E-adresa: ' . $_SESSION['reg_email'] .'<br>';
                    ?>
            </div>
           
            <button class="form__button" id="continue_btn" onClick=
            >Nastavite</button>

            <script type="text/javascript">
                document.getElementById("continue_btn").onclick = function () {
                    location.href = "index.php";
                };
            </script>
                
            
            
        </div>

    </div>
</body>

</html>