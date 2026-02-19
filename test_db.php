<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_config.php';

echo "<h1>Database Connection Test</h1>";
echo "Attempting to connect to: $servername<br>";
echo "User: $username<br>";
echo "Database: $dbname<br><br>";

if ($conn->ping()) {
    echo "<h2 style='color:green'>SUCCESS: Connected to the database!</h2>";
    echo "You can now delete this file and use the application.";
    
    // Check tables
    $result = $conn->query("SHOW TABLES");
    echo "<h3>Tables in database:</h3><ul>";
    while($row = $result->fetch_array()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<h2 style='color:red'>ERROR: " . $conn->error . "</h2>";
}
?>
