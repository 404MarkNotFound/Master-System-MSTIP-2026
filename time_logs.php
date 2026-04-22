<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Time Logs</title>

<style>
body {
  margin: 0;
  padding: 0;
  background-color: #FFFFFF;
  font-family: Verdana, Arial, Helvetica, sans-serif;
}

table {
  width: 98%;
  border-collapse: collapse;
  margin: 10px auto;
}

th, td {
  border: 1px solid #ccc;
  padding: 8px;
}

th {
  background-color: #E0E8F1;
}

tr:nth-child(even) { background-color: #F4F4F4; }
tr:nth-child(odd)  { background-color: #DDE0EE; }
</style>

</head>
<body>

<?php
session_start();
include("webconnect.php");

if (!isset($conn)) {
  die("Database connection not found.");
}

$search_emp = isset($_GET['search_emp']) ? trim($_GET['search_emp']) : '';

$sql = "SELECT * FROM attendance_logs";
if ($search_emp != '') {
  $search_emp = mysqli_real_escape_string($conn, $search_emp);
  $sql .= " WHERE emp_num LIKE '%$search_emp%'";
}
$sql .= " ORDER BY log_date DESC, time_in DESC LIMIT 500";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

include("mainmenu.php");
?>

<form method="get" action="" style="margin: 0;">
<table width="99%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="35%" height="28" valign="middle" bgcolor="#99CCFF" style="padding: 5px; border: none;">
      <span style="font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px;">
        Search by:
        <select style="width: 105px;">
          <option value="">Select</option>
        </select>
        <input type="text" name="search_emp" size="10" value="<?= htmlspecialchars($search_emp); ?>" />
        <input type="submit" value="GO" />
        <input type="button" value="All" onclick="window.location='time_logs.php'" />
      </span>
    </td>
    <td width="65%" bgcolor="#CCFFCC" style="padding: 5px; border: none;">&nbsp;</td>
  </tr>
</table>
</form>

<table>
<tr>
  <th>ID</th>
  <th>Emp ID</th>
  <th>Emp Num</th>
  <th>Name</th>
  <th>Date</th>
  <th>Time In</th>
  <th>Time Out</th>
  <th>Hours Worked</th>
  <th>Late (hrs)</th>
  <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<?php
$time_in  = $row['time_in'];
$time_out = $row['time_out'];

$start = new DateTime("08:00:00");
$inTime = $time_in ? new DateTime($time_in) : null;
$outTime = $time_out ? new DateTime($time_out) : null;

/* HOURS WORKED */
if ($inTime && $outTime) {
    $diff = $inTime->diff($outTime);
    $hours = $diff->h + ($diff->i / 60);

    // lunch deduction rule
    if ($outTime->format('H:i:s') > '13:00:00') {
        $hours -= 1;
    }

    $hoursWorked = round(max($hours, 0), 2);
} else {
    $hoursWorked = '';
}

/* LATE CALC */
if ($inTime) {
    if ($inTime->format('H:i:s') > '08:00:00') {
        $lateDiff = $start->diff($inTime);
        $late = $lateDiff->h + ($lateDiff->i / 60);
        $late = round($late, 2);
    } else {
        $late = 0;
    }
} else {
    $late = '';
}

/* STATUS */
if (!$time_in) {
    $status = "Absent";
} elseif ($late > 0) {
    $status = "Late";
} else {
    $status = "On Time";
}
?>

<tr>
  <td><?= $row['id']; ?></td>
  <td><?= $row['emp_id']; ?></td>
  <td><?= $row['emp_num']; ?></td>
  <td><?= $row['employee_name']; ?></td>
  <td><?= $row['log_date']; ?></td>
  <td><?= $time_in; ?></td>
  <td><?= $time_out; ?></td>
  <td><?= $hoursWorked; ?></td>
  <td><?= $late; ?></td>
  <td><?= $status; ?></td>
</tr>

<?php endwhile; ?>

</table>

</body>
</html>
