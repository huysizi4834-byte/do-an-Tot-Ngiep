<?php
require 'includes/db.php';

$sql = "ALTER TABLE users ADD COLUMN face_image VARCHAR(255) NULL";

if (mysqli_query($conn, $sql)) {
    echo "Thêm cột face_image thành công!\n";
} else {
    echo "Lỗi: " . mysqli_error($conn) . "\n";
}
?>
