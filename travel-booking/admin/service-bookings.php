<?php
$page_title = "Quản lý Đặt Dịch Vụ";
require '../includes/db.php';

// Cập nhật trạng thái nếu dùng form inline (có thể dùng detail page sau)
if (isset($_POST['update_status']) && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE service_bookings SET status = '$new_status' WHERE id = $booking_id";
    if (mysqli_query($conn, $update_sql)) {
        $success = "Cập nhật trạng thái thành công!";
    } else {
        $error = "Cập nhật thất bại: " . mysqli_error($conn);
    }
}

// Xử lý xóa đơn đặt dịch vụ
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM service_bookings WHERE id = $delete_id");
    $success = "Xóa đơn đặt dịch vụ thành công!";
}

// Lấy danh sách đặt dịch vụ
$sql = "SELECT b.*, u.full_name, u.phone, s.name AS service_name 
        FROM service_bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN additional_services s ON b.service_id = s.id 
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Đơn Đặt Dịch Vụ Cộng Thêm</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách hàng</th>
                        <th>Dịch vụ</th>
                        <th>Ngày SD</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="fw-bold text-info">#<?= htmlspecialchars($booking['id']) ?></td>
                                <td>
                                    <div><?= htmlspecialchars($booking['full_name']) ?></div>
                                    <small class="text-muted"><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($booking['phone']) ?></small>
                                </td>
                                <td><div class="fw-bold"><?= htmlspecialchars($booking['service_name']) ?></div></td>
                                <td><?= date('d/m/Y', strtotime($booking['service_date'])) ?></td>
                                <td><?= $booking['quantity'] ?></td>
                                <td class="text-danger fw-bold"><?= number_format($booking['total_price']) ?> đ</td>
                                <td>
                                    <?php
                                    $status = $booking['status'];
                                    if ($status == 'confirmed') echo '<span class="badge bg-success">Đã xác nhận</span>';
                                    elseif ($status == 'completed') echo '<span class="badge bg-primary">Hoàn thành</span>';
                                    elseif ($status == 'cancelled') echo '<span class="badge bg-danger">Đã hủy</span>';
                                    else echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                    ?>
                                </td>
                                <td>
                                    <a href="service-booking-detail.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Xem / Duyệt
                                    </a>
                                </td>
                                <td>
                                    <?php if ($status == 'cancelled'): ?>
                                        <a href="service-bookings.php?delete_id=<?= $booking['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hẳn đơn đã hủy này?');"><i class="bi bi-trash"></i> Xóa</a>
                                    <?php else: ?>
                                        <span class="text-muted small">Chưa thể xóa</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">Chưa có lượt đặt dịch vụ nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
