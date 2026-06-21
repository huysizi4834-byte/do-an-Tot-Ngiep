<?php
require 'includes/db.php';

$comments = [
    "Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.",
    "Rất đáng tiền, tôi sẽ giới thiệu cho người thân.",
    "Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.",
    "Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.",
    "Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!"
];

// Get users
$user_ids = [];
$res_users = mysqli_query($conn, "SELECT id FROM users");
while($row = mysqli_fetch_assoc($res_users)) {
    $user_ids[] = $row['id'];
}

if(empty($user_ids)) die("Không có user nào trong CSDL.\n");

// Get services
$service_ids = [];
$res_services = mysqli_query($conn, "SELECT id FROM additional_services");
while($row = mysqli_fetch_assoc($res_services)) {
    $service_ids[] = $row['id'];
}

if(empty($service_ids)) die("Không có dịch vụ nào trong CSDL.\n");

$count = 0;
foreach($service_ids as $sid) {
    // 5 reviews per service
    for ($i = 0; $i < 5; $i++) {
        $uid = $user_ids[array_rand($user_ids)];
        $content = $comments[array_rand($comments)];
        $rating = 5;
        $timestamp = time() - rand(0, 30 * 24 * 60 * 60);
        $created_at = date('Y-m-d H:i:s', $timestamp);
        
        $stmt = $conn->prepare("INSERT INTO service_reviews (user_id, service_id, rating, comment, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $uid, $sid, $rating, $content, $created_at);
        if($stmt->execute()) {
            $count++;
        }
    }
}

echo "Đã tạo thành công $count bình luận (5 sao) cho toàn bộ " . count($service_ids) . " dịch vụ!\n";
?>
