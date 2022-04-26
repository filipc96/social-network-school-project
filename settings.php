<?php
    require 'includes/dbConnect.php';
    include  'includes/Users.php';
    include 'includes/Posts.php';
    include 'includes/header.php';

    if (isset($_POST['save_settings'])) {
        //$user_query = mysqli_query($con,"UPDATE users WHERE ");
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $description = $_POST['description'];
        

        $user_id = $user->getUserID();
        
        
        if (!empty($first_name)) {
            $update_first_name_query = mysqli_query($con, "UPDATE users SET first_name ='$first_name' WHERE username='$loggedInUser'");
        }

        if (!empty($last_name)) {
            $update_last_name_query = mysqli_query($con, "UPDATE users SET last_name ='$last_name' WHERE username='$loggedInUser'");
        }

        if (isset($_POST['gender'])) {
            $gender = $_POST['gender'];
            $update_gender_query = mysqli_query($con, "UPDATE settings SET gender ='$gender' WHERE user_id='$user_id'");
        }

        if (isset($_POST['country'])) {
            $country = $_POST['country'];
            $update_country_query = mysqli_query($con, "UPDATE settings SET country ='$country' WHERE user_id='$user_id'");
        }

        if (isset($_POST['date_birth']) ) {
            $date_birth = $_POST['date_birth'];
            if (!empty($date_birth)){
                $update_date_birth_query = mysqli_query($con, "UPDATE settings SET date_birth ='$date_birth' WHERE user_id='$user_id'");}
        }
        
        if (!empty($description)) {
            $update_description_query = mysqli_query($con, "UPDATE settings SET description='$description' WHERE user_id='$user_id'");
        }

        header('location:'.$loggedInUser.'');
    
    }

?>
    <div class="settings-page-container">
        
        <div class="settings-container">
            <form class="form" action="settings.php" method="POST">
                <h1 class="form__title">Promeni Podatke</h1>
                <div class="form__input-group">
                    <input class="form__input-field" type="text" name="first_name" placeholder="Ime">
                </div>
                <div class="form__input-group">
                    <input class="form__input-field" type="text" name="last_name" placeholder="Prezime">
                </div>
                <div class="form__input-group">
                    <select class="form__input-field" name="gender">
                        <option disabled selected value> -- Izaberite pol -- </option>
                        <option value="Muško">Muško</option>
                        <option value="Žensko">Žensko</option>
                    </select>
                </div>
                <div class="form__input-group">
                    <select class="form__input-field" name="country">
                    <option disabled selected value> -- Izaberite drzavu  -- </option>
                        <option value="Srbija">Srbija</option>
                        <option value="BiH">BiH</option>
                        <option value="Crna Gora">Crna Gora</option>
                        <option value="Hrvatska">Hrvatska</option>
                        <option value="Makedonija">Makedonija</option>
                        <option value="Slovenija">Slovenija</option>
                    </select>
                </div>
                <div class="form__input-group" >
                    <input class="form__input-field" type="date" name="date_birth"  >
                </div>
                <div class="form__input-group">
                    <textarea class="form__input-field"  name="description" placeholder="Opis" rows="6" ></textarea>
                </div>
                <div class="form__input-group">
                    <input type="submit" value="Sacuvaj" class="btn" name="save_settings" >
                </div>
                

            </form>
        </div>
    </div>
            
    

</body>
</html>