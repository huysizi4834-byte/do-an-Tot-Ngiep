<?php
require 'includes/db.php';
$r = mysqli_query($conn, 'DESCRIBE flights');
while($row = mysqli_fetch_assoc($r)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
