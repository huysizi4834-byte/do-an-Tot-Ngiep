<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Truy cập bị từ chối.");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Check if hotel is used in any bookings before deleting
    $check_sql = "SELECT id FROM hotel_bookings WHERE hotel_id = $id LIMIT 1";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Không thể xóa khách sạn này vì đã có người đặt phòng. Vui lòng hủy các đơn đặt phòng trước.'); window.location.href='hotels.php';</script>";
    } else {
        $sql = "DELETE FROM hotels WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Xóa khách sạn thành công!'); window.location.href='hotels.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($conn) . "'); window.location.href='hotels.php';</script>";
        }
    }
} else {
    header("Location: hotels.php");
}
exit;
