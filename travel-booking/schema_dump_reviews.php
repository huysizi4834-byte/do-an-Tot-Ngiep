<?php
require 'includes/db.php';
$res = mysqli_query($conn, "DESCRIBE reviews");
if ($res) {
    while ($row = mysqli_fetch_assoc($res))
        print_r($row);
} else {
    echo "No reviews table";
}
