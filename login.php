<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
	<link rel="icon" type="image/png" href="inc/pcaaticon.ico">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<style>
form {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

label {display: block;}

input[type=text], input[type=password], select {
  width: 100%;
  padding: 12px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
</style>
</head>

<?php

// Your connection to the database
// == TO ENABLE SESSION VARIABLES IN HOST DOMAIN
//php_flag output_buffering on;

@session_start();
//include("webconnect.php");

$servername = "localhost";
$database = "enterprise_architecture";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// -- The Login button event

if(isset($_POST['Submit'])) {

// -- the POSTING variables from the form textfields
@$username=$_POST['textfield'];
@$password=$_POST['textfield2'];

// -- the evaluation query, to check whether the username and password exists in the table USERS

$sql = "SELECT * FROM users WHERE username ='$username' AND password ='$password' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$row1 = mysqli_fetch_assoc($result); 
$_SESSION['username'] = $row1['username'];
$_SESSION['accesslevel'] = $row1['accesslevel'];
$email = $_SESSION['username'];
?>

<SCRIPT language="JavaScript">
<!--
    location.href="index.php";
//  End -->
</script>			 

<?php   
} else {
?>

<SCRIPT language="JavaScript">
<!--
    alert("No Record found for that Username and Password.  Please try again!  ");
//  End -->
</script>			 

<?php 
//mysqli_close($conn);
//exit();
  }
 }
?>

  <body>
    <center>
     <div class="container">
      <div class="wrapper">
        <h2>MSTIP Sta. Mesa</h2>
		<form name="form1" action="" method="post" onSubmit="return validateMe(this.textfield.value);">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="textfield"  placeholder="Your Username" onMouseOver="this.focus();" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input name="textfield2" type="password" placeholder="Your Password" onMouseOver="this.focus();" required>
          </div>
          <div class="pass">&nbsp;</div>
          <div class="row button">
            <input type="submit" value="Login" name="Submit">
          </div>
		<div class="signup-link"><a href="index.php">Back to Home</a>&nbsp;</div>		  
       </form>
      </div>
    </div>

  </body>
</body>
</html>

<script language="JavaScript">
window.onload = function() {
  document.getElementById("textfield").focus();
};
</script>