<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'member') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT b.title, bh.borrow_date, bh.return_date, bh.status FROM borrow_history bh JOIN books b ON bh.book_id = b.id WHERE bh.user_id = $user_id ORDER BY bh.borrow_date DESC";
$history_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Your Borrowing History</h1>
        <nav>
            <a href="member_dashboard.php">Books List</a>
            <a href="history.php">Borrow History</a>
            <a href="logout.php">Logout</a>
        </nav>

        <table>
            <tr>
                <th>Title</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
            <?php if($history_result->num_rows > 0): ?>
                <?php while($row = $history_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date'] ? $row['return_date'] : '-'; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No history found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
