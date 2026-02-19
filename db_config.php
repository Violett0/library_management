<?php
$servername = "localhost";
$username = "s673190121";
$password = "s673190121";
$dbname = "s673190121";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
