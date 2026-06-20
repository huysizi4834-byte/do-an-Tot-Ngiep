<?php
require 'includes/db.php';
$check = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'avatar'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT NULL");
    echo "Added avatar column.";
} else {
    echo "Avatar column already exists.";
}

// Tạo thư mục nếu chưa có
if (!file_exists('assets/uploads/avatars')) {
    mkdir('assets/uploads/avatars', 0777, true);
}
