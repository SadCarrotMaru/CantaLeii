<?php


$servername = "mysql-neverlanes.alwaysdata.net";
$username = "336043";
$password = "m.2a*Z!#mV!9vWH";
$dbname = "neverlanes_cantaleii";

// Create connection
require "header.php";
// print_r($_POST);
$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

if(count($_POST)>0) {
    $ruoption = $_POST['roundupopt'];
    $ecoper = $_POST['percent'];
    $password = $_POST['password'];
    $query="select * from CLIENTS where UPPER(username) = UPPER('".$_SESSION['username']."') and password = '".$password."';";

    $result = $link->query($query);
    //print_r ($result);
    if($result->num_rows >0){
        echo $ruoption;
        if($ruoption=='activ'){
            $ruoption=1;
        }
        else{
            $ruoption=0;
        }
        echo $ecoper;
        $query = "update ACCOUNTS set roundup = ".$ruoption." where client_id = ".$_SESSION['client_id'].";";
        $link ->query($query);
        $query ="select account_id from ACCOUNTS where account_type_id=3 and client_id =".$_SESSION['client_id'].";";
        $r = $link->query($query);
        $acc_id = -1;
        if($r->num_rows>0){
            while($row = $r->fetch_assoc()) { 
                $acc_id =$row["account_id"];
                //echo $row["sold"]. "<br>"; 
              } 
        }
        $query = "update ACC_IS_ECO set eco_roundup_percent =".$ecoper." where account_id =".$acc_id.";";
        echo $query;
        $link->query($query);
    }

}
mysqli_close($link);



?>