<?php
require 'includes/db.php';

$check1 = mysqli_query($conn, "SHOW COLUMNS FROM hotel_bookings LIKE 'payment_type'");
if (mysqli_num_rows($check1) == 0) {
    mysqli_query($conn, "ALTER TABLE hotel_bookings ADD COLUMN payment_type VARCHAR(20) DEFAULT 'full'");
    echo "Added payment_type column.\n";
}

$check2 = mysqli_query($conn, "SHOW COLUMNS FROM hotel_bookings LIKE 'amount_paid'");
if (mysqli_num_rows($check2) == 0) {
    mysqli_query($conn, "ALTER TABLE hotel_bookings ADD COLUMN amount_paid DECIMAL(15,2) DEFAULT 0");
    echo "Added amount_paid column.\n";
}

echo "Done.\n";
