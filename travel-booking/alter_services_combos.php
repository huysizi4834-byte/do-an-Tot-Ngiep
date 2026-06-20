<?php
require 'includes/db.php';

$queries = [
    // Service bookings
    "ALTER TABLE service_bookings ADD COLUMN booking_code VARCHAR(50) UNIQUE AFTER service_id",
    "ALTER TABLE service_bookings ADD COLUMN payment_type ENUM('full', 'deposit') DEFAULT 'full' AFTER total_price",
    "ALTER TABLE service_bookings ADD COLUMN amount_paid DECIMAL(15,2) DEFAULT 0 AFTER payment_type",
    "ALTER TABLE service_bookings ADD COLUMN payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending' AFTER amount_paid",
    
    // Combo bookings
    "ALTER TABLE combo_bookings ADD COLUMN booking_code VARCHAR(50) UNIQUE AFTER combo_id",
    "ALTER TABLE combo_bookings ADD COLUMN payment_type ENUM('full', 'deposit') DEFAULT 'full' AFTER total_price",
    "ALTER TABLE combo_bookings ADD COLUMN amount_paid DECIMAL(15,2) DEFAULT 0 AFTER payment_type",
    "ALTER TABLE combo_bookings ADD COLUMN payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending' AFTER amount_paid"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Success: $q\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}
