<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);

    $sql = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
    if ($conn->query($sql) === TRUE) {
        $message = "Book added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Book</h1>
        <nav>
            <a href="admin_dashboard.php">Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>

        <?php if ($message) echo "<p class='error' style='background-color: #d4edda; color: #155724;'>$message</p>"; ?>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
