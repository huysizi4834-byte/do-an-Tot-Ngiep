<?php
require 'includes/db.php';
$r = mysqli_query($conn, "SELECT * FROM flight_bookings WHERE booking_code = 'FLC64C58'");
print_r(mysqli_fetch_assoc($r));
