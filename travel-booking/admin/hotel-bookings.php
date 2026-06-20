<?php
$page_title = "Quản lý Đơn Đặt Phòng";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý xóa đơn đặt phòng
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM hotel_bookings WHERE id = $delete_id");
    $success = "Xóa đơn đặt phòng thành công!";
}

// Lấy danh sách đơn đặt phòng
$sql = "
SELECT hb.*, u.email, h.name as hotel_name, h.city 
FROM hotel_bookings hb 
JOIN users u ON hb.user_id = u.id 
JOIN hotels h ON hb.hotel_id = h.id 
ORDER BY hb.created_at DESC
";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Đơn Đặt Phòng Khách Sạn</h1>
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
                        <th>Khách sạn</th>
                        <th>Lịch lưu trú</th>
                        <th>Thông tin</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($hb = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold text-info">#<?= htmlspecialchars($hb['booking_code']) ?></td>
                            <td>
                                <div><i class="fa-solid fa-user text-muted me-1"></i>
                                    <?= htmlspecialchars($hb['guest_name']) ?></div>
                                <div><i class="fa-solid fa-phone text-muted me-1"></i>
                                    <?= htmlspecialchars($hb['guest_phone']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($hb['email']) ?></small>
                            </td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($hb['hotel_name']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($hb['city']) ?></small>
                            </td>
                            <td>
                                <div><span class="text-muted">In:</span>
                                    <?= date('d/m/Y', strtotime($hb['check_in_date'])) ?></div>
                                <div><span class="text-muted">Out:</span>
                                    <?= date('d/m/Y', strtotime($hb['check_out_date'])) ?></div>
                            </td>
                            <td>
                                <div><?= $hb['total_nights'] ?> đêm</div>
                                <div><?= $hb['total_guests'] ?> khách</div>
                            </td>
                            <td class="text-danger fw-bold"><?= number_format($hb['total_amount']) ?> ₫</td>
                            <td>
                                <?php
                                $status = $hb['booking_status'];
                                if ($status == 'confirmed')
                                    echo '<span class="badge bg-success">Đã xác nhận</span>';
                                elseif ($status == 'completed')
                                    echo '<span class="badge bg-primary">Hoàn thành</span>';
                                elseif ($status == 'cancelled')
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                else
                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                ?>
                            </td>
                            <td>
                                <a href="hotel-booking-detail.php?id=<?= $hb['id'] ?>" class="btn btn-sm btn-info"><i
                                        class="bi bi-eye"></i> Xem / Duyệt</a>
                            </td>
                            <td>
                                <?php if ($status == 'cancelled'): ?>
                                    <a href="hotel-bookings.php?delete_id=<?= $hb['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hẳn đơn đã hủy này?');"><i class="bi bi-trash"></i> Xóa</a>
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