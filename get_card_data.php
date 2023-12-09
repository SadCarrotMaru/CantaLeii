<?php
    function set_card_session($acc_id,$iban,$cnum,$valid,$cvc){
        $_SESSION['acc_id']=$acc_id;
        $_SESSION['iban']=$iban;
        $_SESSION['cnum']=$cnum;
        $_SESSION['valid']=$valid;
        $_SESSOIN['cvc']=$cvc;
    }
    function close_card_session($acc_id,$iban,$cnum,$valid,$cvc){
        $_SESSION['acc_id']=-1;
        $_SESSION['iban']=-1;
        $_SESSION['cnum']=-1;
        $_SESSION['valid']=-1;
        $_SESSOIN['cvc']=-1;
    }
    function get_card_data(){
        $servername = "mysql-neverlanes.alwaysdata.net";
        $username = "336043";
        $password = "m.2a*Z!#mV!9vWH";
        $dbname = "neverlanes_cantaleii";
        $link = mysqli_connect($servername, $username, $password, $dbname);

        if (!$link) {
            echo "Error: Unable to connect to MySQL.";
            exit;
        }
        if(!isset($_SESSION['client_id'])){
            $_SESSION['client_id']=1;
        }
        $acc_id=-1;
        $iban=-1;
        $cnum=-1;
        $valid=-1;
        $cvc=-1;
        $q1="select account_id, IBAN, card_number, valid_thru, cvc FROM ACCOUNTS where client_id = '".$_SESSION['client_id']."' and account_type_id = 1;";
        $res = $link->query($q1);
                        
        if($res->num_rows >0){
            while($row = $res->fetch_assoc()) { 
                $acc_id=$row["account_id"];
                $iban=$row["IBAN"];
                $cnum=$row["card_number"];
                $valid=$row["valid_thru"];
                $cvc=$row["cvc"];
                print_r($row["account_id"]. "<br>"); 
                print_r($row["IBAN"]. "<br>"); 
                print_r($row["card_number"]. "<br>"); 
                print_r($row["valid_thru"]. "<br>"); 
                print_r($row["cvc"]. "<br>"); 

            } 
        }
        set_card_session($acc_id,$iban,$cnum,$valid,$cvc);
    }
?>