<?php
// webconnect.php - Database connection for Master-System-MSTIP-2026
// Uses standard XAMPP MySQL settings (adjust if your DB credentials differ)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterprise_architecture";  // Database name from SQL dumps (attendance_logs, employees, etc.)

// Create MySQLi connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset for proper encoding
mysqli_set_charset($conn, "utf8");

?>

