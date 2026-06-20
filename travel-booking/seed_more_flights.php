<?php
require 'includes/db.php';

$flights = [
    // Nội địa
    [
        'airline' => 'Vietnam Airlines',
        'flight_number' => 'VN234',
        'departure_city' => 'Hà Nội',
        'arrival_city' => 'Nha Trang',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+4 days 09:30:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+4 days 11:20:00')),
        'price' => 2100000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/309/217/png-transparent-vietnam-airlines-logo-brand-font-vietnam-airlines-text-logo-vietnam.png'
    ],
    [
        'airline' => 'Vietjet Air',
        'flight_number' => 'VJ789',
        'departure_city' => 'Hải Phòng',
        'arrival_city' => 'TP. Hồ Chí Minh',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+2 days 13:00:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+2 days 15:10:00')),
        'price' => 1500000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/126/626/png-transparent-vietjet-air-logo-airline-vietnam-airlines-ticket-vietjet-air-text-logo-flight.png'
    ],
    [
        'airline' => 'Bamboo Airways',
        'flight_number' => 'QH111',
        'departure_city' => 'Đà Nẵng',
        'arrival_city' => 'Phú Quốc',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+6 days 10:45:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+6 days 12:30:00')),
        'price' => 2800000,
        'thumbnail' => 'https://i.pinimg.com/736x/cb/19/ff/cb19ffbb06e88ffbfd56c2fde9bfb1b7.jpg'
    ],
    [
        'airline' => 'Vietnam Airlines',
        'flight_number' => 'VN555',
        'departure_city' => 'Hà Nội',
        'arrival_city' => 'Đà Lạt',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+3 days 07:15:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+3 days 09:05:00')),
        'price' => 2400000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/309/217/png-transparent-vietnam-airlines-logo-brand-font-vietnam-airlines-text-logo-vietnam.png'
    ],
    [
        'airline' => 'Vietravel Airlines',
        'flight_number' => 'VU101',
        'departure_city' => 'TP. Hồ Chí Minh',
        'arrival_city' => 'Quy Nhơn',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+5 days 14:00:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+5 days 15:15:00')),
        'price' => 1100000,
        'thumbnail' => 'https://seeklogo.com/images/V/vietravel-airlines-logo-7B27C21DFB-seeklogo.com.png'
    ],

    // Quốc tế
    [
        'airline' => 'Singapore Airlines',
        'flight_number' => 'SQ175',
        'departure_city' => 'Hà Nội',
        'arrival_city' => 'Singapore',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+7 days 12:35:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+7 days 17:15:00')),
        'price' => 5500000,
        'thumbnail' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/6b/Singapore_Airlines_Logo_2.svg/1200px-Singapore_Airlines_Logo_2.svg.png'
    ],
    [
        'airline' => 'All Nippon Airways (ANA)',
        'flight_number' => 'NH832',
        'departure_city' => 'TP. Hồ Chí Minh',
        'arrival_city' => 'Tokyo (Narita)',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+10 days 23:05:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+11 days 06:45:00')),
        'price' => 12500000,
        'thumbnail' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/All_Nippon_Airways_Logo.svg/1200px-All_Nippon_Airways_Logo.svg.png'
    ],
    [
        'airline' => 'Emirates',
        'flight_number' => 'EK393',
        'departure_city' => 'TP. Hồ Chí Minh',
        'arrival_city' => 'Dubai',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+15 days 23:55:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+16 days 04:00:00')),
        'price' => 18000000,
        'thumbnail' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Emirates_logo.svg/1200px-Emirates_logo.svg.png'
    ],
    [
        'airline' => 'Air France',
        'flight_number' => 'AF253',
        'departure_city' => 'TP. Hồ Chí Minh',
        'arrival_city' => 'Paris (CDG)',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+20 days 08:35:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+20 days 16:30:00')),
        'price' => 25000000,
        'thumbnail' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Air_France_Logo.svg/1200px-Air_France_Logo.svg.png'
    ],
    [
        'airline' => 'Korean Air',
        'flight_number' => 'KE462',
        'departure_city' => 'Đà Nẵng',
        'arrival_city' => 'Seoul (Incheon)',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+8 days 22:50:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+9 days 05:20:00')),
        'price' => 8500000,
        'thumbnail' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Korean_Air_logo.svg/1200px-Korean_Air_logo.svg.png'
    ]
];

$success_count = 0;
foreach ($flights as $f) {
    $airline = mysqli_real_escape_string($conn, $f['airline']);
    $flight_number = mysqli_real_escape_string($conn, $f['flight_number']);
    $departure_city = mysqli_real_escape_string($conn, $f['departure_city']);
    $arrival_city = mysqli_real_escape_string($conn, $f['arrival_city']);
    $departure_time = mysqli_real_escape_string($conn, $f['departure_time']);
    $arrival_time = mysqli_real_escape_string($conn, $f['arrival_time']);
    $price = (int) $f['price'];
    $thumbnail = mysqli_real_escape_string($conn, $f['thumbnail']);

    $sql = "INSERT INTO flights (airline, flight_number, departure_city, arrival_city, departure_time, arrival_time, price, thumbnail) 
            VALUES ('$airline', '$flight_number', '$departure_city', '$arrival_city', '$departure_time', '$arrival_time', $price, '$thumbnail')";
            
    if (mysqli_query($conn, $sql)) {
        $success_count++;
    } else {
        echo "Lỗi khi chèn chuyến bay {$flight_number}: " . mysqli_error($conn) . "<br>";
    }
}

echo "Thành công chèn thêm $success_count chuyến bay trong và ngoài nước!\n";
?>
