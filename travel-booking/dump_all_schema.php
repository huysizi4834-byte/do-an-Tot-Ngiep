<?php
require 'includes/db.php';
$result = mysqli_query($conn, "SHOW TABLES");
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        $table = $row[0];
        echo "TABLE: $table\n";
        $res = mysqli_query($conn, "DESCRIBE $table");
        if ($res) {
            while ($c = mysqli_fetch_assoc($res)) {
                echo "  {$c['Field']} - {$c['Type']} - {$c['Key']}\n";
            }
        }
        echo "\n";
    }
}
