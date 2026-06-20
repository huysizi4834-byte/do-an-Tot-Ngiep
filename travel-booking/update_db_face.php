<?php
require 'includes/db.php';
mysqli_query($conn, "ALTER TABLE users ADD COLUMN face_descriptor TEXT NULL DEFAULT NULL");
mysqli_query($conn, "ALTER TABLE flight_bookings ADD COLUMN check_in_status ENUM('pending', 'checked_in') NOT NULL DEFAULT 'pending'");
echo "DB Updated";
