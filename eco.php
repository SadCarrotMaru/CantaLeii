<!DOCTYPE html>
<html lang="en">
<head>
<?php
                    require "header.php";
                    //echo '<a class="click">'.$_SESSION['username'].'</a>';
                    $servername = "mysql-neverlanes.alwaysdata.net";
                    $username = "336043";
                    $password = "m.2a*Z!#mV!9vWH";
                    $dbname = "neverlanes_cantaleii";  
                ?>
  <title>CantaLeii</title>
        <link rel="icon" type="ima/jpg" href="apple1.svg">
        <meta charset="utf-8">
        <meta name="autor" content="CantaLeii">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" href="eco.css"> 
        <script type="text/javascript" src="eco.js"></script>
        <script type="text/javascript" src="livada.js"></script>
</head>
<body>
    <header>
    </header>

<div id = "tree_container">

</div>

<div id = "wrapper">
    <div id = "b_roundup"> Eco Round Up </div>
    <div id = "b_metrou"> Metrou </div>
    <div id = "b_livada"> Livada </div>
</div>

<div id = "wrapper2">
    <div id = "pop-exit"> X
    </div>
    <div id="roundup">
        <!-- <img id="back" src="back.png" alt="Back"> -->
        <t3> <b> The Million Trees Project </b> </t3>
        <img src = "sponsori/million_trees.jpg" width="300em" height="300em" style="border-radius: 50%;" >
        <p> This East Moline, Illinois, program is an offshoot of a river-cleanup nonprofit that has pulled almost 10.4 million pounds of trash from local waterways since 1998. Founder Chad Pregracke has expanded the group's mission to grow native oaks from volunteer-collected acorns, tend them in a nursery, and then transfer them to riverbanks and watersheds. The organization met its first million-tree milestone in 2016, and is shooting for a second one.</p>
        <t3> <b> The Green Belt Movement </b> </t3>
        <img src = "sponsori/green_belt_movement.jpg" width="300em" height="300em" style="border-radius: 50%;">
        <p>This organization was founded by Nobel Peace Prize winner Wangari Maathai in 1977. They work to empower communities, to conserve the environment and improve livelihoods through tree planting.</p>
        <t3> <b> Arbor Day Foundation </b> </t3>
        <img src = "sponsori/arbor_day_foundation.jpg" width="300em" height="300em" style="border-radius: 50%;">
        <p>This organization is the largest nonprofit membership organization dedicated to planting trees. They work to inspire people to plant, nurture, and celebrate trees.</p>
        <t3> <b> One Tree Planted </b> </t3>
        <img src = "sponsori/one_tree_planted.png" width="300em" height="200em" style="border-radius: 50%;">
        <p> This organization is focused on global reforestation. They work with partners in North America, South America, Asia, and Africa to plant trees in areas that have been devastated by deforestation. </p>
        <t3> <b> Friends of the Earth </b></t3>
        <img src = "sponsori/friends_of_the_earth.png" width="300em" height="300em" >
        <p> This organization is an international network of environmental organizations in 74 countries. They work to protect the planet from environmental degradation and to create a sustainable future </p>
    </div>
    <div id="livada">
        <!-- <img id="back" src="back.png" alt="Back"> -->
        <h3>Ce este Livada?</h3><br>
        <p>Livada este spatiul tau virtual verde. Aici poti aduna padurea ta personala. Cum? Traind ecologic alaturi de banca noastra! Ai doua modalitati de a-ti creste livada. Poti din contul tau de economii RoundUp sa alegi sa redirectionezi o parte din bani catre unul dintre sponsorii nostri, fiecare leu este un punct eco. Altfel, in timp ce astepti metroul sa scanezi codurile QR plasate de noi in statie, sa te loghezi in contul de banca si automat noi iti vom adauga un punct travel eco. Punctele se vor aduna din ambele surse. La 10 puncte eco vei primi un copacel in livada, iar la 100 de puncte eco o surpriza din partea sponsorilor nostri iubitori de natura.</p>
        <h3>Angajamentul nostru</h3><br>
        <p>La fiecare 1000 de puncte stranse de clientii bancii noastre, promitem sa plantam un copac prin intermediul firmelor noastre partenere.</p>
        <h3>De ce este important sa calatorim cu Metroul?</h3>
        <p>Transportul este responsabil in Europa pentru aproximativ un sfert din emisiile de CO2, dintre care 71% provin de la masini obisnuite. Va dati seama cat de mult putem ajuta planeta doar alegand transportul in comun, chiar pe cel electric?</p>
    </div>
    <div id="metrou">
        <!-- <img id="back" src="back.png" alt="Back"> -->
        
        <?php
            echo '<a class = "text_roundup"> Eco RoundUp </a><br>';
            //echo '<a class = "text_roundup">'.$_SESSION['username'].'</a>';
            //afisam optiunea curenta de roundup 
            $link = mysqli_connect($servername, $username, $password, $dbname);
            $q = "select * from ACCOUNTS a join CLIENTS c on (c.client_id = a.client_id) WHERE c.client_id =".$_SESSION['client_id']." and account_type_id=2;";
            $res = $link->query($q);
            //print_r($res);
            $soldru=-1;
            $pct=-1;
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
                    $pct = $row['eco_travel_points'];
                    $fn = $row["first_name"]; 
                    $ln =$row["last_name"]; 
                    $rubool = $row["roundup"];
                    if($rubool == 1){
                        $rubool ="Contul de RoundUp este activ!";
                    }
                    else{
                        $rubool ="Contul tau de RoundUp nu este activ!";
                    }
                    $ecoruper = $row["eco_roundup_percent"];
                    echo '<a class= "text_roundup">Soldul din contul Round_up normal este '.$soldru.'</a><br>';
                    echo '<a class= "text_roundup">Soldul din contul Round_up eco este '.$row['sold'].'</a><br>';
                    echo '<a class = "text_roundup">'.$fn.' '.$ln.'</a><br>';
                    echo '<a class = "text_roundup">'.$rubool.' </a><br>';
                    echo '<a class = "text_roundup"> Procentul din RoundUp care se duce spre contul Eco este: '.$ecoruper.'</a><br>';
                    echo '<a class = "text_roundup"> Ai : '.$pct.' puncte eco travel.</a><br>';
                  } 
            }
        ?>
    </div>
</div>
<footer>
</footer>

</body>
</html>