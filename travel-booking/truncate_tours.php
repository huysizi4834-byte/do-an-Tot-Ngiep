<?php
require 'includes/db.php';
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
mysqli_query($conn, "TRUNCATE TABLE bookings");
if (mysqli_query($conn, "TRUNCATE TABLE tours")) {
    echo "Tours and bookings truncated successfully.";
} else {
    echo "Error truncating tours: " . mysqli_error($conn);
}
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
