<?php
require 'includes/db.php';
$r = mysqli_query($conn, "SELECT * FROM bookings ORDER BY id DESC LIMIT 5");
while($row = mysqli_fetch_assoc($r)) {
    print_r($row);
}
