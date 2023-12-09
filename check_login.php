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
    $username=$_POST['username'];
    $password=$_POST['password'];
    //$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //$code= $_GET['qrcode'];
    // echo $username;
    // echo $password;
    $query="select * from CLIENTS where UPPER(username) = UPPER('".$username."') and password = '".$password."';";

    $result = $link->query($query);
    //print_r ($result);
    if($result->num_rows >0){
        //session_start();
        $_SESSION["username"]=$username;
        $row = $result->fetch_assoc();
        $_SESSION["client_id"]=$row['client_id'];
        echo $_SESSION['qrcode'];
        //header("eco.html");
        if($_SESSION['qrcode']!='none'){
            //database stuff

            //get the location id from the qrcode
            $actual_qr = str_replace('"', '', urldecode($_SESSION['qrcode']));
            $q0="select location_id from LOCATIONS WHERE qr_code='".$actual_qr."';";
            echo $q0;
            $location_id_res = $link->query($q0);
            $location_id=-1;
            
            if($location_id_res->num_rows >0){
                while($row = $location_id_res->fetch_assoc()) { 
                    $location_id =$row["location_id"];
                    echo $row["location_id"]. "<br>"; 
                  } 
            }
            
            //get most recent acces from client in that station
            $q1="select max(time) from ECO_POINTS_HISTORY where client_id =".$_SESSION["client_id"]." and location_id= '".$location_id."';";
            $recent_res = $link->query($q1);
            $most_recent=-1;
            if($recent_res->num_rows >0){
                while($row = $recent_res->fetch_assoc()) { 
                    $most_recent=$row["max(time)"];
                    echo $row["max(time)"]. "<br>"; 
                  } 
            }
            //check if the station is not timed out (not used in the same day)
            //get current time
            $date = date('Y-m-d');
            if($date != $most_recent){ 
                //is valid
                //we add a point to travel points and a entry in history of travels
                $eco_pts=1;
                $acc_id=-1;
                $q2 = "select eco_travel_points, a.account_id FROM CLIENTS c join ACCOUNTS a on (c.client_id = a.client_id) join ACC_IS_ECO e on (a.account_id=e.account_id) WHERE c.client_id='".$_SESSION["client_id"]."';";
                $res = $link->query($q2);
                
                if($res->num_rows >0){
                    while($row = $res->fetch_assoc()) { 
                        print_r($row);
                        $eco_pts+=$row["eco_travel_points"];
                        $acc_id = $row["account_id"];
                        echo $row["eco_travel_points"]. "<br>"; 
                      } 
                }
                $q3 ="update ACC_IS_ECO set eco_travel_points = ".$eco_pts." WHERE account_id =".$acc_id.";";
                $link->query($q3);
                echo $date;
                echo $most_recent;
                $q4 ="insert into ECO_POINTS_HISTORY values(".$_SESSION["client_id"].", ".$location_id.", '".$date."');";
                echo $q4;
                $link->query($q4);
                //then we redirect to livada de meri
                ///next
                $_SESSION['qrcode']='none';
                $_SESSION['badlogin']='false';
                header("Location: eco.html");
            }
            else{
                $_SESSION['timeout']='true';
                $_SESSION['badlogin']='false';
                //is not valid
                $_SESSION['qrcode']='none';
                echo "you re on timeout!";
                header("Location: index.php");	
            }

            
        }
        else{
            header("Location: main.php");
        }
        
    }
    else{
        $_SESSION['badlogin']='true';
        echo "Nu am gasit acest username cu aceasta parola ;(";
        header("Location: index.php");	
    }
    // header("Location: login_check.php");		
    exit();

}
mysqli_close($link);

?>

