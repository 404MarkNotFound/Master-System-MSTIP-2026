<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance Kiosk</title>

<style>
body {
  margin: 0;
  padding: 0;
  background-color: #FFFFFF;
  font-family: Verdana, Arial, Helvetica, sans-serif;
  text-align: center;
}

h2 { margin-top: 30px; }

#liveclock {
  font-size: 28px;
  font-weight: bold;
  margin: 20px 0;
}

form {
  display: inline-block;
  background: #f2f2f2;
  padding: 30px;
  border-radius: 5px;
}

label { display:block; margin-top:10px; font-weight:bold; }

input[type=text], input[type=password] {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
}

.btn-row { display:flex; gap:10px; margin-top:15px; }

input[type=submit] {
  flex:1;
  padding:12px;
  border:none;
  color:#fff;
  cursor:pointer;
}

#btnTimeIn { background:#4CAF50; }
#btnTimeOut { background:#2196F3; }

.msg-box {
  margin: 20px auto;
  padding: 10px;
  display: inline-block;
}
.msg-success { background:#d4edda; }
.msg-error { background:#f8d7da; }
</style>
</head>

<body>

<?php
session_start();
include("../webconnect.php");

$message = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $emp_num  = $_POST['emp_num'] ?? '';
  $password = $_POST['password'] ?? '';
  $action   = $_POST['action'] ?? '';

  $sql = "SELECT * FROM employees WHERE emp_num='$emp_num' AND password='$password'";
  $res = mysqli_query($conn, $sql);

  if (mysqli_num_rows($res) == 0) {
    $message = "Invalid login";
    $msg_type = "error";
  } else {

    $emp = mysqli_fetch_assoc($res);
    $emp_id = $emp['id'];
    $name = $emp['fname'] . " " . $emp['lname'];

    $today = date('Y-m-d');
    $now = date('H:i:s');

    $check = "SELECT * FROM attendance_logs WHERE emp_num='$emp_num' AND log_date='$today'";
    $check_res = mysqli_query($conn, $check);

    if ($action == 'timein') {

      if (mysqli_num_rows($check_res) > 0) {
        $message = "Already timed in today";
        $msg_type = "error";
      } else {

        $status = ($now > '08:00:00') ? 'Late' : 'On Time';

        mysqli_query($conn,
        "INSERT INTO attendance_logs
        (emp_id, emp_num, employee_name, log_date, time_in, status, created_at)
        VALUES
        ('$emp_id', '$emp_num', '$name', '$today', '$now', '$status', NOW())");

        $message = "Time In saved";
        $msg_type = "success";
      }

    } else if ($action == 'timeout') {

      $q = "SELECT * FROM attendance_logs
            WHERE emp_num='$emp_num' AND log_date='$today' AND time_out IS NULL";
      $r = mysqli_query($conn, $q);

      if (mysqli_num_rows($r) == 0) {
        $message = "No Time In found or already timed out";
        $msg_type = "error";
      } else {

        mysqli_query($conn,
        "UPDATE attendance_logs
        SET time_out='$now'
        WHERE emp_num='$emp_num' AND log_date='$today'");

        $message = "Time Out saved";
        $msg_type = "success";
      }
    }
  }
}
?>

<h2>Attendance Kiosk</h2>

<div id="liveclock"></div>

<script>
setInterval(()=> {
  document.getElementById("liveclock").innerText = new Date().toLocaleString();
},1000);
</script>

<?php if($message): ?>
<div class="msg-box msg-<?= $msg_type ?>">
  <?= $message ?>
</div>
<?php endif; ?>

<form method="POST">
  <label>Employee Number</label>
  <input type="text" name="emp_num" required>

  <label>Password</label>
  <input type="password" name="password" required>

  <div class="btn-row">
    <input type="submit" name="action" value="timein" id="btnTimeIn">
    <input type="submit" name="action" value="timeout" id="btnTimeOut">
  </div>
</form>

</body>
</html>