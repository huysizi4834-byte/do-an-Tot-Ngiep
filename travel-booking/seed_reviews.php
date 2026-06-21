<?php
// Script này được dùng để tạo dữ liệu mẫu cho tính năng đánh giá Tour
require 'includes/db.php';

// Các mẫu bình luận
$comments = [
    [
        'rating' => 5,
        'content' => "Tour rất tuyệt vời, hướng dẫn viên nhiệt tình, chu đáo. Lịch trình hợp lý, đồ ăn ngon và phong cảnh thì quá đẹp. Chắc chắn sẽ quay lại!"
    ],
    [
        'rating' => 4,
        'content' => "Nhìn chung chuyến đi khá tốt. Khách sạn sạch sẽ, thoải mái. Tuy nhiên ngày thứ 2 lịch trình hơi dày đặc nên đi bộ hơi mệt."
    ],
    [
        'rating' => 5,
        'content' => "Trải nghiệm trên cả mong đợi! Gia đình mình đã có những kỷ niệm thật đẹp. Cảm ơn công ty du lịch đã tổ chức rất chuyên nghiệp."
    ],
    [
        'rating' => 5,
        'content' => "Giá cả vô cùng hợp lý so với chất lượng nhận được. Đồ ăn đặc sản địa phương rất ngon. Xe di chuyển êm ái, bác tài vui tính."
    ],
    [
        'rating' => 3,
        'content' => "Cảnh đẹp nhưng thời tiết lúc mình đi không được thuận lợi lắm nên chưa trải nghiệm được hết. Hướng dẫn viên thân thiện nhưng cần cải thiện thêm về thời gian tập trung."
    ],
    [
        'rating' => 4,
        'content' => "Mọi thứ đều ok, gia đình mình ai cũng thích. Chỗ ở gần trung tâm rất tiện đi lại buổi tối."
    ],
    [
        'rating' => 5,
        'content' => "Tuyệt vời ông mặt trời! Đáng đồng tiền bát gạo, vote 5 sao cho chất lượng dịch vụ của công ty nha."
    ]
];

// Lấy danh sách user IDs
$user_ids = [];
$res_users = mysqli_query($conn, "SELECT id FROM users LIMIT 10");
while($row = mysqli_fetch_assoc($res_users)) {
    $user_ids[] = $row['id'];
}

// Lấy danh sách tour IDs
$tour_ids = [];
$res_tours = mysqli_query($conn, "SELECT id FROM tours LIMIT 10");
while($row = mysqli_fetch_assoc($res_tours)) {
    $tour_ids[] = $row['id'];
}

if(empty($user_ids) || empty($tour_ids)) {
    die("Cần ít nhất 1 user và 1 tour trong CSDL để tạo bình luận mẫu.\n");
}

$count = 0;
foreach($comments as $c) {
    // Random user và tour
    $uid = $user_ids[array_rand($user_ids)];
    $tid = $tour_ids[array_rand($tour_ids)];
    
    // Random thời gian (trong vòng 30 ngày qua)
    $timestamp = time() - rand(0, 30 * 24 * 60 * 60);
    $created_at = date('Y-m-d H:i:s', $timestamp);
    
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, tour_id, rating, comment, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $uid, $tid, $c['rating'], $c['content'], $created_at);
    if($stmt->execute()) {
        $count++;
    }
}

echo "Đã tạo thành công $count bình luận mẫu vào cơ sở dữ liệu!\n";
?>
