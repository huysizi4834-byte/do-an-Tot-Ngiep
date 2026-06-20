<?php
require 'includes/db.php';
mysqli_query($conn, "UPDATE tours SET is_featured = 1");
echo "Updated tours";
?>
