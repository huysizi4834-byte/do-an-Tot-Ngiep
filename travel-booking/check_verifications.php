<?php
require 'includes/db.php';
$check1 = mysqli_query($conn, "SHOW COLUMNS FROM hotel_bookings LIKE 'cccd_image'");
if (mysqli_num_rows($check1) == 0) {
    mysqli_query($conn, "ALTER TABLE hotel_bookings ADD COLUMN cccd_image VARCHAR(255) DEFAULT NULL");
    echo "Added cccd_image column.\n";
}

$check2 = mysqli_query($conn, "SHOW COLUMNS FROM hotel_bookings LIKE 'face_image'");
if (mysqli_num_rows($check2) == 0) {
    mysqli_query($conn, "ALTER TABLE hotel_bookings ADD COLUMN face_image VARCHAR(255) DEFAULT NULL");
    echo "Added face_image column.\n";
}

// Tạo thư mục nếu chưa có
if (!file_exists('assets/uploads/verifications')) {
    mkdir('assets/uploads/verifications', 0777, true);
}
echo "Done.\n";
