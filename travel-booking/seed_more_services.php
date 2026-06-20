<?php
require 'includes/db.php';

$services = [
    [
        'name' => 'Thuê Xe Ô Tô Tự Lái (4 chỗ)',
        'description' => 'Trải nghiệm du lịch tự do và thoải mái với dịch vụ thuê xe ô tô 4 chỗ đời mới. Thủ tục nhanh gọn, giao xe tận nơi tại sân bay hoặc khách sạn.',
        'price' => 800000,
        'image_url' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Vé Tham Quan Vinpearl Safari',
        'description' => 'Vé tham quan công viên chăm sóc và bảo tồn động vật bán hoang dã lớn nhất Việt Nam. Trải nghiệm "nhốt người thả thú" độc đáo.',
        'price' => 650000,
        'image_url' => 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Gói Massage & Spa Tại Khách Sạn',
        'description' => 'Thư giãn hoàn toàn sau một ngày dài khám phá với gói massage toàn thân 60 phút do các kỹ thuật viên chuyên nghiệp thực hiện ngay tại spa của khách sạn.',
        'price' => 500000,
        'image_url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Đón/Tiễn Sân Bay Bằng Xe VIP',
        'description' => 'Dịch vụ xe đưa đón sân bay cao cấp với tài xế riêng, bảng tên đón khách. Cung cấp nước suối và khăn lạnh miễn phí. Chuyến đi êm ái, đúng giờ.',
        'price' => 350000,
        'image_url' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Vé Cáp Treo Vượt Biển',
        'description' => 'Thưởng ngoạn khung cảnh thiên nhiên hùng vĩ từ trên cao với vé cáp treo khứ hồi. Bao gồm cả quyền truy cập vào các khu vui chơi giải trí trên đảo.',
        'price' => 550000,
        'image_url' => 'https://images.unsplash.com/photo-1572083582121-655b3f1599e1?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Bữa Tối Lãng Mạn Trên Bãi Biển',
        'description' => 'Set up bàn ăn lãng mạn dành cho 2 người ngay trên bãi biển với nến, hoa hồng và thực đơn hải sản cao cấp. Kỷ niệm không thể nào quên.',
        'price' => 1500000,
        'image_url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Hướng Dẫn Viên Du Lịch Riêng',
        'description' => 'Thuê hướng dẫn viên bản địa am hiểu sâu sắc về văn hóa, lịch sử và ẩm thực địa phương đồng hành cùng bạn suốt cả ngày dài.',
        'price' => 1000000,
        'image_url' => 'https://images.unsplash.com/photo-1506869640319-fe1a24fd76dc?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Vé Tàu Cao Tốc Đi Các Đảo',
        'description' => 'Vé tàu cao tốc khứ hồi đến các hòn đảo lân cận tuyệt đẹp. Tàu chạy êm, an toàn, có điều hòa và áo phao đầy đủ.',
        'price' => 300000,
        'image_url' => 'https://images.unsplash.com/photo-1558299104-e51cde624ed7?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Thuê Thợ Chụp Ảnh Kỷ Niệm',
        'description' => 'Lưu giữ mọi khoảnh khắc đẹp nhất trong chuyến đi với dịch vụ thuê nhiếp ảnh gia chuyên nghiệp đi cùng (gói chụp 4 tiếng, trả toàn bộ file gốc và 20 ảnh edit).',
        'price' => 1200000,
        'image_url' => 'https://images.unsplash.com/photo-1516961642265-531546e84af2?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Gói Trang Trí Phòng Trăng Mật',
        'description' => 'Trang trí phòng tân hôn ngọt ngào với thiên nga gấp bằng khăn tay, cánh hoa hồng rải giường, rượu vang và trái cây tươi đón chào.',
        'price' => 700000,
        'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=800'
    ]
];

$count = 0;
foreach ($services as $service) {
    $name = mysqli_real_escape_string($conn, $service['name']);
    $description = mysqli_real_escape_string($conn, $service['description']);
    $price = $service['price'];
    $image_url = mysqli_real_escape_string($conn, $service['image_url']);
    
    // Check if column original_price exists. I will assume it might not, but let's just insert standard.
    // If we just specify columns it will be safe.
    $sql = "INSERT INTO additional_services (name, description, price, image_url) VALUES ('$name', '$description', $price, '$image_url')";
    
    if (mysqli_query($conn, $sql)) {
        $count++;
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
    }
}

echo "Successfully added $count new additional services!";
?>
