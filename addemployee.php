<?php
include("webconnect.php");

if(isset($_POST['save'])){

mysqli_query($conn,"INSERT INTO employees (
qr_code, emp_num, fname, mname, lname, address, gender,
employment_status, position, sss, philhealth, tin, pagibig,
taxcategory, salary, photo, cnum, email, department, civil_status
) VALUES (
'".$_POST['qr']."',
'".$_POST['emp']."',
'".$_POST['fname']."',
'".$_POST['mname']."',
'".$_POST['lname']."',
'".$_POST['address']."',
'".$_POST['gender']."',
'".$_POST['status']."',
'".$_POST['position']."',
'".$_POST['sss']."',
'".$_POST['philhealth']."',
'".$_POST['tin']."',
'".$_POST['pagibig']."',
'".$_POST['tax']."',
'".$_POST['salary']."',
'".$_POST['photo']."',
'".$_POST['cnum']."',
'".$_POST['email']."',
'".$_POST['department']."',
'".$_POST['civil']."'
)");

header("Location: employees_masterlist.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Employee</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

/* ===== NAVBAR STYLE ===== */
body {margin:0;font-family:Arial;background:#e9ecef;}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.active {
  background-color: #04AA6D;
  color: white;
}

.topnav .icon {
  display: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;    
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  cursor:pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.topnav a:hover, .dropdown:hover .dropbtn {
  background-color: #555;
  color: white;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/* ===== FORM STYLE ===== */
.container {
  display:flex;
  justify-content:center;
  margin-top:20px;
}

form {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width: 400px;
}

h2 {
  text-align: center;
}

input[type=text],
select {
  width: 100%;
  padding: 12px;
  margin: 8px 0;
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

<body>


<div class="topnav" id="myTopnav">
  <a href="index.php" class="active">Home</a>

  <div class="dropdown">
    <button class="dropbtn">Points of Sales <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="cash_register.php">Cash Register</a>
      <a href="sales_masterlist.php">Sales Masterlist</a>
    </div>
  </div> 

  <div class="dropdown">
    <button class="dropbtn">Inventory Sys <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="#">Add Products</a>
      <a href="#">Products Masterlist</a>
    </div>
  </div> 

  <div class="dropdown">
    <button class="dropbtn">Payroll Sys <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="#">Prepare Payroll</a>
      <a href="#">Payroll Reports</a>
      <a href="time_logs.php">Time Logs</a>
    </div>
  </div> 

  <div class="dropdown">
    <button class="dropbtn">Attendance Sys <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="addemployee.php">Add Employee</a>
      <a href="employees_masterlist.php">Employee Masterlist</a>
    </div>
  </div> 

  <div class="dropdown">
    <button class="dropbtn">HR Sys <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="addemployee.php">Add Employee</a>
      <a href="employees_masterlist.php">Employee Masterlist</a>
    </div>
  </div>   

  <a href="about.php">About</a>
</div>


<div class="container">
<form method="POST">
<h2>Add Employee</h2>

<input type="text" name="qr" placeholder="QR Code">
<input type="text" name="emp" placeholder="Employee Number" required>

<input type="text" name="fname" placeholder="First Name">
<input type="text" name="mname" placeholder="Middle Name">
<input type="text" name="lname" placeholder="Last Name">

<input type="text" name="address" placeholder="Address">

<select name="gender">
<option>Male</option>
<option>Female</option>
</select>

<input type="text" name="status" placeholder="Employment Status">
<input type="text" name="position" placeholder="Position">

<input type="text" name="sss" placeholder="SSS">
<input type="text" name="philhealth" placeholder="PhilHealth">
<input type="text" name="tin" placeholder="TIN">
<input type="text" name="pagibig" placeholder="Pag-IBIG">

<input type="text" name="tax" placeholder="Tax Category">
<input type="text" name="salary" placeholder="Salary">

<input type="text" name="photo" placeholder="Photo filename">

<input type="text" name="cnum" placeholder="Contact Number">
<input type="text" name="email" placeholder="Email">

<input type="text" name="department" placeholder="Department">
<input type="text" name="civil" placeholder="Civil Status">

<input type="submit" name="save" value="Save Employee">
</form>
</div>

</body>
</html>