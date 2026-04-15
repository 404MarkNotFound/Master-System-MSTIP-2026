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
  font-weight: bold;
}

tr:nth-child(even) { background-color: #F4F4F4; }
tr:nth-child(odd)  { background-color: #DDE0EE; }
</style>

</head>
<body>

<?php
session_start();
include("../webconnect.php");

if (!isset($conn)) {
  die("Database connection not found.");
}

$sql = "SELECT * FROM attendance_logs ORDER BY date DESC, time_in DESC LIMIT 500";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

include("../mainmenu.php");
?>

<div style="text-align: center; margin: 20px;">
  <h2>Time Logs</h2>
  <!-- live clock -->
  <div id="liveclock" style="font-size:14px; color:#555;"></div>
  <script>
    function updateClock() {
      var now = new Date();
      document.getElementById('liveclock').textContent = now.toLocaleString();
    }
    updateClock();
    setInterval(updateClock, 1000);
  </script>
</div>

<table>
  <tr>
    <th>ID</th>
    <th>Emp ID</th>
    <th>Emp Num</th>
    <th>Employee Name</th>
    <th>Date</th>
    <th>Time In</th>
    <th>Time Out</th>
    <th>Hours Worked</th>
    <th>Late (hrs)</th>
    <th>Status</th>
  </tr>

  <?php if (mysqli_num_rows($result) > 0): ?>

    <?php while($row2 = mysqli_fetch_assoc($result)): ?>

      <?php
        // --- Professor's algorithm ---
        $start_time = new DateTime("08:00:00");
        $end_time   = new DateTime("17:00:00");
        $date1 = $row2['time_in'];
        $date2 = $row2['time_out'];
        $time1 = new DateTime($date1);
        $time2 = new DateTime($date2);
        $timediff = $time1->diff($time2);

        if ($date2 == '') {
          $elapsed_time = '';
        } else {
          $elapsed_time = $timediff->format('%h.%i');
        }

        // worked hours minus lunch break
        if ($date2 > '13:00:00') {
          $elapsed_time = $timediff->format('%h.%i') - 1;
        }

        if ($date1 > '08:00:00') {
          $timediff2 = $start_time->diff($time1);
          $late = $timediff2->format('%h.%i');
        } else {
          $late = 0;
        }

        // --- auto status based on algorithm result ---
        if ($date1 == '') {
          $status = 'Absent';
        } elseif ($late > 0) {
          $status = 'Late';
        } else {
          $status = 'On Time';
        }
      ?>

      <tr>
        <td><?php echo $row2['id']; ?></td>
        <td><?php echo htmlspecialchars($row2['emp_id']); ?></td>
        <td><?php echo htmlspecialchars($row2['emp_num']); ?></td>
        <td><?php echo htmlspecialchars($row2['employee_name']); ?></td>
        <td><?php echo htmlspecialchars($row2['date']); ?></td>
        <td><?php echo htmlspecialchars($row2['time_in']); ?></td>
        <td><?php echo htmlspecialchars($row2['time_out']); ?></td>
        <td><?php echo $elapsed_time; ?></td>
        <td><?php echo $late; ?></td>
        <td><?php echo $status; ?></td>
      </tr>

    <?php endwhile; ?>

  <?php else: ?>
    <tr>
      <td colspan="10" style="text-align:center;">No time logs found.</td>
    </tr>
  <?php endif; ?>

</table>

<div style="text-align: center; margin: 20px;">
  <a href="../index.html">Home</a>
</div>

</body>
</html>