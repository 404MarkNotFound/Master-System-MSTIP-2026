<?php
session_start();
if (!isset($_SESSION['accesslevel']) || $_SESSION['accesslevel'] != 'Admin') {
    echo "<script>
        alert('You are not authorized to view this page');
        location.href='login.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body {margin:0;font-family:Arial}

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
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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
  color: black;
}

.dropdown:hover .dropdown-content {
  display: block;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child), .dropdown .dropbtn {
    display: none;
  }
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
  .topnav.responsive .dropdown {float: none;}
  .topnav.responsive .dropdown-content {position: relative;}
  .topnav.responsive .dropdown .dropbtn {
    display: block;
    width: 100%;
    text-align: left;
  }
}
</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="home.php" class="active">Home</a>
  <div class="dropdown">
    <button class="dropbtn">Points of Sales
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="cash_register.php">Cash Register</a>
      <a href="sales_masterlist.php">Sales Masterlist</a>
      <a href="time_logs.php">Time Logs</a>
    </div>
  </div> 
   <div class="dropdown">
    <button class="dropbtn">Inventory Sys
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="add_products.php">Add Products</a>
      <a href="inventory.php">Products Masterlist</a>
      <a href="time_logs.php">Time Logs</a>
    </div>
  </div> 
   <div class="dropdown">
    <button class="dropbtn">Payroll Sys
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="prepare_payroll.php">Prepare Payroll</a>
      <a href="payroll_reports.php">Payroll Reports</a>
      <a href="time_logs.php">Time Logs</a>
    </div>
  </div> 
   <div class="dropdown">
    <button class="dropbtn">Attendance Sys
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="addemployee.php">Add Employee</a>
      <a href="employees_masterlist.php">Employee Masterlist</a>
      <a href="time_logs.php">Time Logs</a>
    </div>
  </div> 
    <div class="dropdown">
    <button class="dropbtn">HR Sys
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="addemployee.php">Add Employee</a>
      <a href="employees_masterlist.php">Employee Masterlist</a>
    </div>
  </div> 
  <a href="#">About</a>
  
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

<?php if (basename($_SERVER['PHP_SELF']) == 'home.php') { ?>
<h1>The MakSci BSIS Inventor's Group</h1>
A web system is a program that runs on the web, allowing users to access it through a browser. Web systems can be used to manage data, integrate business processes, and create applications. 
How web systems work
Web systems use web services and software agents to integrate business processes 
They can be accessed over the HTTP protocol 
They work with a variety of web development features to provide a secure environment 
They can control and manage data.<br><br>
<center>
<h2>Our BSIS Elective IoT Project</h2><br>
<img src="mstip_logo.png" width="50%" align="square"><br><br>
With the use of RFID card reader, data will be converted and send to MySQL server 

<?php } ?>

</body>
</html>

