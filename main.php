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
                <div id = "setari"> </div>
            </div>
        </div>
        <div id = "pop-content">
            <div id = "background"> </div>
            <div id = "space"> 
                <div id = "pop-exit"> close </div>    
            </div>
        </div>
    </body>
</html>