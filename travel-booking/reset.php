<?php
require 'includes/db.php';
mysqli_query($conn, "UPDATE flight_bookings SET payment_status='pending' WHERE booking_code='FLC64C58'");
