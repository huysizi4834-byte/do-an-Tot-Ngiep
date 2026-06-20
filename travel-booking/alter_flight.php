<?php
require 'includes/db.php';

$queries = [
    "ALTER TABLE flight_bookings ADD COLUMN payment_type ENUM('full', 'deposit') DEFAULT 'full' AFTER passenger_details",
    "ALTER TABLE flight_bookings ADD COLUMN amount_paid DECIMAL(15,2) DEFAULT 0 AFTER payment_type"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Success: $q\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}
