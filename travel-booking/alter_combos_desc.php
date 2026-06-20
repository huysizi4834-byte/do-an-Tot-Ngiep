<?php
require 'includes/db.php';

$queries = [
    "ALTER TABLE combos ADD COLUMN highlights TEXT AFTER description",
    "ALTER TABLE combos ADD COLUMN price_details TEXT AFTER highlights",
    "ALTER TABLE combos ADD COLUMN hotel_system TEXT AFTER price_details",
    "ALTER TABLE combos ADD COLUMN policy TEXT AFTER hotel_system"
];

foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Thành công: $query\n";
    } else {
        echo "Lỗi: " . mysqli_error($conn) . "\n";
    }
}
?>
