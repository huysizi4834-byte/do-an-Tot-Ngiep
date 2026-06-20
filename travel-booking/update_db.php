<?php
require 'includes/db.php';

$sql = "ALTER TABLE hotel_bookings 
    ADD COLUMN IF NOT EXISTS payment_type ENUM('full', 'deposit') DEFAULT 'full',
    ADD COLUMN IF NOT EXISTS amount_paid DECIMAL(15,2) DEFAULT 0,
    ADD COLUMN IF NOT EXISTS cccd_image VARCHAR(255) DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS face_image VARCHAR(255) DEFAULT NULL;";

if (mysqli_query($conn, $sql)) {
    echo "Columns added successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
