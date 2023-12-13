<?php
$servername = "mysql-neverlanes.alwaysdata.net";
$username = "336043";
$password = "m.2a*Z!#mV!9vWH";
$dbname = "neverlanes_cantaleii";


function same_location($lat1, $lon1, $lat2, $lon2)
{
    $LOCATION_ERROR = 500; // in meters, change if you want a lower threshold
	$distance = calculateDistance($lat1, $lon1, $lat2, $lon2);
    echo $distance;
	if ($distance <= $LOCATION_ERROR) return true;
	return false;
}


function calculateDistance($lat1, $lon1, $lat2, $lon2) 
{
    $earthRadius = 6371000; // Earth radius in meters
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;
    return $distance;
}

// Create connection
require "header.php";
$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit();
}

$ok = false;
if(count($_POST)>0) {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $ok = true;
}
else if(count($_GET)>0){
    $username=$_GET['username'];
    $password=$_GET['password'];
    $ok = true;
}

if($ok){
  
    $query="select * from CLIENTS where UPPER(username) = UPPER('".$username."') and password = '".$password."';";
    $result = $link->query($query);

    if($result->num_rows >0){
        //session_start();
        $_SESSION["username"]=$username;
        $row = $result->fetch_assoc();
        $_SESSION["client_id"]=$row['client_id'];
        
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
            
            //check if the request is being made from the qr code's location
            $q_locatie="select latitude, longitude from LOCATIONS where location_id = ".$location_id.";";

            $ans_locatie = $link->query($q_locatie);
            if($ans_locatie->num_rows > 0) {
                while ($row = $ans_locatie->fetch_assoc()) {
                    $targetlatitude = $row["latitude"];
                    $targetlongitude = $row["longitude"];
                }
            }
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            
            if(same_location($latitude,$longitude,$targetlatitude,$targetlongitude) == true)
            {
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
                $q4 ="insert into ECO_POINTS_HISTORY values(".$_SESSION["client_id"].", ".$location_id.",'".$date."');";
                $link->query($q4);

                //then we redirect to livada de meri
                $_SESSION['qrcode']='none';
                header("Location: eco.php");
            }
            else{
                $_SESSION['qrcode']='none';
                //is not valid
                echo "you re on timeout!";
                $_SESSION['timeout']='true';
                header("Location: main.php");
            }
            }
                else
                {
                    $_SESSION['qrcode']='none';
                    //not valid -- location failed
                    echo "you are not near the qr code!";
                    $_SESSION['baddistance']='true';
                    header("Location: index.php");
                }

            echo same_location($latitude,$longitude,$targetlatitude,$targetlongitude);
        }
        else{
            echo $_SESSION['qrcode'];
            header("Location: main.php");
        }
        
    }
    else{
        $_SESSION['badlogin']='true';
        header("Location: index.php");
    }
    exit();

}
else{
    $_SESSION['badlogin']='true';
    header("Location: index.php");
    exit();
}
mysqli_close($link);

?>

