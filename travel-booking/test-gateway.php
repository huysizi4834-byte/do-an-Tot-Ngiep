<?php
session_start();
$_GET['code']='FLC64C58';
$_SESSION['user_id']=7;
ob_start();
require 'payment-gateway.php';
$html = ob_get_clean();
$pos = strpos($html, 'name="booking_code"');
echo substr($html, $pos - 50, 100);
