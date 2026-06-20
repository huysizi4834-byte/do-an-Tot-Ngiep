<?php
require 'includes/db.php';

$sqlServices = "
CREATE TABLE IF NOT EXISTS additional_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sqlServices)) {
    echo "Table 'additional_services' created successfully or already exists.<br>";
} else {
    echo "Error creating table 'additional_services': " . mysqli_error($conn) . "<br>";
}

$sqlBookings = "
CREATE TABLE IF NOT EXISTS service_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT(20) NOT NULL,
    service_id INT NOT NULL,
    service_date DATE NOT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES additional_services(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sqlBookings)) {
    echo "Table 'service_bookings' created successfully or already exists.<br>";
} else {
    echo "Error creating table 'service_bookings': " . mysqli_error($conn) . "<br>";
}
?>
