<?php
function loadAllPeople($con,$user){

    
    if(isset($_GET['sort'])){
        $sort = $_GET['sort'];
    }else{
        $sort= 'DESC';
    }
    
    
    if ($sort=='DESC') {
        $str_output='<a href="?sort=ASC";>Raspored 	&uarr;</a></div>';
    }else{
        $str_output='<a href="?sort=DESC";>Raspored &darr;</a></div>';
    }
    
    $data = mysqli_query($con, "SELECT * FROM users ORDER BY first_name $sort");
    //Dok postoji output
    while($row = mysqli_fetch_array($data)){
        $user_full_name = $row['first_name'] . ' ' . $row['last_name'];
        $profile_img = $row['profile_pic'];
        $username = $row['username'];

        if ($user->getUserName() != $username) {
            $str_output.='
                <div class="friends">
                    <img src="'.$profile_img.'">
                    <div class="friends__text">
                    <a href='.$username.'>'.$user_full_name.'</a>
                        <p>Zajednicki prijatelji: 0</p>

                    </div>
                </div>';
        }
        
    }
    echo $str_output;}


function loadFriends($con,$user){

    if(isset($_GET['sort'])){
        $sort = $_GET['sort'];
    }else{
        $sort= 'DESC';
    }
    
    
    if ($sort=='DESC') {
        $str_output='<a href="?sort=ASC";>Raspored 	&uarr;</a></div>';
    }else{
        $str_output='<a href="?sort=DESC";>Raspored &darr;</a></div>';
    }
    

    $data = mysqli_query($con, "SELECT * FROM users ORDER BY first_name $sort");
    //Dok postoji output
    while($row = mysqli_fetch_array($data)){
        $user_full_name = $row['first_name'] . ' ' . $row['last_name'];
        $profile_img = $row['profile_pic'];
        $username = $row['username'];
        if ($user->isFriend($username)) {
            $str_output.='
                <div class="friends">
                    <img src="'.$profile_img.'">
                    <div class="friends__text">
                        <a href='.$username.'>'.$user_full_name.'</a>
                        <p>Zajednicki prijatelji: 0</p>
            
                    </div>
                </div>';
        }
        
            
        }
        echo $str_output;}


?>