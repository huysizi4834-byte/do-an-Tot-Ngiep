<?php
require 'includes/db.php';

$sql1 = "
CREATE TABLE IF NOT EXISTS hotels (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    star_rating INT DEFAULT 3,
    price_per_night DECIMAL(15,2) NOT NULL,
    thumbnail VARCHAR(255) DEFAULT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$sql2 = "
CREATE TABLE IF NOT EXISTS hotel_bookings (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    hotel_id BIGINT NOT NULL,
    booking_code VARCHAR(50) UNIQUE,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    total_guests INT DEFAULT 1,
    total_nights INT NOT NULL,
    total_amount DECIMAL(15,2) NOT NULL,
    guest_name VARCHAR(255) NOT NULL,
    guest_phone VARCHAR(50) NOT NULL,
    special_requests TEXT,
    payment_type ENUM('full', 'deposit') DEFAULT 'full',
    amount_paid DECIMAL(15,2) DEFAULT 0,
    cccd_image VARCHAR(255) DEFAULT NULL,
    face_image VARCHAR(255) DEFAULT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    booking_status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $sql1)) {
    echo "Table 'hotels' created successfully.\n";
} else {
    echo "Error creating table 'hotels': " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql2)) {
    echo "Table 'hotel_bookings' created successfully.\n";
} else {
    echo "Error creating table 'hotel_bookings': " . mysqli_error($conn) . "\n";
}
