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