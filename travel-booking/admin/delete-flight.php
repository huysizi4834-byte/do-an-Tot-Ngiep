<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Truy cập bị từ chối.");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Check if flight is used in any bookings before deleting
    $check_sql = "SELECT id FROM flight_bookings WHERE flight_id = $id LIMIT 1";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Không thể xóa chuyến bay này vì đã có người đặt vé. Vui lòng hủy các đơn đặt vé trước.'); window.location.href='flights.php';</script>";
    } else {
        $sql = "DELETE FROM flights WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Xóa chuyến bay thành công!'); window.location.href='flights.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($conn) . "'); window.location.href='flights.php';</script>";
        }
    }
} else {
    header("Location: flights.php");
}
exit;
