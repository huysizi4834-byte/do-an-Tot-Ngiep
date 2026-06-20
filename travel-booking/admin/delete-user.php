<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Truy cập bị từ chối.");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Prevent self-deletion
    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Bạn không thể xóa chính mình!'); window.location.href='users.php';</script>";
        exit;
    }

    // Optional: check bookings first or delete cascading. Let's just prevent deletion if they have bookings.
    // Instead of querying all booking tables, let's just delete them. If there's a foreign key constraint, it will fail gracefully.
    // However, it's safer to check at least `bookings`
    $check_sql = "SELECT id FROM bookings WHERE user_id = $id LIMIT 1";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Không thể xóa người dùng này vì họ đã có đơn đặt vé. Hãy khóa tài khoản (Ban) thay vì xóa.'); window.location.href='users.php';</script>";
    } else {
        $sql = "DELETE FROM users WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Xóa người dùng thành công!'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Không thể xóa người dùng: " . mysqli_error($conn) . "'); window.location.href='users.php';</script>";
        }
    }
} else {
    header("Location: users.php");
}
exit;
