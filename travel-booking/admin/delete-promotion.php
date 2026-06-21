<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Xóa mã khuyến mại
    $sql = "DELETE FROM promotions WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: promotions.php");
exit;
