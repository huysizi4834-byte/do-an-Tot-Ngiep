<?php
require 'includes/db.php';

$hotels = [
    [
        'name' => 'Vinpearl Landmark 81, Autograph Collection',
        'city' => 'TP. Hồ Chí Minh',
        'address' => '720A Điện Biên Phủ, Phường 22, Quận Bình Thạnh, TP. Hồ Chí Minh',
        'star_rating' => 5,
        'price_per_night' => 3500000,
        'thumbnail' => 'https://images.unsplash.com/photo-1542314831-c6a4d27df08f?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Khách sạn cao nhất Việt Nam với tầm nhìn ngoạn mục ra sông Sài Gòn. Trải nghiệm dịch vụ 5 sao chuẩn quốc tế đẳng cấp.'
    ],
    [
        'name' => 'Mường Thanh Luxury Đà Nẵng',
        'city' => 'Đà Nẵng',
        'address' => '270 Võ Nguyên Giáp, Bắc Mỹ Phú, Ngũ Hành Sơn, Đà Nẵng',
        'star_rating' => 5,
        'price_per_night' => 1800000,
        'thumbnail' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Nằm ngay bãi biển Mỹ Khê tuyệt đẹp, khách sạn cung cấp phòng nghỉ sang trọng và hồ bơi ngoài trời tuyệt vời.'
    ],
    [
        'name' => 'InterContinental Hanoi Westlake',
        'city' => 'Hà Nội',
        'address' => '05 Từ Hoa, Tây Hồ, Hà Nội',
        'star_rating' => 5,
        'price_per_night' => 2900000,
        'thumbnail' => 'https://images.unsplash.com/photo-1551882547-ff40c0d13c21?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Kiến trúc độc đáo nằm nổi trên mặt nước Hồ Tây, mang đến không gian yên tĩnh ngay giữa lòng thủ đô.'
    ],
    [
        'name' => 'Novotel Phu Quoc Resort',
        'city' => 'Phú Quốc',
        'address' => 'Đường Bào, Dương Tơ, Phú Quốc',
        'star_rating' => 4,
        'price_per_night' => 2100000,
        'thumbnail' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Khu nghỉ dưỡng tuyệt vời dành cho gia đình với nhiều tiện ích giải trí và ẩm thực đa dạng.'
    ]
];

$success_count = 0;
foreach ($hotels as $h) {
    $stmt = mysqli_prepare($conn, "INSERT INTO hotels (name, city, address, star_rating, price_per_night, thumbnail, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssidss", $h['name'], $h['city'], $h['address'], $h['star_rating'], $h['price_per_night'], $h['thumbnail'], $h['description']);
    if (mysqli_stmt_execute($stmt)) {
        $success_count++;
    }
}

echo "Inserted $success_count hotels successfully.\n";
