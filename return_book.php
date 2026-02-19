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

    // Check if book is borrowed by this user
    $check_sql = "SELECT id FROM borrow_history WHERE book_id = $book_id AND user_id = $user_id AND status = 'borrowing'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        $history = $result->fetch_assoc();
        $history_id = $history['id'];

        $conn->begin_transaction();
        try {
            // Update book status
            $update_book = "UPDATE books SET status = 'available' WHERE id = $book_id";
            $conn->query($update_book);

            // Update history
            $update_history = "UPDATE borrow_history SET status = 'returned', return_date = CURRENT_TIMESTAMP WHERE id = $history_id";
            $conn->query($update_history);

            $conn->commit();
            header("Location: member_dashboard.php");
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Book is not borrowed by you.";
    }
}
?>
