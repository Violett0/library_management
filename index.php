<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: member_dashboard.php");
    }
    exit();
} else {
    // If not logged in, redirect to login
    header("Location: login.php");
    exit();
}
?>
