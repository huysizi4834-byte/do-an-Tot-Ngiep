<?php
require_once 'includes/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS user_promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    promotion_id INT NOT NULL,
    status ENUM('available', 'used') NOT NULL DEFAULT 'available',
    claimed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_at TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY unique_claim (user_id, promotion_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $sql)) {
    echo "Tạo bảng user_promotions thành công!";
} else {
    echo "Lỗi: " . mysqli_error($conn);
}
