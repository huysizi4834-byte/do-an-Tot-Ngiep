<?php
require 'includes/db.php';
$res = mysqli_query($conn, 'DESCRIBE bookings');
while ($row = mysqli_fetch_assoc($res))
    print_r($row);
