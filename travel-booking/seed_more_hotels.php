<?php
require 'includes/db.php';

$hotels = [
    [
        'name' => 'The Plaza Hotel',
        'city' => 'New York',
        'address' => '768 5th Ave, New York, NY 10019, Hoa Kỳ',
        'star_rating' => 5,
        'price_per_night' => 15000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1541971875076-8f970d573be6?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Khách sạn mang tính biểu tượng ở trung tâm Manhattan, kế bên Công viên Trung tâm.'
    ],
    [
        'name' => 'Waldorf Astoria Beverly Hills',
        'city' => 'Los Angeles',
        'address' => '9850 Wilshire Blvd, Beverly Hills, CA 90210, Hoa Kỳ',
        'star_rating' => 5,
        'price_per_night' => 18000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Nghỉ dưỡng xa hoa tại Beverly Hills với dịch vụ đẳng cấp thế giới.'
    ],
    [
        'name' => 'Shangri-La Hotel, Paris',
        'city' => 'Paris',
        'address' => '10 Av. d\'Iéna, 75116 Paris, Pháp',
        'star_rating' => 5,
        'price_per_night' => 25000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Khách sạn cổ điển mang kiến trúc Pháp với tầm nhìn bao quát tháp Eiffel.'
    ],
    [
        'name' => 'The Ritz London',
        'city' => 'London',
        'address' => '150 Piccadilly, St. James\'s, London W1J 9BR, Vương quốc Anh',
        'star_rating' => 5,
        'price_per_night' => 22000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Sự sang trọng bậc nhất mang đậm phong cách hoàng gia Anh.'
    ],
    [
        'name' => 'Aman Tokyo',
        'city' => 'Tokyo',
        'address' => 'The Otemachi Tower, 1-5-6 Otemachi, Chiyoda City, Tokyo 100-0004, Nhật Bản',
        'star_rating' => 5,
        'price_per_night' => 28000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1542051812-df28eb19cb98?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Ốc đảo yên bình giữa lòng thủ đô sầm uất với thiết kế tối giản truyền thống Nhật.'
    ],
    [
        'name' => 'The Ritz-Carlton, Kyoto',
        'city' => 'Kyoto',
        'address' => 'Kamogawa Nijo-Ohashi Hotori, Nakagyo Ward, Kyoto, 604-0902, Nhật Bản',
        'star_rating' => 5,
        'price_per_night' => 30000000,
        'thumbnail' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Trải nghiệm đỉnh cao của lòng hiếu khách Nhật Bản bên bờ sông Kamo.'
    ],
    [
        'name' => 'Khu nghỉ dưỡng Melia Vinpearl Phú Quốc',
        'city' => 'Phú Quốc',
        'address' => 'Bãi Dài, Gành Dầu, Phú Quốc, Kiên Giang',
        'star_rating' => 5,
        'price_per_night' => 3240000,
        'thumbnail' => 'https://images.unsplash.com/photo-1580828551405-b1a99908da62?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Tận hưởng kỳ nghỉ dưỡng trọn vẹn với các biệt thự có hồ bơi riêng.'
    ],
    [
        'name' => 'Amiana Resort Nha Trang',
        'city' => 'Nha Trang',
        'address' => 'Phạm Văn Đồng, Vĩnh Hải, Nha Trang',
        'star_rating' => 5,
        'price_per_night' => 2500000,
        'thumbnail' => 'https://images.unsplash.com/photo-1601006527582-777e07661b36?q=80&w=2000&auto=format&fit=crop',
        'description' => 'Khu nghỉ dưỡng với bãi biển riêng trong vắt và tắm bùn độc đáo.'
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

echo "Inserted $success_count more hotels successfully.\n";
