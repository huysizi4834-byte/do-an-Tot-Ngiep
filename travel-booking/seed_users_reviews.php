<?php
require 'includes/db.php';

$password_plain = 'huy123';
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

$new_users = [
    ['full_name' => 'Nguyễn Văn A', 'email' => 'nguyenvana@gmail.com', 'phone' => '0912345671'],
    ['full_name' => 'Trần Thị B', 'email' => 'tranthib@gmail.com', 'phone' => '0912345672'],
    ['full_name' => 'Lê Hoàng C', 'email' => 'lehoangc@gmail.com', 'phone' => '0912345673'],
    ['full_name' => 'Phạm Minh D', 'email' => 'phamminhd@gmail.com', 'phone' => '0912345674'],
    ['full_name' => 'Đặng Thu E', 'email' => 'dangthue@gmail.com', 'phone' => '0912345675'],
];

// Các mẫu bình luận
$comments = [
    ['rating' => 5, 'content' => "Trải nghiệm rất tốt! Chuyến đi đáng nhớ cùng gia đình. Hướng dẫn viên rất vui vẻ."],
    ['rating' => 4, 'content' => "Dịch vụ phòng khách sạn ổn, xe đưa đón đúng giờ. Hơi mệt vì lịch trình đi bộ nhiều."],
    ['rating' => 5, 'content' => "Mọi thứ hoàn hảo! Rất đáng tiền, mình sẽ giới thiệu cho bạn bè tham gia tour này."],
    ['rating' => 4, 'content' => "Khá hài lòng với chất lượng phục vụ của công ty. Đồ ăn các bữa chính rất hợp khẩu vị."],
    ['rating' => 5, 'content' => "Chuyến đi tuyệt vời nhất từ trước tới nay. Cảnh đẹp tuyệt trần, dịch vụ chăm sóc khách hàng 10 điểm."]
];

// Lấy danh sách tour IDs
$tour_ids = [];
$res_tours = mysqli_query($conn, "SELECT id FROM tours LIMIT 10");
while($row = mysqli_fetch_assoc($res_tours)) {
    $tour_ids[] = $row['id'];
}

if(empty($tour_ids)) {
    die("Cần ít nhất 1 tour trong CSDL để tạo bình luận mẫu.\n");
}

$user_count = 0;
$review_count = 0;

foreach($new_users as $index => $u) {
    // Check if user exists
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($check, "s", $u['email']);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    
    $user_id = null;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
    } else {
        // Insert new user
        $stmt = mysqli_prepare($conn, "INSERT INTO users (full_name, email, phone, password_hash, role, status, created_at) VALUES (?, ?, ?, ?, 'user', 'active', NOW())");
        mysqli_stmt_bind_param($stmt, "ssss", $u['full_name'], $u['email'], $u['phone'], $password_hash);
        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($conn);
            $user_count++;
        }
    }
    
    // Insert review
    if ($user_id) {
        $tid = $tour_ids[array_rand($tour_ids)];
        $c = $comments[$index % count($comments)];
        $timestamp = time() - rand(0, 5 * 24 * 60 * 60);
        $created_at = date('Y-m-d H:i:s', $timestamp);
        
        $r_stmt = $conn->prepare("INSERT INTO reviews (user_id, tour_id, rating, comment, created_at) VALUES (?, ?, ?, ?, ?)");
        $r_stmt->bind_param("iiiss", $user_id, $tid, $c['rating'], $c['content'], $created_at);
        if($r_stmt->execute()) {
            $review_count++;
        }
    }
}

echo "Đã tạo thành công $user_count tài khoản mới (mật khẩu chung: huy123) và $review_count bình luận tương ứng!\n";
?>
