<?php
session_start();
require 'includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$code = $_POST['code'] ?? '';
$total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;

if (empty($code)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá.']);
    exit;
}

$code_safe = mysqli_real_escape_string($conn, $code);

// Kiểm tra mã có tồn tại, còn hạn, còn lượt không
$sql = "SELECT * FROM promotions WHERE code = '$code_safe' AND status = 'active' AND end_date >= CURDATE()";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) === 0) {
    echo json_encode(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.']);
    exit;
}

$promo = mysqli_fetch_assoc($res);

if ($promo['usage_limit'] !== null && $promo['used_count'] >= $promo['usage_limit']) {
    echo json_encode(['success' => false, 'message' => 'Mã giảm giá này đã hết lượt sử dụng.']);
    exit;
}

// Kiểm tra mã này người dùng đã thu thập chưa và đã dùng chưa
$promo_id = $promo['id'];
$check_user = "SELECT * FROM user_promotions WHERE user_id = $user_id AND promotion_id = $promo_id";
$res_user = mysqli_query($conn, $check_user);

if (mysqli_num_rows($res_user) === 0) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa lưu mã này. Vui lòng vào Kho Voucher để nhận.']);
    exit;
}

$user_promo = mysqli_fetch_assoc($res_user);
if ($user_promo['status'] === 'used') {
    echo json_encode(['success' => false, 'message' => 'Bạn đã sử dụng mã giảm giá này rồi.']);
    exit;
}

// Tính toán giảm giá
$discount_amount = 0;
if ($promo['discount_type'] === 'percent') {
    $discount_amount = $total_amount * ($promo['discount_value'] / 100);
} else {
    $discount_amount = $promo['discount_value'];
}

// Đảm bảo giảm không vượt quá tổng tiền
if ($discount_amount > $total_amount) {
    $discount_amount = $total_amount;
}

$final_total = $total_amount - $discount_amount;

echo json_encode([
    'success' => true,
    'discount_amount' => $discount_amount,
    'final_total' => $final_total,
    'promotion_id' => $promo_id,
    'message' => 'Áp dụng mã giảm giá thành công!'
]);
