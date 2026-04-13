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
tr:nth-child(odd) { background-color: #DDE0EE; }
</style>

</head>
<body>

<?php
// CHANGED: removed "@session_start()" (error suppression removed for debugging)
session_start(); // FIXED

include("webconnect.php");

// NEW: safety check to prevent undefined connection errors
if (!isset($conn)) {
  die("Database connection not found."); // NEW
}

$sql = "SELECT * FROM timelogs ORDER BY login_date DESC, timein DESC LIMIT 500";
$result = mysqli_query($conn, $sql);

// unchanged logic but kept error handling
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// moved include here for cleaner structure (no functional change, just organization)
include("mainmenu.php");
?>

<div style="text-align: center; margin: 20px;">
  <h2>Time Logs</h2>
</div>

<table>
  <tr>
    <th>ID</th>
    <th>Employee Num</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Date</th>
    <th>Time In</th>
    <th>Time Out</th>
    <th>Status</th>
  </tr>

  <?php
  // CHANGED: fixed logic flow (no longer checking empty AFTER loop)
  if (mysqli_num_rows($result) > 0): 
  ?>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['emp_num']); ?></td>
        <td><?php echo htmlspecialchars($row['fname']); ?></td>
        <td><?php echo htmlspecialchars($row['lname']); ?></td>
        <td><?php echo htmlspecialchars($row['login_date']); ?></td>
        <td><?php echo htmlspecialchars($row['timein']); ?></td>
        <td><?php echo htmlspecialchars($row['timeout']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
      </tr>
    <?php endwhile; ?>

  <?php else: ?>
    <!-- NEW: proper empty state handling -->
    <tr>
      <td colspan="8" style="text-align:center;">No time logs found.</td>
    </tr>
  <?php endif; ?>

</table>

<div style="text-align: center; margin: 20px;">
  <a href="index.php">Home</a>
</div>

</body>
</html>