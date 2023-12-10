<?php

function set_card_session($acc_id,$iban,$cnum,$valid,$cvc,$sold,$acc_type){
    $_SESSION['acc_id']=$acc_id;
    $_SESSION['iban']=$iban;
    $_SESSION['cnum']=$cnum;
    $_SESSION['valid']=$valid;
    $_SESSOIN['cvc']=$cvc;
    $_SESSION['sold']=$sold;
    $_SESSION['acc_type']=$acc_type;
}
function close_card_session(){
    $_SESSION['acc_id']=-1;
    $_SESSION['iban']=-1;
    $_SESSION['cnum']=-1;
    $_SESSION['valid']=-1;
    $_SESSOIN['cvc']=-1;
    $_SESSION['sold']=-1;
    $_SESSION['acc_type']=-1;
}
function get_card_data($client){
    $servername = "mysql-neverlanes.alwaysdata.net";
    $username = "336043";
    $password = "m.2a*Z!#mV!9vWH";
    $dbname = "neverlanes_cantaleii";
    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (!$link) {
        echo "Error: Unable to connect to MySQL.";
        exit;
    }
    /*if(!isset($_SESSION['client_id'])){
        $_SESSION['client_id']=1;
    }*/
    $acc_id=-1;
    $iban=-1;
    $cnum=-1;
    $valid=-1;
    $cvc=-1;
    $sold=-1;
    $acc_type=-1;
    $q1="select account_id, IBAN, card_number, valid_thru, cvc, sold,account_type_id FROM ACCOUNTS where client_id = '".$client."' and account_type_id = 1;";
    $res = $link->query($q1);
                    
    if($res->num_rows >0){
        while($row = $res->fetch_assoc()) { 
            $acc_id=$row["account_id"];
            $iban=$row["IBAN"];
            $cnum=$row["card_number"];
            $valid=$row["valid_thru"];
            $cvc=$row["cvc"];
            $sold=$row["sold"];
            $acc_type=$row['account_type_id'];
            print_r($row["account_id"]. "<br>"); 
            print_r($row["IBAN"]. "<br>"); 
            print_r($row["card_number"]. "<br>"); 
            print_r($row["valid_thru"]. "<br>"); 
            print_r($row["cvc"]. "<br>"); 

        } 
    }
    set_card_session($acc_id,$iban,$cnum,$valid,$cvc,$sold,$acc_type);
    mysqli_close($link);
}

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
    $suma_dorita=$_POST['suma'];
    $iban_dest=$_POST['dest'];
    $parola=$_POST['password'];
    $query="select * from CLIENTS where UPPER(username) = UPPER('".$_SESSION['username']."') and password = '".$parola."';";

    $result = $link->query($query);
    //print_r ($result);
    if($result->num_rows >0){
        get_card_data($_SESSION['client_id']);
        //verificam ca putem sa transferam bani din contul curent
        if($suma_dorita<= $_SESSION['sold']){
            echo "se poate";
            //transferam banii
            $q="select sold from ACCOUNTS where IBAN ='".$iban_dest."';";
            $r= $link->query($q);
            $sold_nou=$suma_dorita;
            if($r->num_rows>0){
                while($row = $r->fetch_assoc()) { 
                    $sold_nou +=$row["sold"];
                    echo $row["sold"]. "<br>"; 
                  } 
            }

            $query="UPDATE ACCOUNTS set sold =".$sold_nou." where IBAN ='".$iban_dest."';";
            $link->query($query);

            //scadem banii din cont
            $query="UPDATE ACCOUNTS set sold =".($_SESSION['sold']-$suma_dorita)." where IBAN ='".$_SESSION['iban']."';";
            $link->query($query);

            //vedem account_id de la second_party
            $qu="select account_id from ACCOUNTS where iban ='".$iban_dest."';";
            $r =$link->query($qu);
            if($r->num_rows>0){
                while($row = $r->fetch_assoc()) { 
                    $acc_dest=$row["account_id"];
                    echo $row["account_id"]. "<br>"; 
                  } 
            }

            //adaugam in tranzactii
            $query="INSERT INTO TRANSACTIONS(account_id, second_party_id, suma) values(".$_SESSION['acc_id'].",".$acc_dest.",".$suma_dorita.");";
            $link->query($query);
            close_card_session();
            
        }
        else
        {
            $_SESSION['tranzactie_invalida']='true';

        }
    }
    header("Location: main.php");
}
mysqli_close($link);

?>

