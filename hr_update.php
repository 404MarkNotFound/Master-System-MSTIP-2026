<?php
include("webconnect.php");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM employees WHERE id=$id"));

if (isset($_POST['update'])) {
    $photo = $data['photo']; // Keep existing

    $message = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/employees/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $photo_name = basename($_FILES["photo"]["name"]);
        $photo_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        if (in_array($photo_ext, ['jpg','jpeg','png','gif'])) {
            $target_file = $target_dir . uniqid() . '_' . $_POST['emp'] . '.' . $photo_ext;
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $target_file;
                if ($data['photo'] && $data['photo'] !== $photo && file_exists($data['photo'])) {
                    unlink($data['photo']);
                }
            } else {
                $message = "File upload failed.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, GIF allowed.";
        }
    }

    if (empty($message)) {
        mysqli_query($conn, "UPDATE employees SET 
            emp_num='".$_POST['emp']."',
            fname='".$_POST['fname']."',
            mname='".$_POST['mname']."',
            lname='".$_POST['lname']."',
            address='".$_POST['address']."',
            gender='".$_POST['gender']."',
            employment_status='".$_POST['status']."',
            position='".$_POST['position']."',
            sss='".$_POST['sss']."',
            philhealth='".$_POST['philhealth']."',
            tin='".$_POST['tin']."',
            pagibig='".$_POST['pagibig']."',
            taxcategory='".$_POST['tax']."',
            salary='".$_POST['salary']."',
            photo='$photo',
            cnum='".$_POST['cnum']."',
            email='".$_POST['email']."',
            department='".$_POST['department']."',
            civil_status='".$_POST['civil']."'
        WHERE id=$id");

        header("Location: employees_masterlist.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Employee</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/* ===== NAVBAR STYLE ===== */
body {margin:0;font-family:Arial;background:#e9ecef;}

/* Full navbar CSS */
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
input[type=file],
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

/* Photo preview box */
.photo-box {
  background: white;
  border: 2px dashed #ccc;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  margin-bottom: 15px;
}

.photo-preview {
  width: 100px;
  height: 100px;
  border-radius: 8px;
  object-fit: cover;
  margin-bottom: 10px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.no-photo {
  width: 100px;
  height: 100px;
  background: #f0f0f0;
  border: 2px dashed #ddd;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #999;
  font-size: 12px;
  margin-bottom: 10px;
}
</style>
</head>

<body>
<?php include("mainmenu.php"); ?>

<?php if(isset($message)) echo "<p style='color:red;text-align:center;margin:10px;'>$message</p>"; ?>

<div class="container">
<form method="POST" enctype="multipart/form-data">
<h2>Update Employee</h2>

<!-- Photo Preview Box -->
<div class="photo-box">
  <?php if ($data['photo'] && file_exists($data['photo'])): ?>
    <img src="<?php echo htmlspecialchars($data['photo']); ?>" alt="Current Photo" class="photo-preview">
    <p style="font-size:12px;color:#666;margin:0;">Current: <?php echo basename($data['photo']); ?></p>
  <?php else: ?>
    <div class="no-photo">No Photo</div>
  <?php endif; ?>
  <label for="photo"><i class="fa fa-camera"></i> Change Photo </label>
  <input type="file" id="photo" name="photo" accept="image/*">
</div>

<input type="text" name="emp" value="<?php echo htmlspecialchars($data['emp_num']); ?>" placeholder="Employee Number" required>

<input type="text" name="fname" value="<?php echo htmlspecialchars($data['fname']); ?>" placeholder="First Name">
<input type="text" name="mname" value="<?php echo htmlspecialchars($data['mname']); ?>" placeholder="Middle Name">
<input type="text" name="lname" value="<?php echo htmlspecialchars($data['lname']); ?>" placeholder="Last Name">

<input type="text" name="address" value="<?php echo htmlspecialchars($data['address']); ?>" placeholder="Address">

<select name="gender">
<option value="Male" <?php if($data['gender']=='Male') echo 'selected'; ?>>Male</option>
<option value="Female" <?php if($data['gender']=='Female') echo 'selected'; ?>>Female</option>
</select>

<input type="text" name="status" value="<?php echo htmlspecialchars($data['employment_status']); ?>" placeholder="Employment Status">
<input type="text" name="position" value="<?php echo htmlspecialchars($data['position']); ?>" placeholder="Position">

<input type="text" name="sss" value="<?php echo htmlspecialchars($data['sss']); ?>" placeholder="SSS">
<input type="text" name="philhealth" value="<?php echo htmlspecialchars($data['philhealth']); ?>" placeholder="PhilHealth">
<input type="text" name="tin" value="<?php echo htmlspecialchars($data['tin']); ?>" placeholder="TIN">
<input type="text" name="pagibig" value="<?php echo htmlspecialchars($data['pagibig']); ?>" placeholder="Pag-IBIG">

<input type="text" name="tax" value="<?php echo htmlspecialchars($data['taxcategory']); ?>" placeholder="Tax Category">
<input type="text" name="salary" value="<?php echo htmlspecialchars($data['salary']); ?>" placeholder="Salary">

<input type="text" name="cnum" value="<?php echo htmlspecialchars($data['cnum']); ?>" placeholder="Contact Number">
<input type="text" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" placeholder="Email">

<input type="text" name="department" value="<?php echo htmlspecialchars($data['department']); ?>" placeholder="Department">
<input type="text" name="civil" value="<?php echo htmlspecialchars($data['civil_status']); ?>" placeholder="Civil Status">

<input type="submit" name="update" value="Update Employee">
</form>
</div>

</body>
</html>

