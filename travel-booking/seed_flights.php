<?php
require 'includes/db.php';

$flights = [
    [
        'airline' => 'Vietnam Airlines',
        'flight_number' => 'VN123',
        'departure_city' => 'Hà Nội',
        'arrival_city' => 'TP. Hồ Chí Minh',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+2 days 08:00:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+2 days 10:15:00')),
        'price' => 2500000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/309/217/png-transparent-vietnam-airlines-logo-brand-font-vietnam-airlines-text-logo-vietnam.png'
    ],
    [
        'airline' => 'Vietjet Air',
        'flight_number' => 'VJ456',
        'departure_city' => 'TP. Hồ Chí Minh',
        'arrival_city' => 'Đà Nẵng',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+3 days 14:30:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+3 days 15:50:00')),
        'price' => 1200000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/126/626/png-transparent-vietjet-air-logo-airline-vietnam-airlines-ticket-vietjet-air-text-logo-flight.png'
    ],
    [
        'airline' => 'Bamboo Airways',
        'flight_number' => 'QH789',
        'departure_city' => 'Hà Nội',
        'arrival_city' => 'Phú Quốc',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+5 days 09:00:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+5 days 11:10:00')),
        'price' => 3100000,
        'thumbnail' => 'https://i.pinimg.com/736x/cb/19/ff/cb19ffbb06e88ffbfd56c2fde9bfb1b7.jpg'
    ],
    [
        'airline' => 'Vietnam Airlines',
        'flight_number' => 'VN999',
        'departure_city' => 'Đà Nẵng',
        'arrival_city' => 'Hà Nội',
        'departure_time' => date('Y-m-d H:i:s', strtotime('+1 days 18:00:00')),
        'arrival_time' => date('Y-m-d H:i:s', strtotime('+1 days 19:20:00')),
        'price' => 1800000,
        'thumbnail' => 'https://w7.pngwing.com/pngs/309/217/png-transparent-vietnam-airlines-logo-brand-font-vietnam-airlines-text-logo-vietnam.png'
    ]
];

$success_count = 0;
foreach ($flights as $f) {
    $sql = "INSERT INTO flights (airline, flight_number, departure_city, arrival_city, departure_time, arrival_time, price, thumbnail) 
            VALUES ('{$f['airline']}', '{$f['flight_number']}', '{$f['departure_city']}', '{$f['arrival_city']}', '{$f['departure_time']}', '{$f['arrival_time']}', {$f['price']}, '{$f['thumbnail']}')";
    if (mysqli_query($conn, $sql)) {
        $success_count++;
    }
}

echo "Inserted $success_count flights successfully.\n";
