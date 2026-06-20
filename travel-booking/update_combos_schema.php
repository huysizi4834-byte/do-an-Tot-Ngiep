<?php
require 'includes/db.php';

// Add original_price column if not exists
$alter_sql = "ALTER TABLE combos ADD COLUMN original_price DECIMAL(10,2) DEFAULT NULL AFTER price";
if (mysqli_query($conn, $alter_sql)) {
    echo "Added original_price column.\n";
} else {
    echo "Could not add original_price: " . mysqli_error($conn) . "\n";
}

$combos_data = [
    [
        'name' => 'Combo Phú Quốc 3N2Đ: Vé máy bay + Vinpearl Resort',
        'description' => 'Trải nghiệm thiên đường nghỉ dưỡng Phú Quốc với vé máy bay khứ hồi và phòng nghỉ đẳng cấp.',
        'price' => 4500000,
        'original_price' => 6500000,
        'duration' => '3 Ngày 2 Đêm',
        'image' => 'https://images.unsplash.com/photo-1580828551405-b1a99908da62?q=80&w=2000&auto=format&fit=crop'
    ],
    [
        'name' => 'Combo Đà Lạt 4N3Đ: Vé máy bay + Khách sạn 4*',
        'description' => 'Tận hưởng không khí se lạnh Đà Lạt, lưu trú tại trung tâm và vé tham quan các điểm nổi tiếng.',
        'price' => 3200000,
        'original_price' => 4000000,
        'duration' => '4 Ngày 3 Đêm',
        'image' => 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?q=80&w=2000&auto=format&fit=crop'
    ],
    [
        'name' => 'Combo Siêu Tiết Kiệm Nha Trang 3N2Đ',
        'description' => 'Nghỉ dưỡng 3 ngày 2 đêm tại resort 5 sao bờ biển Nha Trang, bao gồm ăn sáng buffet.',
        'price' => 2900000,
        'original_price' => 5800000,
        'duration' => '3 Ngày 2 Đêm',
        'image' => 'https://images.unsplash.com/photo-1601006527582-777e07661b36?q=80&w=2000&auto=format&fit=crop'
    ],
    [
        'name' => 'Combo Sapa 2N1Đ: Xe Cabin Đôi + Khách sạn TT',
        'description' => 'Trọn gói di chuyển xe giường nằm cabin đôi cao cấp Hà Nội - Sapa và phòng nghỉ sát nhà thờ đá.',
        'price' => 1250000,
        'original_price' => 1500000,
        'duration' => '2 Ngày 1 Đêm',
        'image' => 'https://images.unsplash.com/photo-1576408226498-84ce3f6c8d7b?q=80&w=2000&auto=format&fit=crop'
    ],
    [
        'name' => 'Combo Bangkok - Pattaya 5N4Đ (Flash Sale)',
        'description' => 'Khám phá Thái Lan trọn vẹn với vé khứ hồi, khách sạn 4* và vé show Simon Cabaret.',
        'price' => 6900000,
        'original_price' => 9900000,
        'duration' => '5 Ngày 4 Đêm',
        'image' => 'https://images.unsplash.com/photo-1508009603885-50cf7cbf0c80?q=80&w=2000&auto=format&fit=crop'
    ]
];

// Update existing combos to have original_price if null
mysqli_query($conn, "UPDATE combos SET original_price = price * 1.2 WHERE original_price IS NULL");

$success_count = 0;
foreach ($combos_data as $c) {
    $stmt = mysqli_prepare($conn, "INSERT INTO combos (name, description, price, original_price, duration, image) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssddss", $c['name'], $c['description'], $c['price'], $c['original_price'], $c['duration'], $c['image']);
    if (mysqli_stmt_execute($stmt)) {
        $success_count++;
    }
}
echo "Inserted $success_count new combos.\n";
