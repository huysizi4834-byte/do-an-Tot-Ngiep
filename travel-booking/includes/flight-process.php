<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Truy cập không hợp lệ");
}

$user_id = $_SESSION['user_id'];
$flight_id = (int)$_POST['flight_id'];
$total_passengers = (int)$_POST['total_passengers'];
$price_per_ticket = (float)$_POST['price_per_ticket'];

$discount_amount = isset($_POST['discount_amount']) ? (float)$_POST['discount_amount'] : 0;
$promotion_id = isset($_POST['promotion_id']) ? (int)$_POST['promotion_id'] : 0;

$raw_amount = $total_passengers * $price_per_ticket;
$total_amount = $raw_amount - $discount_amount;
if ($total_amount < 0) $total_amount = 0;

// Nối tên hành khách lại thành chuỗi json hoặc chuỗi phẩy
$passenger_names = $_POST['passenger_names'] ?? [];
$passenger_details = mysqli_real_escape_string($conn, json_encode($passenger_names, JSON_UNESCAPED_UNICODE));

$payment_type = $_POST['payment_type'] ?? 'full';
$amount_paid = ($payment_type === 'deposit') ? ($total_amount / 2) : $total_amount;

// Tạo mã booking code ngẫu nhiên
$booking_code = 'FL' . strtoupper(substr(uniqid(), -6));

$stmt = mysqli_prepare($conn, "
    INSERT INTO flight_bookings (user_id, flight_id, booking_code, total_passengers, total_amount, passenger_details, payment_type, amount_paid, booking_status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
");

mysqli_stmt_bind_param($stmt, "iisidsds", $user_id, $flight_id, $booking_code, $total_passengers, $total_amount, $passenger_details, $payment_type, $amount_paid);
mysqli_stmt_execute($stmt);

if ($promotion_id > 0) {
    mysqli_query($conn, "UPDATE user_promotions SET status = 'used', used_at = NOW() WHERE user_id = $user_id AND promotion_id = $promotion_id");
    mysqli_query($conn, "UPDATE promotions SET used_count = used_count + 1 WHERE id = $promotion_id");
}

header("Location: ../payment-gateway.php?code=" . $booking_code);
exit;
