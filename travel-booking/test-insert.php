<?php
require 'includes/db.php';
$user_id = 1;
$tour_id = 1;
$booking_code = 'TR' . strtoupper(substr(uniqid(), -6));
$departure_date = '2026-06-18';
$total_people = 2;
$total_price = 500.00;
$payment_type = 'full';
$amount_paid = 500.00;

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

if (!$stmt) {
    echo "Prepare failed: " . mysqli_error($conn) . "\n";
} else {
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

    if (mysqli_stmt_execute($stmt)) {
        echo "Insert SUCCESS\n";
    } else {
        echo "Execute failed: " . mysqli_stmt_error($stmt) . "\n";
    }
}
