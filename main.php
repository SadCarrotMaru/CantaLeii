<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/png" href="logo_icon.png">
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
                    if($_SESSION['client_id'] == -1)
                    {
                        close_card_session();
                        header("location: index.php");
                    } 
                ?>
                

                <a href="logout.php" class = "click"> Log out </a>
            </div>
            <div id = "two">
                <div id = "transfer-button" class = "button"> <a> Transfer </a> </div>
                <div class = "button" id = "DaCa"> <a> Date Card </a> </div>
                <div class = "button"> <a> Istoric Tranzactii </a> </div>
                <div class = "button"> <a> Round Up </a> </div>
            </div>
            <div id = "three">
            <?php
    function set_card_session($acc_id,$iban,$cnum,$valid,$cvc){
        $_SESSION['acc_id']=$acc_id;
        $_SESSION['iban']=$iban;
        $_SESSION['cnum']=$cnum;
        $_SESSION['valid']=$valid;
        $_SESSION['cvc']=$cvc;
    }
    function close_card_session(){
        $_SESSION['acc_id']=-1;
        $_SESSION['iban']=-1;
        $_SESSION['cnum']=-1;
        $_SESSION['valid']=-1;
        $_SESSION['cvc']=-1;
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
        $q1="select first_name, last_name, account_id, IBAN, card_number, valid_thru, cvc, sold,account_type_id FROM ACCOUNTS a join CLIENTS c on(c.client_id = a.client_id) where c.client_id = '".$_SESSION['client_id']."' and account_type_id = 1;";
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
                echo "<a class='info'>".$row["account_id"]. "</a>";     
                echo "<a class='info' id='iban'>".$row["IBAN"]. "</a>"; 
                echo "<a class='info' id='card_nr'>".$row["card_number"]. "</a>"; 
                echo "<a class='info' id='valid_thru'>".$row["valid_thru"]. "</a>"; 
                echo "<a class='info' id='cvc'>".$row["cvc"]. "</a>"; 
                echo "<a class='info' id='sold'>".$row["sold"]. "</a>"; 
                echo "<a class='info' id='type_id'>".$row["account_type_id"]. "</a>"; 
                echo "<a class='info' id='first_name'>".$row["first_name"]. "</a>"; 
                echo "<a class='info' id='last_name'>".$row["last_name"]. "</a>"; 

            } 
        }

        //set_card_session($acc_id,$iban,$cnum,$valid,$cvc);
    }
    get_card_data();
    ?>
                <div id = "card-container"> 
                    <!--<canvas id="canvmap" width="300" height="300"></canvas>-->
                </div>
                <a class = "click" id="soldb"> (SOLD) </a>
                <a class = "click" id="ibanb"> (IBAN) </a>
                <img src = "apple1.svg" id = "eco"> 
                <a class = "click" id = "eco_anc"> Eco </a>
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
                        echo '<FORM method="POST" action="check_transaction.php">
                        <table border=0 width="40%" align="center">
                          <tr>
                              <td>Suma*: </td>
                              <td><INPUT TYPE="text" name="suma"></td>
                          </tr>
                          <tr>
                              <td>IBAN destinatar*: </td>
                              <td><INPUT TYPE="text" name="dest"></td>
                          </tr>
                          <tr>
                              <td>Password*: </td>
                              <td><INPUT TYPE="text" name="password"></td>
                          </tr>
                          <tr>
                            <td><INPUT TYPE="reset" VALUE="reset"></td>
                            <td><INPUT TYPE="submit" VALUE="send"></td>
                          </tr>
                          
                         </table>
                         </form>'
                    ?>
                </div>
                <div id = "pop-istoric">
                    <?php 
                        echo '<a class = "text_pop"> Istoric Tranzactii </a>';
                        echo '<a class = "text_pop">'.$_SESSION['username'].'</a>';
                        //tranzactii out
                        $link = mysqli_connect($servername, $username, $password, $dbname);
                        $query_id = "SELECT account_id FROM ACCOUNTS a JOIN CLIENTS c ON (a.client_id = c.client_id) WHERE UPPER(c.username) = UPPER('".$_SESSION['username']."');";
                        $conturi = $link->query($query_id);
                        $res = [];
                        foreach($conturi as $cont){
                            $query_tr = "SELECT * from ACCOUNTS a join TRANSACTIONS t on (a.account_id = t.account_id) JOIN ACCOUNTS b on (b.account_id = t.second_party_id) JOIN CLIENTS c on (c.client_id = b.client_id) where a.account_id = ".$cont['account_id'].";";
                            //$query_tr = "SELECT * FROM TRANSACTIONS where account_id = ".$cont['account_id'].";";
                            $tr = $link->query($query_tr);
                            foreach($tr as $row){
                                $res []= $row; 
                            }
                        }
                        foreach($res as $row){
                            echo '<a class = "text_pop" style=color:rgb(255,0,70)> Catre '.$row['first_name'].' '.$row['last_name'].' Data: '.$row['date'].' Suma '.$row['suma'].'</a>';

                        }
                        //tranzactii in
                        $query_id = "SELECT account_id FROM ACCOUNTS a JOIN CLIENTS c ON (a.client_id = c.client_id) WHERE UPPER(c.username) = UPPER('".$_SESSION['username']."');";
                        $conturi = $link->query($query_id);
                        $res = [];
                        foreach($conturi as $cont){
                            $query_tr = "SELECT * from ACCOUNTS a join TRANSACTIONS t on (a.account_id = t.second_party_id) JOIN ACCOUNTS b on (b.account_id = t.account_id) JOIN CLIENTS c ON (c.client_id = b.client_id) where a.account_id = ".$cont['account_id'].";";
                            $tr = $link->query($query_tr);
                            foreach($tr as $row){
                                $res []= $row; 
                            }
                        }
                        foreach($res as $row){
                            //selectam second party din tranzactia asta, respectiv numele omului
                            
                            echo '<a class = "text_pop" style=color:MediumSpringGreen> De la '.$row['first_name'].' '.$row['last_name'].' Data: '.$row['date'].' Suma '.$row['suma'].'</a>';
                        }
                        if (!$link) {
                            echo "Error: Unable to connect to MySQL.";
                            exit;
                        }

                        mysqli_close($link);

                    ?>
                </div>  
                <div id="pop-roundup">
                    <?php
                        echo '<a class = "text_roundup"> RoundUp </a><br>';
                        //echo '<a class = "text_roundup">'.$_SESSION['username'].'</a>';
                        //afisam optiunea curenta de roundup 
                        $link = mysqli_connect($servername, $username, $password, $dbname);
                        $q = "select * from ACCOUNTS a join CLIENTS c on (c.client_id = a.client_id) WHERE c.client_id =".$_SESSION['client_id']." and account_type_id=2;";
                        $res = $link->query($q);
                        //print_r($res);
                        $soldru=-1;
                        if($res->num_rows>0){
                            while($row = $res->fetch_assoc()) {
                                $soldru = $row['sold'];
                            }
                        }
                        $query = "select * from ACCOUNTS a join ACC_IS_ECO e on(a.account_id = e.account_id) join CLIENTS c on (c.client_id = a.client_id) WHERE c.client_id =".$_SESSION['client_id']." and account_type_id=3;";
                        $res = $link->query($query);
                        //print_r($res);
                        if($res->num_rows>0){
                            
                            while($row = $res->fetch_assoc()) {
                                $fn = $row["first_name"]; 
                                $ln =$row["last_name"]; 
                                $rubool = $row["roundup"];
                                if($rubool == 1){
                                    $rubool ="Your roundup is active!";
                                }
                                else{
                                    $rubool ="Your roundup is not active!";
                                }
                                $ecoruper = $row["eco_roundup_percent"];
                                echo '<a class= "text_roundup">Soldul din contul Round_up normal este '.$soldru.'</a><br>';
                                echo '<a class= "text_roundup">Soldul din contul Round_up eco este '.$row['sold'].'</a><br>';
                                echo '<a class = "text_roundup">'.$fn.' '.$ln.'</a><br>';
                                echo '<a>'.$rubool.' </a><br>';
                                echo '<a> Your current eco roundup percent is: '.$ecoruper.'</a><br>';
                              } 
                        }
                        echo '<FORM method="POST" action="check_roundup.php">
                        <table border=0 width="40%" align="center">
                          <tr>
                          <td>Roundup option*: </td>
                          <td>
                            <select name="roundupopt" required>
                            <option>activ</option>
                            <option>inactiv</option>
                            <option SELECTED VALUE="">Select...</option>
                            </td>
                          </tr>
                          <tr>
                              <td>Eco roundup percent*: </td>
                              <td><INPUT TYPE="text" name="percent" required></td>
                          </tr>
                          <tr>
                              <td>Password*: </td>
                              <td><INPUT TYPE="text" name="password" required></td>
                          </tr>
                          <tr>
                            <td><INPUT TYPE="reset" VALUE="reset"></td>
                            <td><INPUT TYPE="submit" VALUE="send"></td>
                          </tr>
                          
                         </table>
                         </form>'
                        //si de roundup eco
                        //afisam form de change roundup
                        
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