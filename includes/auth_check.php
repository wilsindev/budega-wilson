<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: ../pages_users/logar.php");
        exit;
    } 
?>
