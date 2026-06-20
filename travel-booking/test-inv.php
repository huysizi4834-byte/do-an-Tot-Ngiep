<?php
session_start();
require 'includes/db.php';
$r = mysqli_query($conn, "SELECT booking_code, user_id FROM flight_bookings LIMIT 1");
$row = mysqli_fetch_assoc($r);
$code = $row['booking_code'];

$_GET['code'] = $code;
$_SESSION['user_id'] = $row['user_id'];
ob_start();
require 'invoice.php';
$out = ob_get_clean();
echo strlen($out) . " bytes output\n";
if (strlen($out) < 100) echo "Output: " . $out . "\n";
