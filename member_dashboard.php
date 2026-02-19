<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM books";
$books_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <nav>
            <a href="member_dashboard.php">Books List</a>
            <a href="history.php">Borrow History</a>
            <a href="logout.php">Logout</a>
        </nav>

        <h2>Books List</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while($book = $books_result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $book['image_url']; ?>" alt="Book Image" style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px;"></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td class="status-<?php echo $book['status']; ?>"><?php echo ucfirst($book['status']); ?></td>
                    <td>
                        <?php if($book['status'] == 'available'): ?>
                            <form action="borrow_book.php" method="POST" style="display:inline;">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit">Borrow</button>
                            </form>
                        <?php else: ?>
                            <?php 
                                // Check if this book is currently borrowed by this user
                                $book_id = $book['id'];
                                $user_id = $_SESSION['user_id'];
                                $check_sql = "SELECT * FROM borrow_history WHERE book_id = $book_id AND user_id = $user_id AND status = 'borrowing'";
                                $check_result = $conn->query($check_sql);
                                if($check_result->num_rows > 0):
                            ?>
                                <form action="return_book.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                    <button type="submit" style="background-color: #28a745;">Return</button>
                                </form>
                            <?php else: ?>
                                <button disabled style="background-color: #ccc;">Unavailable</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
