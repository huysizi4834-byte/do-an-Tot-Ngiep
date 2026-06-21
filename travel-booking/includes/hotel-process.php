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
$hotel_id = (int) $_POST['hotel_id'];
$guest_name = trim($_POST['guest_name']);
$guest_phone = trim($_POST['guest_phone']);
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$total_guests = (int) $_POST['total_guests'];
$special_requests = trim($_POST['special_requests']);
$price_per_night = (float) $_POST['price_per_night'];

$date1 = new DateTime($check_in_date);
$date2 = new DateTime($check_out_date);
$interval = $date1->diff($date2);
$total_nights = $interval->days;

if ($total_nights <= 0) {
    die("Ngày trả phòng phải sau ngày nhận phòng.");
}

$discount_amount = isset($_POST['discount_amount']) ? (float)$_POST['discount_amount'] : 0;
$promotion_id = isset($_POST['promotion_id']) ? (int)$_POST['promotion_id'] : 0;

$raw_amount = $total_nights * $price_per_night;
$total_amount = $raw_amount - $discount_amount;
if ($total_amount < 0) $total_amount = 0;

$booking_code = 'HT' . strtoupper(substr(uniqid(), -6));

// Xử lý upload ảnh
$upload_dir = '../assets/uploads/verifications/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$cccd_path = null;
if (isset($_FILES['cccd_image']) && $_FILES['cccd_image']['error'] == UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['cccd_image']['name'], PATHINFO_EXTENSION));
    $cccd_filename = 'cccd_' . $user_id . '_' . time() . '.' . $ext;
    if (move_uploaded_file($_FILES['cccd_image']['tmp_name'], $upload_dir . $cccd_filename)) {
        $cccd_path = 'assets/uploads/verifications/' . $cccd_filename;
    }
}

$face_path = null;
if (!empty($_POST['face_image_base64'])) {
    $base64_string = $_POST['face_image_base64'];
    $image_parts = explode(";base64,", $base64_string);
    if (count($image_parts) == 2) {
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = isset($image_type_aux[1]) ? $image_type_aux[1] : 'jpeg';
        $image_base64 = base64_decode($image_parts[1]);
        $face_filename = 'face_' . $user_id . '_' . time() . '.' . $image_type;
        if (file_put_contents($upload_dir . $face_filename, $image_base64)) {
            $face_path = 'assets/uploads/verifications/' . $face_filename;
        }
    }
} elseif (isset($_FILES['face_image']) && $_FILES['face_image']['error'] == UPLOAD_ERR_OK) {
    // Dự phòng nếu trình duyệt không hỗ trợ WebRTC và fallback về file input
    $ext = strtolower(pathinfo($_FILES['face_image']['name'], PATHINFO_EXTENSION));
    $face_filename = 'face_' . $user_id . '_' . time() . '.' . $ext;
    if (move_uploaded_file($_FILES['face_image']['tmp_name'], $upload_dir . $face_filename)) {
        $face_path = 'assets/uploads/verifications/' . $face_filename;
    }
}

if ($total_guests > 4 && (!$cccd_path || !$face_path)) {
    die("Lỗi: Khi đặt trên 4 người, bạn bắt buộc phải tải lên ảnh CCCD và chụp ảnh khuôn mặt trực tiếp để xác minh.");
}

$payment_type = $_POST['payment_type'] ?? 'full';
$amount_paid = ($payment_type === 'deposit') ? ($total_amount / 2) : $total_amount;

$stmt = mysqli_prepare($conn, "
    INSERT INTO hotel_bookings (user_id, hotel_id, booking_code, check_in_date, check_out_date, total_guests, total_nights, total_amount, guest_name, guest_phone, special_requests, booking_status, cccd_image, face_image, payment_type, amount_paid) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, ?)
");

mysqli_stmt_bind_param($stmt, "iisssiidssssssd", $user_id, $hotel_id, $booking_code, $check_in_date, $check_out_date, $total_guests, $total_nights, $total_amount, $guest_name, $guest_phone, $special_requests, $cccd_path, $face_path, $payment_type, $amount_paid);
mysqli_stmt_execute($stmt);

if ($promotion_id > 0) {
    mysqli_query($conn, "UPDATE user_promotions SET status = 'used', used_at = NOW() WHERE user_id = $user_id AND promotion_id = $promotion_id");
    mysqli_query($conn, "UPDATE promotions SET used_count = used_count + 1 WHERE id = $promotion_id");
}

header("Location: ../payment-gateway.php?code=" . $booking_code);
exit;
