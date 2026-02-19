<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $user_id = $_SESSION['user_id'];

    // Check if book is available
    $check_sql = "SELECT status FROM books WHERE id = $book_id";
    $result = $conn->query($check_sql);
    $book = $result->fetch_assoc();

    if ($book['status'] == 'available') {
        // Start transaction
        $conn->begin_transaction();
        try {
            // Update book status
            $update_book = "UPDATE books SET status = 'borrowed' WHERE id = $book_id";
            $conn->query($update_book);

            // Record in history
            $insert_history = "INSERT INTO borrow_history (user_id, book_id, status) VALUES ($user_id, $book_id, 'borrowing')";
            $conn->query($insert_history);

            $conn->commit();
            header("Location: member_dashboard.php");
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Book is already borrowed.";
    }
}
?>
