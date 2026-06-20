<?php
$page_title = "Quản lý Đặt Combo";
require '../includes/db.php';

// Cập nhật trạng thái
if (isset($_POST['update_status']) && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE combo_bookings SET status = '$new_status' WHERE id = $booking_id";
    if (mysqli_query($conn, $update_sql)) {
        $success = "Cập nhật trạng thái thành công!";
    } else {
        $error = "Cập nhật thất bại: " . mysqli_error($conn);
    }
}

// Xử lý xóa đơn đặt combo
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM combo_bookings WHERE id = $delete_id");
    $success = "Xóa đơn đặt combo thành công!";
}

// Lấy danh sách đặt combo
$sql = "SELECT b.*, u.full_name, c.name AS combo_name 
        FROM combo_bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN combos c ON b.combo_id = c.id 
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>Mã Đặt</th>
                    <th>Khách hàng</th>
                    <th>Combo</th>
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
                            <td><?= htmlspecialchars($booking['combo_name']) ?></td>
                            <td><?= date('d/m/Y', strtotime($booking['travel_date'])) ?></td>
                            <td><?= $booking['total_people'] ?></td>
                            <td>
                                <?php
                                $status = $booking['status'];
                                if ($status == 'confirmed') {
                                    echo '<span class="badge bg-success">Đã duyệt</span>';
                                } elseif ($status == 'cancelled') {
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="combo-booking-detail.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-info"><i
                                        class="bi bi-eye"></i> Xem / Duyệt</a>
                            </td>
                            <td>
                                <?php if ($status == 'cancelled'): ?>
                                    <a href="combo-bookings.php?delete_id=<?= $booking['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hẳn đơn đã hủy này?');"><i class="bi bi-trash"></i> Xóa</a>
                                <?php else: ?>
                                    <span class="text-muted small">Chưa thể xóa</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có lượt đặt combo nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
