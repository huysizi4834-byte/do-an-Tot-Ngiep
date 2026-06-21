<?php
session_start();
require 'includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để lưu mã.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$promotion_id = $_POST['promotion_id'] ?? 0;

if (!$promotion_id) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
    exit;
}

// Kiểm tra promotion tồn tại và còn hoạt động
$sql = "SELECT * FROM promotions WHERE id = $promotion_id AND status = 'active' AND end_date >= CURDATE()";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) === 0) {
    echo json_encode(['success' => false, 'message' => 'Mã khuyến mại không tồn tại hoặc đã hết hạn.']);
    exit;
}

$promo = mysqli_fetch_assoc($res);

// Kiểm tra giới hạn số lượng
if ($promo['usage_limit'] !== null && $promo['used_count'] >= $promo['usage_limit']) {
    echo json_encode(['success' => false, 'message' => 'Rất tiếc, mã khuyến mại này đã hết lượt lưu.']);
    exit;
}

// Kiểm tra đã lưu chưa
$check_sql = "SELECT id FROM user_promotions WHERE user_id = $user_id AND promotion_id = $promotion_id";
$check_res = mysqli_query($conn, $check_sql);
if (mysqli_num_rows($check_res) > 0) {
    echo json_encode(['success' => false, 'message' => 'Bạn đã lưu mã này rồi.']);
    exit;
}

// Lưu vào ví
$insert_sql = "INSERT INTO user_promotions (user_id, promotion_id, status) VALUES ($user_id, $promotion_id, 'available')";
if (mysqli_query($conn, $insert_sql)) {
    echo json_encode(['success' => true, 'message' => 'Đã lưu mã thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại sau.']);
}
