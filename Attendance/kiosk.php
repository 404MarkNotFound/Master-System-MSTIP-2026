<?php 
date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html></xai:function_call >  
<xai:function_call name="edit_file">
<parameter name="path">
</xai:function_call >  
<xai:function_call name="edit_file">
<parameter name="path">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance System</title>

<style>
body {
  margin: 0;
  padding: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #FFFFFF;
  font-family: Verdana, Arial, Helvetica, sans-serif, Times New Roman;
  position: relative;
}

h2 { 
  position: absolute;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 2.5em; 
}

#liveclock {
  position: absolute;
top: 130px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 1.5em;
  font-weight: bold;
  font: Times New Roman;
  color: #070707;
}

form {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  flex-direction: column;
  width: 220%;
  max-width: 400px;
  background: #F2F2F2;
  padding: 70px;
  border-radius: 10px;
}

label { display:block; margin-top:10px; font-weight:bold; }

input[type=text], input[type=password] {
  width: 93%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
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
  position: absolute;
  bottom: 150px;
  left: 47%;
  transform: translateX(-30%);
  margin: 10;
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

  // ✅ SIMPLE AUTH (plain password)
  $sql = "SELECT * FROM attendance_credentials 
          WHERE emp_num='$emp_num' 
          AND password='$password' 
          AND is_active=1";

  $res = mysqli_query($conn, $sql);

  if (mysqli_num_rows($res) == 0) {
    $message = "Invalid login";
    $msg_type = "error";
  } else {

    // ✅ get employee info from HR table
    $emp_query = "SELECT * FROM employees WHERE emp_num='$emp_num'";
    $emp_res = mysqli_query($conn, $emp_query);
    $emp = mysqli_fetch_assoc($emp_res);

    $emp_id = $emp['id'];
    $name = $emp['fname'] . " " . $emp['lname'];

    $today = date('Y-m-d');
$now = date('Y-m-d H:i:s');

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

<h2>ATTENDANCE SYSTEM</h2>

<div id="liveclock"></div>

<script>
setInterval(()=> {
  const now = new Date();
  const date = now.toLocaleDateString('en-US', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  }).replace(/,/g, '');
  const time = now.toLocaleTimeString('en-US', { 
    hour: 'numeric', 
    minute: '2-digit', 
    second: '2-digit',
    hour12: true 
  });
  document.getElementById("liveclock").innerText = `${date} | ${time}`;
}, 1000);
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