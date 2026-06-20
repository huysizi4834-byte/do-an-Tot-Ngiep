<?php
require 'includes/db.php';

$password_hash = password_hash('admin123', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (full_name, email, password_hash, role, status) 
        VALUES ('Admin System', 'admin@thegioi.vn', '$password_hash', 'admin', 'active') 
        ON DUPLICATE KEY UPDATE role = 'admin'";

if (mysqli_query($conn, $sql)) {
    echo "Admin created successfully! Email: admin@thegioi.vn, Pass: admin123";
} else {
    echo "Error: " . mysqli_error($conn);
}
