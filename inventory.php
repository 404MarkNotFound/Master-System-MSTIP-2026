<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee Info</title>
   <link rel="stylesheet" href="loginstyle.css">

  </head>
<?php
include("webconnect.php");

if(isset($_POST['Submit'])) 
{

$empnumber = $_POST['employeenumber'];
$firstname = $_POST['firstname'];
$mi= $_POST['mi'];
$lname= $_POST['lastname'];

//$lastname =  
//$position =  


$sql2 = " SELECT * from products WHERE productNumber = '$empnumber' AND lastname = '$lastname' AND firstname = '$firstname' AND mi = '$mi' ";
$result = mysqli_query($conn, $sql2); 		
//$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);

if($count==0) {

	$sql = "INSERT INTO employees (emp_num, fname, mname, lname) VALUES('$empnumber','$firstname','$mi','$lname'  )";
	mysqli_query($conn, $sql);
	?>
	<SCRIPT Language=Javascript>
	<!--
	alert("Employee details has been successfully added!");
	// End -->
	</SCRIPT>

	<SCRIPT Language=Javascript>
	<!--
      location.href="index.php";
	// End -->
	</SCRIPT>
 <?php
} else {
?>

<SCRIPT Language=Javascript>
<!--
	alert("Record Already exists. Please try again!");
// End -->
</SCRIPT>

<SCRIPT Language=Javascript>
<!--
 location.href="addemployee.php";
// End -->

</SCRIPT>

<?php
  }
 }


?>
<?php include("mainmenu.php") ; ?>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Add Products Info.</span></div>
		<form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return validateMe(this.textfield.value);">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="productNumber"  placeholder="Product Number" required>
          </div>
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="productName"  placeholder="Product Name" required>
          </div>
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="qty"  placeholder="Quantity" required>
          </div>
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="lastname"  placeholder="Last Name" required>
          </div>
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="price"  placeholder="Unit Price" required>
          </div>


          <div class="row">

            <div class="row button">
            <input type="submit" value="Submit" name="Submit">
          </div>
        </form>
        <center>
          <div class="signup-link"><a href="time_logs.php">Time Logs</a> | &nbsp;<a href="index.php">Home</a></div>
      </div>
    </div>|

  </body>

</body>
</html>

