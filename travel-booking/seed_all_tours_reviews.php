<?php
require 'includes/db.php';

// Các mẫu bình luận 5 sao
$comments = [
    "Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.",
    "Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!",
    "Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.",
    "Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!",
    "Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.",
    "Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.",
    "Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.",
    "Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.",
    "Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.",
    "Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết."
];

// Lấy danh sách toàn bộ user IDs
$user_ids = [];
$res_users = mysqli_query($conn, "SELECT id FROM users");
while($row = mysqli_fetch_assoc($res_users)) {
    $user_ids[] = $row['id'];
}

if(empty($user_ids)) {
    die("Cần ít nhất 1 user trong CSDL.\n");
}

// Lấy danh sách toàn bộ tour IDs
$tour_ids = [];
$res_tours = mysqli_query($conn, "SELECT id FROM tours");
while($row = mysqli_fetch_assoc($res_tours)) {
    $tour_ids[] = $row['id'];
}

if(empty($tour_ids)) {
    die("Không có tour nào trong CSDL.\n");
}

$count = 0;
foreach($tour_ids as $tid) {
    // Mỗi tour tạo 5 đánh giá 5 sao
    for ($i = 0; $i < 5; $i++) {
        $uid = $user_ids[array_rand($user_ids)];
        $content = $comments[array_rand($comments)];
        $rating = 5;
        
        // Random thời gian (trong vòng 60 ngày qua)
        $timestamp = time() - rand(0, 60 * 24 * 60 * 60);
        $created_at = date('Y-m-d H:i:s', $timestamp);
        
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, tour_id, rating, comment, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $uid, $tid, $rating, $content, $created_at);
        if($stmt->execute()) {
            $count++;
        }
    }
}

echo "Đã tạo thành công $count bình luận (5 sao) cho toàn bộ " . count($tour_ids) . " tours trong hệ thống!\n";
?>
