<?php
    session_start();
    session_destroy();
    header("location:register_page.php");
?>