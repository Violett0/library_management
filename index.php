<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: member_dashboard.php");
    }
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
