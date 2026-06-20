<?php
require 'includes/db.php';
$res = mysqli_query($conn, "DESCRIBE guides");
if($res) {
    while($row = mysqli_fetch_assoc($res)) {
        print_r($row);
    }
} else {
    echo mysqli_error($conn);
}
?>
