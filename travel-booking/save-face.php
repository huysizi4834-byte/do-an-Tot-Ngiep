<?php
require 'includes/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['descriptor'])) {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu khuôn mặt.']);
    exit;
}

// Convert descriptor array back to JSON string to save in DB
$descriptor_json = json_encode($data['descriptor']);
$descriptor_safe = mysqli_real_escape_string($conn, $descriptor_json);

$sql = "UPDATE users SET face_descriptor = '$descriptor_safe' WHERE id = $user_id";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Lưu Face ID thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi DB: ' . mysqli_error($conn)]);
}
exit;
