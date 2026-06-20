<?php
require 'includes/db.php';
$sql = "ALTER TABLE tours ADD COLUMN is_featured TINYINT(1) DEFAULT 0";
if (mysqli_query($conn, $sql)) {
    echo "Column added successfully.";
} else {
    echo "Error adding column: " . mysqli_error($conn);
}
?>
