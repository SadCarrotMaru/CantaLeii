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

    $generatedCodes = generateUniqueCodes(16);
    for($i=0;$i<16;$i++){
        $query = "update LOCATIONS SET qr_code ='".$generatedCodes[$i]."' WHERE location_id= ".($i+1).";";
        echo $query;
        //$link->query($query);
    }
    
    
$metroNames = [
    'Piața Unirii',
    'Piața Victoriei',
    'Piața Romană',
    'Piața Obor',
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