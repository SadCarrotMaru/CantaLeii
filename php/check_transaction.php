<?php

function set_card_session($acc_id,$iban,$cnum,$valid,$cvc,$sold,$acc_type,$ru){
    $_SESSION['acc_id']=$acc_id;
    $_SESSION['iban']=$iban;
    $_SESSION['cnum']=$cnum;
    $_SESSION['valid']=$valid;
    $_SESSION['cvc']=$cvc;
    $_SESSION['sold']=$sold;
    $_SESSION['acc_type']=$acc_type;
    $_SESSION['roundup']=$ru;
}
function close_card_session(){
    $_SESSION['acc_id']=-1;
    $_SESSION['iban']=-1;
    $_SESSION['cnum']=-1;
    $_SESSION['valid']=-1;
    $_SESSION['cvc']=-1;
    $_SESSION['sold']=-1;
    $_SESSION['acc_type']=-1;
    $_SESSION['roundup']=-1;

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
    $ru=-1;
    $q1="select account_id, IBAN, card_number, valid_thru, cvc, sold,account_type_id,roundup FROM ACCOUNTS where client_id = '".$client."' and account_type_id = 1;";
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
            $ru =$row['roundup'];
            print_r($row["account_id"]. "<br>"); 
            print_r($row["IBAN"]. "<br>"); 
            print_r($row["card_number"]. "<br>"); 
            print_r($row["valid_thru"]. "<br>"); 
            print_r($row["cvc"]. "<br>"); 

        } 
    }
    set_card_session($acc_id,$iban,$cnum,$valid,$cvc,$sold,$acc_type,$ru);
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

            //verificam round-up
            if($_SESSION['roundup'])
            {
                $rndup = ceil($suma_dorita) - $suma_dorita;
                if($rndup <= $_SESSION['sold'] - $suma_dorita)
                {
                    //adaugam banii din round-up in conturile userului
                    $query_cont_rndup = "select sold,iban from ACCOUNTS where client_id = ".$_SESSION['client_id']." and account_type_id=2;";
                    $query_cont_rndup_ans = $link->query($query_cont_rndup);
                    if($query_cont_rndup_ans->num_rows>0){
                        while($row = $query_cont_rndup_ans->fetch_assoc()) {
                            $sold_rndup = $row["sold"]; 
                            $rndup_IBAN =$row["iban"]; 
                          } 
                    }

                    $query_eco_cont_rndup = "select sold, account_id, iban from ACCOUNTS where client_id = ".$_SESSION['client_id']." and account_type_id=3;";
                    $query_eco_cont_rndup_ans = $link->query($query_eco_cont_rndup);
                    if($query_eco_cont_rndup_ans->num_rows>0){
                        while($row = $query_eco_cont_rndup_ans->fetch_assoc()) { 
                            $rndup_eco_IBAN =$row["iban"];
                            $sold_eco_rndup = $row["sold"]; 
                            $acc_id_eco = $row["account_id"];
                          } 
                    }

                    $get_ecr = "select eco_roundup_percent from ACC_IS_ECO where account_id = ".$acc_id_eco.";";
                    $ecr_ans = $link->query($get_ecr);
                    if($ecr_ans->num_rows>0)
                    {
                        while($row = $ecr_ans->fetch_assoc())
                        {
                            $eco_rnd_up_proc = $row["eco_roundup_percent"];
                        }
                    }

                    $suma_cont_2 = (100-$eco_rnd_up_proc) * $rndup / 100;
                    $suma_cont_3 = ($eco_rnd_up_proc) * $rndup / 100;

                    $query="UPDATE ACCOUNTS set sold =".($_SESSION['sold']-$suma_dorita-$rndup)." where IBAN ='".$_SESSION['iban']."';";
                    $link->query($query);

                    $query="UPDATE ACCOUNTS set sold =".($sold_rndup+$suma_cont_2)." where IBAN ='".$rndup_IBAN."';";
                    $link->query($query);

                    $query="UPDATE ACCOUNTS set sold =".($sold_eco_rndup+$suma_cont_3)." where IBAN ='".$rndup_eco_IBAN."';";
                    $link->query($query);
                }
                    else
                    {
                        $query="UPDATE ACCOUNTS set sold =".($_SESSION['sold']-$suma_dorita)." where IBAN ='".$_SESSION['iban']."';";
                        $link->query($query);
                    }
            }
                else
                {
                    $query="UPDATE ACCOUNTS set sold =".($_SESSION['sold']-$suma_dorita)." where IBAN ='".$_SESSION['iban']."';";
                    $link->query($query);
                }

            //scadem banii din cont

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

