<?php
session_start();
    $_SESSION["username"]=-1;
    $_SESSION["client_id"]=-1;
    echo "OK!";
    header("Location: ../index.php");
 
?>

