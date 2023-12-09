<html>
  <head>
    <link rel="stylesheet" href="login.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=EB+Garamond&display=swap">
    <title>cantaleii login</title>
    <meta charset="utf-8">
    <meta name="autor" content="login">
    <meta name="description" content="cantaleii login">
    <meta name="keywords" content="cantaleii">
 </head>
 <body>
    <div class="pagina">
      <div class="header" align="center">
          <h1>
              CANTALEII
          </h1>
          <div class="subtitle">
            <h2>LOGIN</h2>
          </div>
      </div>
      
    <?php
      require "header.php";
      if(isset($_GET['qrcode'])){
        $_SESSION['qrcode']=$_GET['qrcode'];
      }
      else{
        $_SESSION['qrcode']='none';
      }
    ?>
      <FORM method="POST" action='check_login.php'>
        <table border=0 width="40%" align="center">
          <tr>
              <td>Username*: </td>
              <td><INPUT TYPE="text" name="username"></td>
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
         </form>
         
  </div>
  
 
</body>

</html>
