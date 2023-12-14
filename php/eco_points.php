<?php
$servername = "mysql-neverlanes.alwaysdata.net";
$username = "336043";
$password = "m.2a*Z!#mV!9vWH";
$dbname = "neverlanes_cantaleii";

// Create connection
require "header.php";
echo $_SESSION['username'];
echo $_SERVER['REQUEST_URI'];
echo $_SERVER['PHP_SELF'];
echo $_SERVER['HTTP_REFERER'];
//echo $_SERVER['HTTPS'];
// print_r($_POST);

$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

mysqli_close($link);

?>

