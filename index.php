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
      if(isset($_SESSION['badlogin']) && $_SESSION['badlogin']=='true'){
        echo "<a class='error'>Bad login Credentials</a>";
        $_SESSION['badlogin']='false';
      }
      if(isset($_SESSION['timeout']) && $_SESSION['timeout']=='true'){
        echo "<a class='error'>You are on a timeout!</a>";
        $_SESSION['timeout']='false';
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
          <tr>
            <td><input type="hidden" id="latitude" name="latitude" value=0></td>
            <td><input type="hidden" id="longitude" name="longitude" value=0></td>
          </tr>
          
         </table>
         </form>
    </div>
  
 
</body>
<script>
const options = 
{
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
};
  
function success(pos) 
{
    const crd = pos.coords;
    document.getElementById("latitude").value=crd.latitude;
    document.getElementById("longitude").value=crd.longitude;
}
  
function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
}
console.log("ok");
navigator.geolocation.getCurrentPosition(success, error, options);
</script>

</html>
