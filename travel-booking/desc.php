<?php
require 'includes/db.php';
$result = mysqli_query($conn, 'SHOW COLUMNS FROM bookings');
while($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}
