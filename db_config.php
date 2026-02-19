<?php
// Hosting Configuration for BNCC
$servername = "localhost";
$username = "s673190121";  // Username from Hosting
$password = "s673190121";  // Password from Hosting
$dbname = "s673190121";    // Database Name from Hosting

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Show user-friendly error
    die("<h1 style='color:red;'>Connection Failed: " . $conn->connect_error . "</h1><p>Please check your database credentials in <b>db_config.php</b>.</p>");
}
?>
