<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "travel_booking_db"
);

mysqli_set_charset(
    $conn,
    "utf8mb4"
);