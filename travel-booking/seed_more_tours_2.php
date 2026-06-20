<?php
require 'includes/db.php';

// Lấy id của destination
$query_in = mysqli_query($conn, "SELECT id FROM destinations WHERE slug = 'trong-nuoc' LIMIT 1");
$in_id = mysqli_fetch_assoc($query_in)['id'] ?? 1;

$query_out = mysqli_query($conn, "SELECT id FROM destinations WHERE slug = 'ngoai-nuoc' LIMIT 1");
$out_id = mysqli_fetch_assoc($query_out)['id'] ?? 2;

$tours = [
    // Trong nước
    [
        'title' => 'Tour Săn Mây Tà Xùa - Mộc Châu',
        'slug' => 'san-may-ta-xua-moc-chau-' . time(),
        'destination_id' => $in_id,
        'price' => 1850000,
        'duration_days' => 2,
        'duration_nights' => 1,
        'status' => 'active',
        'description' => 'Trải nghiệm săn mây trên đỉnh Tà Xùa hùng vĩ, check-in sống lưng khủng long, và khám phá những đồi chè xanh mướt trải dài vô tận tại cao nguyên Mộc Châu.',
        'thumbnail' => 'https://images.unsplash.com/photo-1549463283-e35b7e289fbd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Vịnh Hạ Long - Du Thuyền 5 Sao',
        'slug' => 'vinh-ha-long-du-thuyen-5-sao-' . time(),
        'destination_id' => $in_id,
        'price' => 3500000,
        'duration_days' => 2,
        'duration_nights' => 1,
        'status' => 'active',
        'description' => 'Nghỉ dưỡng trên du thuyền 5 sao sang trọng giữa Di sản thiên nhiên thế giới. Thưởng thức tiệc nướng BBQ trên boong tàu, chèo kayak qua các hang động và tham gia lớp học nấu ăn.',
        'thumbnail' => 'https://images.unsplash.com/photo-1506501139174-099022df5260?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Đà Lạt Mộng Mơ - Săn Hoa Dã Quỳ',
        'slug' => 'da-lat-mong-mo-san-hoa-da-quy-' . time(),
        'destination_id' => $in_id,
        'price' => 2200000,
        'duration_days' => 3,
        'duration_nights' => 2,
        'status' => 'active',
        'description' => 'Chìm đắm trong không khí se lạnh của Đà Lạt. Tham quan thung lũng tình yêu, check-in những con đường ngập tràn hoa dã quỳ vàng rực và thưởng thức ẩm thực chợ đêm.',
        'thumbnail' => 'https://images.unsplash.com/photo-1563126839-4467c6999a38?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Khám Phá Quy Nhơn - Phú Yên (Hoa Vàng Trên Cỏ Xanh)',
        'slug' => 'quy-nhon-phu-yen-hoa-vang-' . time(),
        'destination_id' => $in_id,
        'price' => 3800000,
        'duration_days' => 4,
        'duration_nights' => 3,
        'status' => 'active',
        'description' => 'Hành trình biển đảo tuyệt đẹp. Chiêm ngưỡng Eo Gió hùng vĩ, lặn ngắm san hô tại Kỳ Co, check-in Bãi Xép hoang sơ và chinh phục Gành Đá Đĩa kỳ thú.',
        'thumbnail' => 'https://images.unsplash.com/photo-1596700512803-b8a92fc0b4e0?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Côn Đảo Tâm Linh & Nghỉ Dưỡng',
        'slug' => 'con-dao-tam-linh-nghi-duong-' . time(),
        'destination_id' => $in_id,
        'price' => 6500000,
        'duration_days' => 3,
        'duration_nights' => 2,
        'status' => 'active',
        'description' => 'Viếng nghĩa trang Hàng Dương thiêng liêng, tham quan di tích nhà tù Côn Đảo và thư giãn trên những bãi biển hoang sơ, trong vắt đẹp nhất hành tinh.',
        'thumbnail' => 'https://images.unsplash.com/photo-1559592413-7cecaed7b727?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Sapa Kính Luân - Fansipan Legend',
        'slug' => 'sapa-kinh-luan-fansipan-' . time(),
        'destination_id' => $in_id,
        'price' => 2800000,
        'duration_days' => 3,
        'duration_nights' => 2,
        'status' => 'active',
        'description' => 'Chinh phục nóc nhà Đông Dương bằng cáp treo ngoạn mục. Dạo bước qua Bản Cát Cát của người H’Mông, thưởng thức cá hồi Sapa và chiêm ngưỡng ruộng bậc thang tuyệt đẹp.',
        'thumbnail' => 'https://images.unsplash.com/photo-1551882547-ff40c0d5852a?auto=format&fit=crop&q=80&w=800'
    ],

    // Ngoài nước
    [
        'title' => 'Tour Khám Phá Úc Châu: Sydney - Melbourne',
        'slug' => 'kham-pha-uc-chau-sydney-melbourne-' . time(),
        'destination_id' => $out_id,
        'price' => 45000000,
        'duration_days' => 7,
        'duration_nights' => 6,
        'status' => 'active',
        'description' => 'Check-in Nhà hát Con Sò biểu tượng, dạo bước trên cầu cảng Sydney, ngắm cảnh đẹp trên cung đường ven biển Great Ocean Road và xem cuộc diễu hành của chim cánh cụt.',
        'thumbnail' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Mỹ Bờ Tây: Los Angeles - Las Vegas - San Francisco',
        'slug' => 'my-bo-tay-los-angeles-las-vegas-' . time(),
        'destination_id' => $out_id,
        'price' => 75000000,
        'duration_days' => 9,
        'duration_nights' => 8,
        'status' => 'active',
        'description' => 'Trải nghiệm nhịp sống sôi động tại Hollywood, thử vận may ở sòng bạc Las Vegas xa hoa, chiêm ngưỡng Grand Canyon kỳ vĩ và dạo bước qua cầu Cổng Vàng sương mù.',
        'thumbnail' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Dubai - Abu Dhabi Siêu Sang',
        'slug' => 'dubai-abu-dhabi-sieu-sang-' . time(),
        'destination_id' => $out_id,
        'price' => 25900000,
        'duration_days' => 5,
        'duration_nights' => 4,
        'status' => 'active',
        'description' => 'Tham quan tòa tháp cao nhất thế giới Burj Khalifa, đua xe Jeep trên sa mạc rực lửa, cưỡi lạc đà và chiêm ngưỡng Thánh đường Hồi giáo Sheikh Zayed dát vàng ngọc.',
        'thumbnail' => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Đài Loan: Đài Bắc - Đài Trung - Cao Hùng',
        'slug' => 'dai-loan-dai-bac-dai-trung-' . time(),
        'destination_id' => $out_id,
        'price' => 12500000,
        'duration_days' => 5,
        'duration_nights' => 4,
        'status' => 'active',
        'description' => 'Thả đèn trời ước nguyện tại Thập Phần, dạo phố cổ Cửu Phần, đi thuyền trên Hồ Nhật Nguyệt thơ mộng và thưởng thức ẩm thực đường phố tại chợ đêm Sĩ Lâm.',
        'thumbnail' => 'https://images.unsplash.com/photo-1552993873-0aa1140e76fb?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Khám Phá Trung Hoa: Bắc Kinh - Thượng Hải - Hàng Châu',
        'slug' => 'kham-pha-trung-hoa-bac-kinh-' . time(),
        'destination_id' => $out_id,
        'price' => 18900000,
        'duration_days' => 6,
        'duration_nights' => 5,
        'status' => 'active',
        'description' => 'Chinh phục Vạn Lý Trường Thành hùng vĩ, tham quan Tử Cấm Thành uy nghi, dạo thuyền ngoạn cảnh Tây Hồ và ngắm nhìn sự sầm uất của Bến Thượng Hải về đêm.',
        'thumbnail' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Maldives - Thiên Đường Biển Đảo Tình Yêu',
        'slug' => 'maldives-thien-duong-bien-dao-' . time(),
        'destination_id' => $out_id,
        'price' => 39000000,
        'duration_days' => 5,
        'duration_nights' => 4,
        'status' => 'active',
        'description' => 'Kỳ nghỉ lãng mạn tại các Water Villa tuyệt đẹp. Lặn ngắm san hô cùng rùa biển, thưởng thức hải sản trên bãi cát trắng mịn và ngắm bầu trời sao kỳ diệu về đêm.',
        'thumbnail' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&q=80&w=800'
    ]
];

$count = 0;
foreach ($tours as $t) {
    $title = mysqli_real_escape_string($conn, $t['title']);
    $slug = mysqli_real_escape_string($conn, $t['slug']);
    $destination_id = (int) $t['destination_id'];
    $price = (int) $t['price'];
    $duration_days = (int) $t['duration_days'];
    $duration_nights = (int) $t['duration_nights'];
    $status = mysqli_real_escape_string($conn, $t['status']);
    $description = mysqli_real_escape_string($conn, $t['description']);
    $thumbnail = mysqli_real_escape_string($conn, $t['thumbnail']);
    
    $sql = "INSERT INTO tours (title, slug, destination_id, price, duration_days, duration_nights, status, description, thumbnail, created_at) 
            VALUES ('$title', '$slug', $destination_id, $price, $duration_days, $duration_nights, '$status', '$description', '$thumbnail', NOW())";
            
    if (mysqli_query($conn, $sql)) {
        $count++;
    } else {
        echo "Lỗi khi chèn tour {$title}: " . mysqli_error($conn) . "<br>";
    }
}

echo "Thành công chèn thêm $count tour du lịch trọn gói tuyệt đỉnh!\n";
?>
