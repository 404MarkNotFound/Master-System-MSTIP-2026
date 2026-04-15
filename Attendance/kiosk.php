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

h2 {
  margin-top: 30px;
}

#liveclock {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin: 10px 0 30px 0;
}

form {
  display: inline-block;
  background-color: #f2f2f2;
  border-radius: 5px;
  padding: 30px 40px;
  text-align: left;
}

label {
  display: block;
  font-weight: bold;
  margin-top: 12px;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 10px;
  margin: 6px 0 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 15px;
}

.btn-row {
  margin-top: 15px;
  display: flex;
  gap: 10px;
}

input[type=submit] {
  flex: 1;
  padding: 12px;
  font-size: 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: white;
}

#btnTimeIn  { background-color: #4CAF50; }
#btnTimeOut { background-color: #2196F3; }

input[type=submit]:hover { opacity: 0.88; }

.msg-box {
  display: inline-block;
  margin: 20px auto;
  padding: 12px 24px;
  border-radius: 4px;
  font-size: 15px;
}
.msg-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.msg-error   { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

a { color: #333; font-size: 13px; }
</style>
</head>
<body>

<?php
session_start();
include("../webconnect.php");

if (!isset($conn)) {
  die("Database connection not found.");
}

$message = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $emp_num  = mysqli_real_escape_string($conn, trim($_POST['emp_num']  ?? ''));
  $password = trim($_POST['password'] ?? '');
  $action   = $_POST['action'] ?? ''; // 'timein' or 'timeout'

  if ($emp_num == '' || $password == '') {
    $message  = "Please enter your Employee Number and Password.";
    $msg_type = 'error';

  } else {
    // verify employee exists in employees table using emp_num + password
    $sql_check = "SELECT * FROM employees WHERE emp_num = '$emp_num' AND password = '$password' LIMIT 1";
    $res_check  = mysqli_query($conn, $sql_check);

    if (!$res_check || mysqli_num_rows($res_check) == 0) {
      $message  = "Employee not found or wrong password. Please try again.";
      $msg_type = 'error';

    } else {
      $emp = mysqli_fetch_assoc($res_check);
      $emp_id        = $emp['id'];
      $employee_name = $emp['fname'] . ' ' . $emp['lname'];
      $today         = date('Y-m-d');
      $now_time      = date('H:i:s');

      if ($action === 'timein') {
        // check if already timed in today
        $sql_existing = "SELECT * FROM attendance_logs WHERE emp_num = '$emp_num' AND date = '$today' LIMIT 1";
        $res_existing  = mysqli_query($conn, $sql_existing);

        if (mysqli_num_rows($res_existing) > 0) {
          $message  = "You already timed in today ($today).";
          $msg_type = 'error';
        } else {
          // determine status
          $cutoff = '08:00:00';
          $status = ($now_time > $cutoff) ? 'Late' : 'On Time';

          $sql_in = "INSERT INTO attendance_logs (emp_id, emp_num, employee_name, date, time_in, status, created_at)
                     VALUES ('$emp_id', '$emp_num', '$employee_name', '$today', '$now_time', '$status', NOW())";
          if (mysqli_query($conn, $sql_in)) {
            $message  = "Time In recorded for $employee_name at $now_time. Status: $status";
            $msg_type = 'success';
          } else {
            $message  = "Error saving Time In: " . mysqli_error($conn);
            $msg_type = 'error';
          }
        }

      } elseif ($action === 'timeout') {
        // find today's time in record with no timeout yet
        $sql_find = "SELECT * FROM attendance_logs WHERE emp_num = '$emp_num' AND date = '$today' AND (time_out IS NULL OR time_out = '') LIMIT 1";
        $res_find  = mysqli_query($conn, $sql_find);

        if (mysqli_num_rows($res_find) == 0) {
          $message  = "No Time In record found for today, or you already timed out.";
          $msg_type = 'error';
        } else {
          $log = mysqli_fetch_assoc($res_find);
          $log_id = $log['id'];

          $sql_out = "UPDATE attendance_logs SET time_out = '$now_time' WHERE id = '$log_id'";
          if (mysqli_query($conn, $sql_out)) {
            $message  = "Time Out recorded for $employee_name at $now_time.";
            $msg_type = 'success';
          } else {
            $message  = "Error saving Time Out: " . mysqli_error($conn);
            $msg_type = 'error';
          }
        }
      }
    }
  }
}
?>

<h2>Attendance Kiosk</h2>

<!-- live clock -->
<div id="liveclock"></div>
<script>
  function updateClock() {
    var now = new Date();
    document.getElementById('liveclock').textContent = now.toLocaleString();
  }
  updateClock();
  setInterval(updateClock, 1000);
</script>

<?php if ($message != ''): ?>
  <div class="msg-box msg-<?php echo $msg_type; ?>">
    <?php echo htmlspecialchars($message); ?>
  </div><br>
<?php endif; ?>

<form method="POST" action="kiosk.php">
  <label for="emp_num">Employee Number</label>
  <input type="text" id="emp_num" name="emp_num" placeholder="e.g. EMP001" required>

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Enter password" required>

  <div class="btn-row">
    <input type="submit" id="btnTimeIn"  name="action" value="timein"  style="background-color:#4CAF50;">
    <input type="submit" id="btnTimeOut" name="action" value="timeout" style="background-color:#2196F3;">
  </div>
</form>

<script>
  window.onload = function() {
    document.getElementById('btnTimeIn').value  = 'Time In';
    document.getElementById('btnTimeOut').value = 'Time Out';
  };
</script>

<br>
<a href="../index.html">Back to Home</a>

</body>
</html>