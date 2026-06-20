<?php
$page_title = "Quản lý Đặt Tour";
require '../includes/db.php';

// Xử lý xóa đơn đặt
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM bookings WHERE id = $delete_id");
    $success = "Xóa đơn đặt tour thành công!";
}

// Lấy danh sách đặt tour
$sql = "SELECT b.*, u.full_name, t.title 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN tours t ON b.tour_id = t.id 
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Mã ĐĐ</th>
                    <th>Khách hàng</th>
                    <th>Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Số người</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($booking['id']) ?></td>
                            <td><?= htmlspecialchars($booking['full_name']) ?></td>
                            <td><?= htmlspecialchars($booking['title']) ?></td>
                            <td><?= date('d/m/Y', strtotime($booking['departure_date'])) ?></td>
                            <td><?= $booking['total_people'] ?></td>
                            <td>
                                <?php
                                $status = $booking['booking_status'];
                                if ($status == 'confirmed' || $status == 'approved') {
                                    echo '<span class="badge bg-success">Đã duyệt</span>';
                                } elseif ($status == 'completed') {
                                    echo '<span class="badge bg-primary">Hoàn thành</span>';
                                } elseif ($status == 'cancelled') {
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="booking-detail.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-info"><i
                                        class="bi bi-eye"></i> Xem / Duyệt</a>
                            </td>
                            <td>
                                <?php if ($status == 'cancelled'): ?>
                                    <a href="bookings.php?delete_id=<?= $booking['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hẳn đơn đã hủy này?');"><i class="bi bi-trash"></i> Xóa</a>
                                <?php else: ?>
                                    <span class="text-muted small">Chưa thể xóa</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có lượt đặt tour nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>