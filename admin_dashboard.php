<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$books_sql = "SELECT b.id, b.title, b.author, b.status, b.image_url, u.username as borrower FROM books b LEFT JOIN borrow_history bh ON b.id = bh.book_id AND bh.status = 'borrowing' LEFT JOIN users u ON bh.user_id = u.id";
$books_result = $conn->query($books_sql);

$users_sql = "SELECT id, username, role FROM users WHERE role = 'member'";
$users_result = $conn->query($users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="admin_dashboard.php">Books & Users</a>
            <a href="add_book.php">Add New Book</a>
            <a href="logout.php">Logout</a>
        </nav>

        <h2>Books Status</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Borrowed By</th>
            </tr>
            <?php while($book = $books_result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $book['image_url']; ?>" alt="Book Image" style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px;"></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td class="status-<?php echo $book['status']; ?>"><?php echo ucfirst($book['status']); ?></td>
                    <td><?php echo $book['borrower'] ? $book['borrower'] : '-'; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2 style="margin-top: 30px;">Members List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
            <?php while($user = $users_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
