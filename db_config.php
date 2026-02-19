<?php
// Simple Database Config
$servername = "localhost";
$username = "s673190121"; 
$password = "s673190121"; 
$dbname = "s673190121";

mysqli_report(MYSQLI_REPORT_OFF); // Turn off exceptions

try {
    $conn = @new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        $db_status = "Connection Failed: " . $conn->connect_error;
    } else {
        $db_status = "Connected Successfully!";
    }
} catch (Exception $e) {
    $db_status = "Fatal Error: " . $e->getMessage();
}
?>
