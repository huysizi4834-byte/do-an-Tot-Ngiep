<?php
require 'includes/db.php';

$sql = "ALTER TABLE users 
        ADD COLUMN reset_token VARCHAR(64) NULL, 
        ADD COLUMN reset_expires DATETIME NULL";

if (mysqli_query($conn, $sql)) {
    echo "Thêm cột reset_token và reset_expires thành công!\n";
} else {
    echo "Lỗi: " . mysqli_error($conn) . "\n";
}
?>
