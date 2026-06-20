<?php
require 'includes/db.php';

$destinations = [
    ['name' => 'Trong nước', 'slug' => 'trong-nuoc', 'description' => 'Các tour du lịch trong nước Việt Nam'],
    ['name' => 'Ngoài nước', 'slug' => 'ngoai-nuoc', 'description' => 'Các tour du lịch quốc tế']
];

foreach ($destinations as $dest) {
    $name = mysqli_real_escape_string($conn, $dest['name']);
    $slug = mysqli_real_escape_string($conn, $dest['slug']);
    $desc = mysqli_real_escape_string($conn, $dest['description']);

    $check = mysqli_query($conn, "SELECT id FROM destinations WHERE name = '$name'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO destinations (name, slug, description, created_at) VALUES ('$name', '$slug', '$desc', NOW())");
        echo "Inserted: $name\n";
    } else {
        echo "Already exists: $name\n";
    }
}
