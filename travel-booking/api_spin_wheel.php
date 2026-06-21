<?php
session_start();
require 'includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để tham gia.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Kiểm tra hôm nay đã quay chưa (đơn giản hoá: 1 lượt mỗi ngày)
$check_spin = "SELECT id FROM user_promotions WHERE user_id = $user_id AND DATE(claimed_at) = CURDATE() AND status = 'available'";
// Cần bảng riêng theo dõi lượt quay, nhưng để đơn giản, nếu hôm nay có nhận được mã thì coi như đã quay. 
// Nếu muốn chính xác hơn nên có bảng user_spins. Tạm bỏ qua logic chặn quay nhiều lần cho vui hoặc có thể dùng session.
if (isset($_SESSION['last_spin_date']) && $_SESSION['last_spin_date'] === date('Y-m-d')) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'Bạn đã hết lượt quay hôm nay. Hãy quay lại vào ngày mai!']);
        exit;
    }
}

// Tỷ lệ trúng thưởng: 0.1% Jackpot (50% hoặc 100%), 29.9% trúng thường, 70% trượt
$random_chance = rand(1, 1000); // 1 đến 1000

if ($random_chance == 1) {
    // 0.1% trúng Jackpot
    $tier = 'jackpot';
} elseif ($random_chance <= 300) {
    // 29.9% trúng mã thường (từ 2 đến 300)
    $tier = 'normal';
} else {
    // 70% trượt
    $_SESSION['last_spin_date'] = date('Y-m-d');
    echo json_encode(['success' => true, 'won' => false, 'message' => 'Rất tiếc, bạn đã quay trúng ô "Chúc bạn may mắn lần sau"!']);
    exit;
}

// Điều kiện lọc mã theo giải
if ($tier === 'jackpot') {
    $condition = "AND p.code IN ('JACKPOT50', 'JACKPOT100')";
} else {
    $condition = "AND p.code NOT IN ('JACKPOT50', 'JACKPOT100')";
}

// Lấy ngẫu nhiên 1 mã khuyến mại theo điều kiện
$sql = "SELECT p.* FROM promotions p 
        WHERE p.status = 'active' 
        AND p.end_date >= CURDATE() 
        AND (p.usage_limit IS NULL OR p.used_count < p.usage_limit)
        AND p.id NOT IN (SELECT promotion_id FROM user_promotions WHERE user_id = $user_id)
        $condition
        ORDER BY RAND() LIMIT 1";

$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) === 0) {
    // Không trúng hoặc hết mã
    $_SESSION['last_spin_date'] = date('Y-m-d');
    echo json_encode(['success' => true, 'won' => false, 'message' => 'Rất tiếc, bạn đã quay trúng ô "Chúc bạn may mắn lần sau"!']);
    exit;
}

$promo = mysqli_fetch_assoc($res);
$promotion_id = $promo['id'];

// Lưu vào ví
$insert_sql = "INSERT INTO user_promotions (user_id, promotion_id, status) VALUES ($user_id, $promotion_id, 'available')";
if (mysqli_query($conn, $insert_sql)) {
    $_SESSION['last_spin_date'] = date('Y-m-d');
    echo json_encode([
        'success' => true, 
        'won' => true, 
        'message' => 'Chúc mừng! Bạn đã quay trúng mã: ' . $promo['code'] . '. Mã đã được lưu vào Kho Voucher của bạn!'
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống, vui lòng thử lại sau.']);
}
