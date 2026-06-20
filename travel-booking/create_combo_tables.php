<?php
require 'includes/db.php';

$sqlCombos = "
CREATE TABLE IF NOT EXISTS combos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    duration VARCHAR(100),
    image VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sqlCombos)) {
    echo "Table 'combos' created successfully.\n";
} else {
    echo "Error creating table 'combos': " . mysqli_error($conn) . "\n";
}

$sqlComboBookings = "
CREATE TABLE IF NOT EXISTS combo_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    combo_id INT NOT NULL,
    travel_date DATE NOT NULL,
    total_people INT DEFAULT 1,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sqlComboBookings)) {
    echo "Table 'combo_bookings' created successfully.\n";
} else {
    echo "Error creating table 'combo_bookings': " . mysqli_error($conn) . "\n";
}
?>
