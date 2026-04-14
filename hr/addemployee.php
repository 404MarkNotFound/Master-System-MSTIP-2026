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

input[type=text], input[type=email], select {
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
include("../webconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit'])) {
    $emp_number = mysqli_real_escape_string($conn, $_POST['employeenumber'] ?? '');
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname'] ?? '');
    $mname = mysqli_real_escape_string($conn, $_POST['mname'] ?? '');
    $lname = mysqli_real_escape_string($conn, $_POST['lastname'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $employment_status = mysqli_real_escape_string($conn, $_POST['emp_status'] ?? '');
    $position = mysqli_real_escape_string($conn, $_POST['position'] ?? '');
    $sss = mysqli_real_escape_string($conn, $_POST['sss'] ?? '');
    $philhealth = mysqli_real_escape_string($conn, $_POST['philhealth'] ?? '');
    $tin = mysqli_real_escape_string($conn, $_POST['tin'] ?? '');
    $pagibig = mysqli_real_escape_string($conn, $_POST['pagibig'] ?? '');
    $taxcategory = mysqli_real_escape_string($conn, $_POST['taxcategory'] ?? '');
    $salary = mysqli_real_escape_string($conn, $_POST['salary'] ?? '');
    $rateperday = mysqli_real_escape_string($conn, $_POST['rateperday'] ?? '');
    $cnum = mysqli_real_escape_string($conn, $_POST['cnum'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $department = mysqli_real_escape_string($conn, $_POST['department'] ?? '');
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status'] ?? '');

    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $target_dir = "uploads/employees/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $photo_name = basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . uniqid() . '_' . $photo_name;
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $target_file;
        }
    }

    $sql2 = "SELECT * FROM employees WHERE emp_num = '$emp_number' AND fname = '$firstname' AND mname = '$mname' AND lname = '$lname' AND address = '$address' AND gender = '$gender' AND employment_status = '$employment_status' AND position = '$position' AND sss = '$sss' AND philhealth = '$philhealth' AND tin = '$tin' AND pagibig = '$pagibig' AND taxcategory = '$taxcategory' AND salary = '$salary' AND rateperday = '$rateperday' AND cnum = '$cnum' AND email = '$email' AND department = '$department' AND civil_status = '$civil_status'";
    $result = mysqli_query($conn, $sql2);
    $count = $result ? mysqli_num_rows($result) : 0;

    if ($count == 0) {
        $sql = "INSERT INTO employees (emp_num, fname, mname, lname, address, gender, employment_status, position, sss, philhealth, tin, pagibig, taxcategory, salary, rateperday, photo, cnum, email, department, civil_status) VALUES ('$emp_number','$firstname','$mname','$lname','$address','$gender','$employment_status','$position','$sss','$philhealth','$tin','$pagibig','$taxcategory','$salary','$rateperday','$photo','$cnum','$email','$department','$civil_status')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Employee details has been successfully added!"); location.href="../index.php";</script>';
            exit;
        }

        $error = mysqli_error($conn);
        echo '<script>alert("Unable to save employee details: '.addslashes($error).'");</script>';
    } else {
        echo '<script>alert("Record already exists. Please try again!"); location.href="addemployee.php";</script>';
        exit;
    }
}
?>
<body>
<?php include("../mainmenu.php"); ?>
    <div class="container">
      <form name="myform" method="POST" action="" enctype="multipart/form-data">
      <label for="header"><h2>Add Employee Details</h2></label>

        <label for="employeenumber">Employee Number</label>
        <input type="text" id="employeenumber" name="employeenumber" placeholder="Employee Number" required>

        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" placeholder="First Name" required>

        <label for="mname">Middle Name</label>
        <input type="text" id="mname" name="mname" placeholder="Middle Name">

        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Address">

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
          <option value="">Select gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <label for="emp_status">Employment Status</label>
        <input type="text" id="emp_status" name="emp_status" placeholder="Employment Status">

        <label for="position">Position</label>
        <input type="text" id="position" name="position" placeholder="Position">

        <label for="sss">SSS Number</label>
        <input type="text" id="sss" name="sss" placeholder="SSS Number">

        <label for="philhealth">PhilHealth Number</label>
        <input type="text" id="philhealth" name="philhealth" placeholder="PhilHealth Number">

        <label for="tin">TIN Number</label>
        <input type="text" id="tin" name="tin" placeholder="TIN Number">

        <label for="pagibig">Pag-IBIG Number</label>
        <input type="text" id="pagibig" name="pagibig" placeholder="Pag-IBIG Number">

        <label for="taxcategory">Tax Category</label>
        <input type="text" id="taxcategory" name="taxcategory" placeholder="Tax Category">

        <label for="salary">Salary</label>
        <input type="text" id="salary" name="salary" placeholder="Salary">

        <label for="rateperday">Rate Per Day</label>
        <input type="text" id="rateperday" name="rateperday" placeholder="Rate Per Day">

        <label for="cnum">Contact Number</label>
        <input type="text" id="cnum" name="cnum" placeholder="Contact Number">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email">

        <label for="department">Department</label>
        <input type="text" id="department" name="department" placeholder="Department">

        <label for="photo">Employee Photo</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="civil_status">Civil Status</label>
        <input type="text" id="civil_status" name="civil_status" placeholder="Civil Status">

        <input type="submit" name="Submit" value="Submit">
      </form>
        <center>
         <div class="signup-link"><a href="../Attendance/time_logs.php">Time Logs</a> | &nbsp;<a href="../index.php">Home</a></div>
        </center>
     </div>
  </body>
</html>
