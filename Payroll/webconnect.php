<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "master_system";  // <-- PALITAN MO NG TAMANG DATABASE NAME

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>