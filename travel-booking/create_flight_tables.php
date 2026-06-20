<?php
require 'includes/db.php';

$sql1 = "
CREATE TABLE IF NOT EXISTS flights (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    airline VARCHAR(100) NOT NULL,
    flight_number VARCHAR(50) NOT NULL,
    departure_city VARCHAR(100) NOT NULL,
    arrival_city VARCHAR(100) NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    thumbnail VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$sql2 = "
CREATE TABLE IF NOT EXISTS flight_bookings (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    flight_id BIGINT NOT NULL,
    booking_code VARCHAR(50) UNIQUE,
    total_passengers INT DEFAULT 1,
    total_amount DECIMAL(15,2) NOT NULL,
    passenger_details TEXT,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    booking_status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $sql1)) {
    echo "Table 'flights' created successfully.\n";
} else {
    echo "Error creating table 'flights': " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql2)) {
    echo "Table 'flight_bookings' created successfully.\n";
} else {
    echo "Error creating table 'flight_bookings': " . mysqli_error($conn) . "\n";
}
