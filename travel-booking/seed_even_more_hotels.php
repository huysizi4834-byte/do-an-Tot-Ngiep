<?php
require 'includes/db.php';

$hotels = [
    // Trong nước
    [
        'name' => 'InterContinental Danang Sun Peninsula Resort',
        'city' => 'Đà Nẵng',
        'address' => 'Bãi Bắc, Bán Đảo Sơn Trà, Đà Nẵng, Việt Nam',
        'star_rating' => 5,
        'price_per_night' => 12500000,
        'description' => 'Khu nghỉ dưỡng sang trọng bậc nhất trên bán đảo Sơn Trà, với thiết kế độc đáo của kiến trúc sư Bill Bensley. Các biệt thự ẩn mình giữa rừng nguyên sinh với tầm nhìn tuyệt đẹp ra Vịnh Bãi Bắc.',
        'thumbnail' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Six Senses Ninh Van Bay',
        'city' => 'Nha Trang',
        'address' => 'Vịnh Ninh Vân, Ninh Hòa, Khánh Hòa, Việt Nam',
        'star_rating' => 5,
        'price_per_night' => 18000000,
        'description' => 'Khu nghỉ dưỡng sinh thái cao cấp với những căn villa bằng gỗ nằm chênh vênh trên những tảng đá khổng lồ. Tách biệt hoàn toàn với thế giới bên ngoài, mang lại trải nghiệm bình yên tuyệt đối.',
        'thumbnail' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Hotel de la Coupole - MGallery',
        'city' => 'Sapa',
        'address' => 'Số 1 Phạm Xuân Huân, Sapa, Lào Cai, Việt Nam',
        'star_rating' => 5,
        'price_per_night' => 3500000,
        'description' => 'Kiệt tác kiến trúc Đông Dương lộng lẫy giữa sương mù Sapa. Nổi bật với màu vàng mù tạt, những vòm cong và thiết kế lấy cảm hứng từ thời trang cao cấp của Pháp và bản sắc Tây Bắc.',
        'thumbnail' => 'https://images.unsplash.com/photo-1551882547-ff40c0d5852a?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Four Seasons Resort The Nam Hai',
        'city' => 'Hội An',
        'address' => 'Khối Hà My, Điện Dương, Điện Bàn, Quảng Nam, Việt Nam',
        'star_rating' => 5,
        'price_per_night' => 20000000,
        'description' => 'Ốc đảo thanh bình bên bờ biển Hà My thơ mộng. Khu nghỉ dưỡng sang trọng bậc nhất thế giới mang đậm triết lý phong thủy và sự cân bằng âm dương.',
        'thumbnail' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Amanoi Resort',
        'city' => 'Ninh Thuận',
        'address' => 'Thôn Vĩnh Hy, Vĩnh Hải, Ninh Hải, Ninh Thuận, Việt Nam',
        'star_rating' => 5,
        'price_per_night' => 25000000,
        'description' => 'Resort 6 sao đầu tiên tại Việt Nam, nằm giữa Vườn quốc gia Núi Chúa và vịnh Vĩnh Hy. Mang đến sự riêng tư tuyệt đối, spa trị liệu chuyên sâu và phong cảnh thiên nhiên hoang sơ.',
        'thumbnail' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800'
    ],
    
    // Ngoài nước
    [
        'name' => 'Marina Bay Sands',
        'city' => 'Singapore',
        'address' => '10 Bayfront Avenue, Singapore',
        'star_rating' => 5,
        'price_per_night' => 15000000,
        'description' => 'Biểu tượng của Singapore với thiết kế con tàu khổng lồ vắt ngang qua 3 tòa tháp. Nổi tiếng với hồ bơi vô cực cao nhất thế giới và khu trung tâm mua sắm, sòng bạc sầm uất.',
        'thumbnail' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'The Ritz-Carlton',
        'city' => 'Kyoto',
        'address' => 'Kamogawa Nijo-Ohashi Hotori, Nakagyo Ward, Kyoto, Nhật Bản',
        'star_rating' => 5,
        'price_per_night' => 28000000,
        'description' => 'Nép mình bên dòng sông Kamogawa thanh bình, khách sạn mang đậm kiến trúc Ryokan truyền thống Nhật Bản pha lẫn sự tinh tế sang trọng của thương hiệu Ritz-Carlton.',
        'thumbnail' => 'https://images.unsplash.com/photo-1518733057094-95b53143d2a7?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Four Seasons Hotel George V',
        'city' => 'Paris',
        'address' => '31 Avenue George V, 75008 Paris, Pháp',
        'star_rating' => 5,
        'price_per_night' => 45000000,
        'description' => 'Khách sạn huyền thoại nằm gần đại lộ Champs-Elysées. Từng phòng đều được trang trí bằng nghệ thuật cổ điển Pháp và nơi đây sở hữu các nhà hàng Michelin danh giá.',
        'thumbnail' => 'https://images.unsplash.com/photo-1596436889106-be35e843f6a6?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'Burj Al Arab Jumeirah',
        'city' => 'Dubai',
        'address' => 'Jumeirah St, Dubai, Các Tiểu vương quốc Ả Rập Thống nhất',
        'star_rating' => 5,
        'price_per_night' => 40000000,
        'description' => 'Khách sạn hình cánh buồm nổi bật trên nền trời Dubai, thường được mệnh danh là khách sạn 7 sao duy nhất trên thế giới với sự xa hoa vượt qua mọi chuẩn mực.',
        'thumbnail' => 'https://images.unsplash.com/photo-1580637250482-132d0f5080b0?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'name' => 'The Plaza',
        'city' => 'New York',
        'address' => '768 5th Ave, New York, NY 10019, Hoa Kỳ',
        'star_rating' => 5,
        'price_per_night' => 20000000,
        'description' => 'Tọa lạc ngay góc Công viên Trung tâm (Central Park), The Plaza là biểu tượng lịch sử của New York, xuất hiện trong vô số bộ phim nổi tiếng và mang phong cách lâu đài kiểu Pháp xa hoa.',
        'thumbnail' => 'https://images.unsplash.com/photo-1541971875076-8f970d573be6?auto=format&fit=crop&q=80&w=800'
    ]
];

$count = 0;
foreach ($hotels as $hotel) {
    $name = mysqli_real_escape_string($conn, $hotel['name']);
    $city = mysqli_real_escape_string($conn, $hotel['city']);
    $address = mysqli_real_escape_string($conn, $hotel['address']);
    $star_rating = (int) $hotel['star_rating'];
    $price_per_night = (int) $hotel['price_per_night'];
    $description = mysqli_real_escape_string($conn, $hotel['description']);
    $thumbnail = mysqli_real_escape_string($conn, $hotel['thumbnail']);
    
    $sql = "INSERT INTO hotels (name, city, address, star_rating, price_per_night, description, thumbnail) 
            VALUES ('$name', '$city', '$address', $star_rating, $price_per_night, '$description', '$thumbnail')";
            
    if (mysqli_query($conn, $sql)) {
        $count++;
    } else {
        echo "Lỗi khi chèn " . $hotel['name'] . ": " . mysqli_error($conn) . "<br>";
    }
}

echo "Thành công chèn thêm $count khách sạn trong và ngoài nước!\n";
?>
