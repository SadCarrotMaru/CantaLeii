<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name="autor" content="CantaLeii">
        <meta name="description" content="Main Page">
          <title>MAIN</title>
          <link rel="stylesheet" href="main-style.css" type="text/css">
          <script type="text/javascript" src="main.js"></script>
    </head>
    <body>
        <div id = "content">
            <div id = "one"> 
                <div class = "button"> <a> CONT </a> </div>
                <?php
                    require "header.php";
                    echo '<a class="click">'.$_SESSION['username'].'</a>';
                    $servername = "mysql-neverlanes.alwaysdata.net";
                    $username = "336043";
                    $password = "m.2a*Z!#mV!9vWH";
                    $dbname = "neverlanes_cantaleii";  
                ?>
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
        /*if(!isset($_SESSION['client_id'])){
            $_SESSION['client_id']=1;
        }*/
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
                <a href="logout.php" class = "click"> Log out </a>
            </div>
            <div id = "two">
                <div id = "transfer-button" class = "button"> <a> Transfer </a> </div>
                <div class = "button"> <a> Date Card </a> </div>
                <div class = "button"> <a> Istoric Tranzactii </a> </div>
                <div class = "button"> <a> Round Up </a> </div>
            </div>
            <div id = "three">
                <div id = "card-container"> </div>
                <a class = "click"> (SOLD) </a>
                <a class = "click"> (IBAN) </a>
                <div id = "eco"> <a> Eco </a> </div>
            </div>
            <div id = "four"> 
                <div id = "setari" class = "button"> </div>
            </div>
        </div>
        <div id = "pop-content">
            <div id = "background"> </div>
            <div id = "space"> 
                <div id = "pop-exit"> close </div>  
                <div id = "pop-transfer">
                    <?php 
                        echo '<a class = "text_pop"> Transfer </a>';
                        echo '<a class = "text_pop">'.$_SESSION['username'].'</a>';
                    ?>
                </div>
                <div id = "pop-istoric">
                    <?php 
                        echo '<a class = "text_pop"> Istoric Tranzactii </a>';
                        echo '<a class = "text_pop">'.$_SESSION['username'].'</a>';
                        $link = mysqli_connect($servername, $username, $password, $dbname);
                        $query_id = "SELECT account_id FROM ACCOUNTS a JOIN CLIENTS c ON (a.client_id = c.client_id) WHERE UPPER(c.username) = UPPER('".$_SESSION['username']."');";
                        $conturi = $link->query($query_id);
                        $res = [];
                        foreach($conturi as $cont){
                            $query_tr = "SELECT * FROM TRANSACTIONS where account_id = ".$cont['account_id']." OR second_party_id = ".$cont['account_id'].";";
                            $tr = $link->query($query_tr);
                            foreach($tr as $row){
                                $res []= $row; 
                            }
                        }
                        foreach($res as $row){
                            echo '<a class = "text_pop">'.$row['transaction_id'].' '.$row['date'].'</a>';
                        }
                        if (!$link) {
                            echo "Error: Unable to connect to MySQL.";
                            exit;
                        }

                        mysqli_close($link);

                    ?>
                </div>  
                <div id = "pop-setari"> 
                    <?php 
                        echo '<a class = "text_pop"> Setari </a>';
                        echo '<a class = "text_pop">'.$_SESSION['username'].'</a>';
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>