<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    "travel_booking_db"
);

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");