<?php
require 'includes/db.php';
$tables = ['hotel_bookings', 'flight_bookings', 'bookings', 'service_bookings', 'combo_bookings'];
foreach($tables as $t) {
    $r = mysqli_query($conn, "SELECT booking_code FROM $t WHERE booking_code LIKE 'JP%'");
    while($row = mysqli_fetch_assoc($r)) {
        echo "Found in $t: " . $row['booking_code'] . "\n";
    }
}
echo "Done\n";
