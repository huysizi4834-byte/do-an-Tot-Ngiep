<?php
require 'includes/db.php';
$tables = ['tours', 'destinations'];
foreach ($tables as $table) {
    echo "TABLE: $table\n";
    $res = mysqli_query($conn, "DESCRIBE $table");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo "  {$row['Field']} - {$row['Type']}\n";
        }
    } else {
        echo "  Table not found or error: " . mysqli_error($conn) . "\n";
    }
}
