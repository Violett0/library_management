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
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $sql = "INSERT INTO books (title, author, image_url) VALUES ('$title', '$author', '$image_url')";
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
            <input type="text" name="image_url" placeholder="Image URL (e.g., https://example.com/book.jpg)" value="https://via.placeholder.com/150">
            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
