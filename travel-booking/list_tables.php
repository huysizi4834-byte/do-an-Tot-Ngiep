<?php
require 'includes/db.php';
$res = mysqli_query($conn, 'DESCRIBE tour_images');
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
?>
