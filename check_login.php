<?php
$servername = "mysql-neverlanes.alwaysdata.net";
$username = "336043";
$password = "m.2a*Z!#mV!9vWH";
$dbname = "neverlanes_cantaleii";

// Create connection

// print_r($_POST);
$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

if(count($_POST)>0) {
    $username=$_POST['username'];
    $password=$_POST['password'];
    // echo $username;
    // echo $password;
    $query="select * from CLIENTS where UPPER(username) = UPPER('".$username."') and password = '".$password."';";

    $result = $link->query($query);
    //print_r ($result);
    if($result->num_rows >0){
        session_start();
        $_SESSION["username"]=$username;
        $row = $result->fetch_assoc();
        $_SESSION["client_id"]=$row['client_id'];
        echo "OK!";
        header("Location: main.php");
    }
    else{
        echo "Nu am gasit acest username cu aceasta parola ;(";
    }
    // header("Location: login_check.php");		
    exit();

}
mysqli_close($link);

?>

