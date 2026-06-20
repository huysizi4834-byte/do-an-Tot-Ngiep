<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập");
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Truy cập không hợp lệ");
}

$booking_code = mysqli_real_escape_string($conn, $_POST['txn_code'] ?? '');
if (empty($booking_code)) {
    die("Mã booking không tồn tại");
}
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? ''); // Could save this in DB if needed later

$prefix = substr($booking_code, 0, 2);
$table = "";

if ($prefix === 'HT') {
    $table = "hotel_bookings";
} elseif ($prefix === 'FL') {
    $table = "flight_bookings";
} elseif ($prefix === 'TR') {
    $table = "bookings";
} elseif ($prefix === 'SV') {
    $table = "service_bookings";
} elseif ($prefix === 'CB') {
    $table = "combo_bookings";
} else {
    die("Mã booking không hợp lệ");
}

$user_id = $_SESSION['user_id'];
$face_verified = $_POST['face_verified'] ?? '0';
$password = $_POST['password'] ?? '';
$payment_face_image_b64 = $_POST['payment_face_image_b64'] ?? '';
$cccd = mysqli_real_escape_string($conn, $_POST['cccd'] ?? '');
$representative_name = mysqli_real_escape_string($conn, $_POST['representative_name'] ?? '');

// Xác thực Mật khẩu nếu chưa Face ID
if ($face_verified !== '1') {
    $u_query = mysqli_query($conn, "SELECT password_hash FROM users WHERE id = '$user_id'");
    $u_data = mysqli_fetch_assoc($u_query);
    if (!password_verify($password, $u_data['password_hash'])) {
        die("<script>alert('Mật khẩu không chính xác!'); window.history.back();</script>");
    }
}

// Lưu ảnh khuôn mặt (nếu có)
$payment_face_image_path = '';
if (!empty($payment_face_image_b64)) {
    $image_parts = explode(";base64,", $payment_face_image_b64);
    if (count($image_parts) == 2) {
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = 'pay_face_' . $booking_code . '_' . time() . '.jpg';
        $file_path = '../uploads/payments/' . $file_name;
        
        if (!is_dir('../uploads/payments/')) {
            mkdir('../uploads/payments/', 0777, true);
        }
        
        file_put_contents($file_path, $image_base64);
        $payment_face_image_path = 'uploads/payments/' . $file_name;
    }
}

// Tạo truy vấn update thông tin
$update_fields = ["payment_status = 'paid'"];
if (!empty($cccd)) $update_fields[] = "cccd = '$cccd'";
if (!empty($representative_name)) $update_fields[] = "representative_name = '$representative_name'";
if (!empty($payment_face_image_path)) $update_fields[] = "payment_face_image = '$payment_face_image_path'";

$update_str = implode(', ', $update_fields);

$sql = "UPDATE $table SET $update_str WHERE booking_code = '$booking_code' AND user_id = '$user_id'";
mysqli_query($conn, $sql);

// Chuyển hướng sang trang báo thành công
header("Location: ../payment-success.php?code=" . $booking_code);
exit;
