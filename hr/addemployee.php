<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee Info</title>
    <style>
form {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

label {display: block;}

input[type=text], select {
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
include("webconnect.php");

if(isset($_POST['Submit'])) 
{

$emp_number = $_POST['employeenumber'];
$firstname = $_POST['firstname'];
$mname = $_POST['mname'];
$lname = $_POST['lastname'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$employment_status = $_POST['emp_status'];
$position = $_POST['position'];
$sss = $_POST['sss'];
$philhealth = $_POST['philhealth'];
$tin = $_POST['tin'];
$pagibig = $_POST['pagibig'];
$taxcategory = $_POST['taxcategory'];
$salary = $_POST['salary'];
$rateperday = $_POST['rateperday'];
$cnum = $_POST['cnum'];
$email = $_POST['email'];
$department = $_POST['department'];
$civil_status = $_POST['civil_status'];
//$lastname =  
//$position =  


$sql2 = " SELECT * from employees WHERE employeenumber = '$emp_number' AND lastname = '$lname' AND firstname = '$firstname' AND mname = '$mname' AND address = '$address' AND gender = '$gender' AND emp_status = '$employment_status' AND position = '$position' AND sss = '$sss' AND philhealth = '$philhealth' AND tin = '$tin' AND pagibig = '$pagibig' AND taxcategory = '$taxcategory' AND salary = '$salary' AND rateperday = '$rateperday' AND cnum = '$cnum' AND email = '$email' AND department = '$department' AND civil_status = '$civil_status' ";
$result = mysqli_query($conn, $sql2); 		
//$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);

if($count==0) {

	$sql = "INSERT INTO employees (emp_num, fname, mname, lname, ) VALUES('$empnumber','$firstname','$mname','$lname'  )";
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
      <form name="myform" method="POST">
      <label for="header"><h2>Add Employee Details</h2></label>
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="firstname" placeholder="Employee Number">

        <label for="fname">First Name</label>
        <input type="text" id="firstname" name="firstname" placeholder="First Name">

        <label for="middle_name">Middle Name</label>
        <input type="text" id="mi" name="mi" placeholder="Middle Name">

        <label for="lastname">Middle Name</label>
        <input type="text" id="lastname" name="lastname" placeholder="Last Name">

        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Address">
        
        <label for="gender">Gender</label>
        <select id="gender" name="gender">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <label for="emp_status">Employment Status</label>
        <input type="text" id="emp_status" name="emp_status" placeholder="Employment Status">
        
        <input type="submit" value="Submit">
      </form>
        <center>
         <div class="signup-link"><a href="time_logs.php">Time Logs</a> | &nbsp;<a href="index.php">Home</a></div>
     </div>
 
  </body>

</body>
</html>

