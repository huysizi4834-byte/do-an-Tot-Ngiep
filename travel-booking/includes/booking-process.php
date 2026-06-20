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

$tour_id = $_POST['tour_id'] ?? 0;

$departure_date = $_POST['departure_date'] ?? '';

$total_people = $_POST['total_people'] ?? 1;

$sql_tour = "SELECT price FROM tours WHERE id = $tour_id";
$result_tour = mysqli_query($conn, $sql_tour);
$tour = mysqli_fetch_assoc($result_tour);
$total_price = ($tour['price'] ?? 0) * $total_people;

$payment_type = $_POST['payment_type'] ?? 'full';
$amount_paid = ($payment_type === 'deposit') ? ($total_price / 2) : $total_price;
$booking_code = 'TR' . strtoupper(substr(uniqid(), -6));

$stmt = mysqli_prepare(
    $conn,
    "
    INSERT INTO bookings
    (
        user_id,
        tour_id,
        booking_code,
        departure_date,
        total_people,
        total_amount,
        payment_type,
        amount_paid,
        payment_status,
        booking_status,
        created_at
    )
    VALUES
    (
        ?, ?, ?, ?, ?, ?, ?, ?,
        'pending',
        'pending',
        NOW()
    )
"
);

mysqli_stmt_bind_param(
    $stmt,
    "iissidsd",
    $user_id,
    $tour_id,
    $booking_code,
    $departure_date,
    $total_people,
    $total_price,
    $payment_type,
    $amount_paid
);

mysqli_stmt_execute($stmt);

header("Location: ../payment-gateway.php?code=" . $booking_code);
exit;