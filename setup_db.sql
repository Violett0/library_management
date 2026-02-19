-- Run this SQL in your hosting's phpMyAdmin (Select database s673190121 first)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('member', 'admin') DEFAULT 'member'
);

CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    image_url VARCHAR(255) DEFAULT 'https://via.placeholder.com/150',
    status ENUM('available', 'borrowed') DEFAULT 'available'
);

CREATE TABLE IF NOT EXISTS borrow_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date TIMESTAMP NULL,
    status ENUM('borrowing', 'returned') DEFAULT 'borrowing',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Default admin account (password: admin123)
-- Hash: $2y$12$O3tTtl7eHKsA6LSIPBZ9Jewm.wHC129YlHEqxNdFMmyydAHJpBux2
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$12$O3tTtl7eHKsA6LSIPBZ9Jewm.wHC129YlHEqxNdFMmyydAHJpBux2', 'admin')
ON DUPLICATE KEY UPDATE id=id;
