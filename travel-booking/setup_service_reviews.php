<?php
require 'includes/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS service_reviews (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    service_id INT NOT NULL,
    rating INT DEFAULT 5,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if (mysqli_query($conn, $sql)) {
    echo "Bảng service_reviews đã được tạo thành công!\n";
} else {
    echo "Lỗi khi tạo bảng: " . mysqli_error($conn) . "\n";
}
?>
