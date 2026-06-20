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
        'title' => 'Tour Khám Phá Hà Giang Hùng Vĩ - Cao Nguyên Đá Đồng Văn',
        'slug' => 'kham-pha-ha-giang-hung-vi-' . time(),
        'destination_id' => $in_id,
        'price' => 2800000,
        'duration_days' => 4,
        'duration_nights' => 3,
        'status' => 'active',
        'description' => 'Khám phá vẻ đẹp hoang sơ của cao nguyên đá Đồng Văn, chinh phục đèo Mã Pí Lèng hùng vĩ, trải nghiệm đi thuyền trên dòng sông Nho Quế xanh biếc và tìm hiểu bản sắc văn hóa độc đáo của các dân tộc vùng cao phía Bắc.',
        'thumbnail' => 'https://images.unsplash.com/photo-1620063231464-6d910ba76eec?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Nghỉ Dưỡng Vinpearl Phú Quốc Khởi Hành Từ TP.HCM',
        'slug' => 'nghi-duong-vinpearl-phu-quoc-' . time(),
        'destination_id' => $in_id,
        'price' => 5500000,
        'duration_days' => 3,
        'duration_nights' => 2,
        'status' => 'active',
        'description' => 'Tận hưởng kỳ nghỉ dưỡng xa hoa tại tổ hợp Vinpearl Phú Quốc. Vui chơi thỏa thích tại VinWonders, khám phá công viên chăm sóc bảo tồn động vật bán hoang dã lớn nhất Việt Nam Vinpearl Safari và tắm biển xanh cát trắng.',
        'thumbnail' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Khám Phá Đảo Ngọc Lý Sơn - Vương Quốc Tỏi',
        'slug' => 'kham-pha-dao-ngoc-ly-son-' . time(),
        'destination_id' => $in_id,
        'price' => 3200000,
        'duration_days' => 3,
        'duration_nights' => 2,
        'status' => 'active',
        'description' => 'Check-in cổng Tò Vò lúc hoàng hôn, chinh phục đỉnh Thới Lới bao la, tắm biển trong vắt tại Đảo Bé và thưởng thức hải sản tươi ngon cùng đặc sản tỏi đen trứ danh của vùng biển Quảng Ngãi.',
        'thumbnail' => 'https://images.unsplash.com/photo-1558299104-e51cde624ed7?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Hành Hương Miền Tây - Về Miền Sông Nước',
        'slug' => 'hanh-huong-mien-tay-song-nuoc-' . time(),
        'destination_id' => $in_id,
        'price' => 1900000,
        'duration_days' => 2,
        'duration_nights' => 1,
        'status' => 'active',
        'description' => 'Tham quan Chợ nổi Cái Răng sầm uất lúc bình minh, dạo bước qua các vườn cây ăn trái trĩu quả, nghe Đờn ca tài tử Nam Bộ và thưởng thức các món ăn dân dã đậm chất miền Tây Nam Bộ.',
        'thumbnail' => 'https://images.unsplash.com/photo-1610408544465-b1ab73f9104a?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Khám Phá Hang Sơn Đoòng (Tour Thám Hiểm Chuyên Nghiệp)',
        'slug' => 'kham-pha-hang-son-doong-' . time(),
        'destination_id' => $in_id,
        'price' => 69000000,
        'duration_days' => 6,
        'duration_nights' => 5,
        'status' => 'active',
        'description' => 'Chuyến thám hiểm hang động lớn nhất thế giới. Đi bộ xuyên rừng nhiệt đới, lội suối, cắm trại bên trong hang động khổng lồ. Yêu cầu thể lực tốt. Đội ngũ chuyên gia an toàn quốc tế sẽ đồng hành cùng bạn.',
        'thumbnail' => 'https://images.unsplash.com/photo-1544073380-482a61343729?auto=format&fit=crop&q=80&w=800'
    ],
    // Ngoài nước
    [
        'title' => 'Tour Mùa Thu Nhật Bản - Cung Đường Vàng Tokyo - Kyoto - Osaka',
        'slug' => 'mua-thu-nhat-ban-cung-duong-vang-' . time(),
        'destination_id' => $out_id,
        'price' => 28900000,
        'duration_days' => 6,
        'duration_nights' => 5,
        'status' => 'active',
        'description' => 'Chiêm ngưỡng sắc đỏ rực rỡ của mùa lá phong Nhật Bản. Viếng thăm đền Asakusa Kannon, ngắm nhìn núi Phú Sĩ hùng vĩ, trải nghiệm tắm suối nước nóng Onsen truyền thống và thỏa sức mua sắm tại Akihabara.',
        'thumbnail' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Hàn Quốc Lãng Mạn - Đảo Nami - Công Viên Everland',
        'slug' => 'han-quoc-lang-man-dao-nami-' . time(),
        'destination_id' => $out_id,
        'price' => 15500000,
        'duration_days' => 5,
        'duration_nights' => 4,
        'status' => 'active',
        'description' => 'Bước vào không gian lãng mạn của bộ phim Bản Tình Ca Mùa Đông tại đảo Nami. Khám phá cung điện Gyeongbokgung cổ kính, mặc trang phục Hanbok truyền thống và vui chơi tại công viên giải trí Everland lớn nhất Hàn Quốc.',
        'thumbnail' => 'https://images.unsplash.com/photo-1538681105587-85640961bf8b?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Châu Âu Tráng Lệ: Pháp - Thụy Sĩ - Ý - Vatican',
        'slug' => 'chau-au-trang-le-phap-thuy-si-y-' . time(),
        'destination_id' => $out_id,
        'price' => 59000000,
        'duration_days' => 11,
        'duration_nights' => 10,
        'status' => 'active',
        'description' => 'Hành trình mơ ước đi qua 4 quốc gia đẹp nhất Châu Âu. Thăm tháp Eiffel lộng lẫy, ngắm núi tuyết Titlis huyền thoại, đi thuyền Gondola lãng mạn ở Venice và chiêm ngưỡng đấu trường La Mã Colosseum.',
        'thumbnail' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Bali Huyền Bí - Thiên Đường Nghỉ Dưỡng',
        'slug' => 'bali-huyen-bi-thien-duong-' . time(),
        'destination_id' => $out_id,
        'price' => 11500000,
        'duration_days' => 4,
        'duration_nights' => 3,
        'status' => 'active',
        'description' => 'Đến với Hòn đảo của các vị thần. Check-in tại Cổng Trời Lempuyang nổi tiếng, tham quan đền suối thiêng Tirta Empul, xích đu Bali Swing giữa rừng nhiệt đới và ngắm hoàng hôn rực rỡ tại đền Tanah Lot.',
        'thumbnail' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Tour Thái Lan Siêu Khuyến Mãi: Bangkok - Pattaya',
        'slug' => 'thai-lan-sieu-khuyen-mai-bangkok-pattaya-' . time(),
        'destination_id' => $out_id,
        'price' => 6900000,
        'duration_days' => 5,
        'duration_nights' => 4,
        'status' => 'active',
        'description' => 'Khám phá xứ sở Chùa Vàng sôi động. Tham quan Chùa Thuyền Wat Yannawa linh thiêng, xem show biểu diễn nghệ thuật đặc sắc của người chuyển giới Alcazar Show, dạo thuyền trên sông Chao Phraya và ăn trưa Buffet tại tòa nhà 86 tầng.',
        'thumbnail' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&q=80&w=800'
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

echo "Thành công chèn thêm $count tour du lịch trọn gói!\n";
?>
