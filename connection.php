<?php
// Basic MySQLi connection for XAMPP
$con = mysqli_connect("localhost", "root", "", "ripo");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
