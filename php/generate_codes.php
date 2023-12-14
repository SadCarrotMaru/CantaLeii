<?php
function generateRandomCode() 
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    for ($i = 0; $i < 8; $i++) 
        $code .= $characters[rand(0, strlen($characters) - 1)];
    
    return $code;
}

function generateUniqueCodes($n) 
{
    $codes = [];
    
    for ($i = 0; $i < $n; $i++) 
    {
        do 
        {
            $code = generateRandomCode();
        } 
        while (in_array($code, $codes)); 
        
        $codes[] = $code;
    }
    
    return $codes;
}

$servername = "mysql-neverlanes.alwaysdata.net";
$username = "336043";
$password = "m.2a*Z!#mV!9vWH";
$dbname = "neverlanes_cantaleii";
$link = mysqli_connect($servername, $username, $password, $dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}
    $codes_locs = [];
    $locs ='0';
    $codes ='0';

    for($i=0;$i<16;$i++){
        $query1 = "select qr_code from LOCATIONS WHERE location_id= ".($i+1).";";
        $query2 = "select location_name from LOCATIONS WHERE location_id= ".($i+1).";";

        //echo $query;
        $result1 = $link->query($query1);
        $result2 = $link->query($query2);
        
        if($result1->num_rows >0){
            while($row = $result1->fetch_assoc()) { 
                $codes =$row["qr_code"];
                echo $row["qr_code"]. "<br>"; 
              } 
        }
        if($result2->num_rows >0){
            while($row = $result2->fetch_assoc()) { 
                $locs =$row["location_name"];
                echo $row["location_name"]. "<br>"; 
              } 
        }
        $codes_locs[] = ($locs.' '.$codes);
    }
    for($i=0;$i<16;$i++){
        echo $codes_locs[$i]."<br>";
    }
    
    /*$generatedCodes = generateUniqueCodes(16);
    for($i=0;$i<16;$i++){
        $query = "update LOCATIONS SET qr_code ='".$generatedCodes[$i]."' WHERE location_id= ".($i+1).";";
        echo $query;
        $link->query($query);
    }*/
    
    
$metroNames = [
    'Piata Unirii',
    'Piata Victoriei',
    'Piata Romană',
    'Piata Obor',
    'Tineretului',
    'Eroilor',
    'Iancului',
    'Pantelimon',
    'Grozavesti',
    'Aparatorii Patriei',
    'Titan',
    'Dristor 1',
    'Dristor 2',
    'Republica',
    'Gara de Nord',
];

$metroLatitudes = [
    '44.4309',
    '44.4584',
    '44.4467',
    '44.4622',
    '44.4013',
    '44.4302',
    '44.4471',
    '44.4649',
    '44.4123',
    '44.3946',
    '44.4285',
    '44.4306',
    '44.4307',
    '44.4164',
    '44.4463',
];

$metroLongitudes = [
    '26.1022',
    '26.0906',
    '26.0971',
    '26.1384',
    '26.1068',
    '26.0974',
    '26.1401',
    '26.1473',
    '26.1728',
    '26.1458',
    '26.1695',
    '26.1427',
    '26.1454',
    '26.1392',
    '26.0977',
];

// You can use the $metroNames, $metroLatitudes, and $metroLongitudes arrays in your PHP code as needed.



   /* for($i=14;$i<15;$i++){
        $query = "insert into LOCATIONS (location_name, latitude, longitude) values ('".$metroNames[$i]."', '".$metroLatitudes[$i]."','".$metroLongitudes[$i]."');";
        echo $query;
        $link->query($query);
    }*/
    
    exit();


mysqli_close($link);

    
?>