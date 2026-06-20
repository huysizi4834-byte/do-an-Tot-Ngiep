<?php
$page_title = "Quản lý Đơn Đặt Vé Máy Bay";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý xóa đơn đặt vé
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM flight_bookings WHERE id = $delete_id");
    $success = "Xóa đơn đặt vé thành công!";
}

// Lấy danh sách đơn đặt vé
$sql = "
SELECT fb.*, u.full_name, u.email, f.airline, f.flight_number 
FROM flight_bookings fb 
JOIN users u ON fb.user_id = u.id 
JOIN flights f ON fb.flight_id = f.id 
ORDER BY fb.created_at DESC
";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Đơn Đặt Vé Máy Bay</h1>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách hàng</th>
                        <th>Chuyến bay</th>
                        <th>Số lượng vé</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fb = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($fb['booking_code']) ?></td>
                            <td>
                                <div><?= htmlspecialchars($fb['full_name']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($fb['email']) ?></small>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($fb['airline']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($fb['flight_number']) ?></small>
                            </td>
                            <td><?= $fb['total_passengers'] ?></td>
                            <td class="text-danger fw-bold"><?= number_format($fb['total_amount']) ?> ₫</td>
                            <td>
                                <?php
                                $status = $fb['booking_status'];
                                if ($status == 'confirmed')
                                    echo '<span class="badge bg-success">Đã xuất vé</span>';
                                elseif ($status == 'cancelled')
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                else
                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                ?>
                            </td>
                            <td>
                                <a href="flight-booking-detail.php?id=<?= $fb['id'] ?>" class="btn btn-sm btn-primary">
                                    Chi tiết
                                </a>
                            </td>
                            <td>
                                <?php if ($status == 'cancelled'): ?>
                                    <a href="flight-bookings.php?delete_id=<?= $fb['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hẳn đơn đã hủy này?');"><i class="bi bi-trash"></i> Xóa</a>
                                <?php else: ?>
                                    <span class="text-muted small">Chưa thể xóa</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>