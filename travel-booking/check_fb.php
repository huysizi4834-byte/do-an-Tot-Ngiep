<?php
require 'includes/db.php';
$r = mysqli_query($conn, "SELECT id, booking_code FROM flight_bookings");
while($row = mysqli_fetch_assoc($r)) {
    print_r($row);
}
