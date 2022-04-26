<?php
//Pocetak sesije
session_start();
//Konfiguracija baze
$host = "localhost";
$uname="root";
$db="social_db";
$pw = "";

try {
    $con = mysqli_connect($host, $uname,$pw);
} catch (Exception $e) {
    echo "Failed to connect to mysql server: " ;
    echo $e;
}

// Pravimo bazu ako ne postoji
if ($con) {
    $create_db = mysqli_query($con,"CREATE DATABASE IF NOT EXISTS $db");
}

// Selektujemo bazu
try {
    $database = mysqli_select_db($con, $db);
} catch (Exception $e) {
    echo "Failed to connect database: " ;
    echo $e;
}
if ($database) {
    //Pravimo tabele
    $create_user_table = mysqli_query($con,
        "CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            first_name varchar(30) NOT NULL,
            last_name varchar(30) NOT NULL,
            username varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            pw varchar(255) NOT NULL,
            signup_date date NOT NULL,
            profile_pic varchar(255) NOT NULL,
            num_posts int(11) NOT NULL,
            num_likes int(11) NOT NULL,
            user_closed varchar(3) NOT NULL,
            friend_array text NOT NULL
        )");
    $create_posts_table = mysqli_query($con,
        "CREATE TABLE IF NOT EXISTS posts (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        body text NOT NULL,
        added_by varchar(60) NOT NULL,
        date_added datetime NOT NULL,
        user_closed int(3) NOT NULL,
        deleted int(11) NOT NULL,
        likes int(11) NOT NULL,
        user_id int(11) NOT NULL
        )");


    $create_comments_table = mysqli_query($con,
        "CREATE TABLE IF NOT EXISTS comments (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        post_body text NOT NULL,
        posted_by varchar(60) NOT NULL,
        posted_to varchar(60) NOT NULL,
        date_added date NOT NULL,
        removed varchar(3) NOT NULL,
        post_id int(11) NOT NULL
        )");

    $create_likes_table = mysqli_query($con,
        "CREATE TABLE IF NOT EXISTS likes (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(60) NOT NULL,
        post_id int(11) NOT NULL
        )");

    $create_friend_request_table=mysqli_query($con,
        "CREATE TABLE IF NOT EXISTS friend_requests (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_to varchar(100) NOT NULL,
        user_from varchar(100) NOT NULL)");

    $create_settings_table=mysqli_query($con,
    "CREATE TABLE IF NOT EXISTS settings (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        gender varchar(1) NOT NULL,
        country varchar(30) NOT NULL,
        date_birth date NOT NULL,
        description text NOT NULL,
        user_id int(11) NOT NULL) ");

    $add_fkey_comments = mysqli_query($con,"
        ALTER TABLE comments ADD FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE; ");
    
    $add_fkey_likes = mysqli_query($con,"
        ALTER TABLE likes ADD FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE; ");

    $add_fkey_settings = mysqli_query($con,"
        ALTER TABLE settings ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE; ");
    

    $add_fkey_posts = mysqli_query($con,"
        ALTER TABLE posts ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE; ");
}




?>