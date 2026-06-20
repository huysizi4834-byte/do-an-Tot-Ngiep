<?php
$page_title = "Quản lý Tours";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý xóa tour
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    // Check if there are bookings for this tour before deleting
    $check_bookings = mysqli_query($conn, "SELECT id FROM bookings WHERE tour_id = $delete_id");
    if (mysqli_num_rows($check_bookings) > 0) {
        $error = "Không thể xóa tour này vì đã có người đặt!";
    } else {
        // Xóa các đánh giá (reviews) liên quan trước để tránh lỗi khóa ngoại
        mysqli_query($conn, "DELETE FROM reviews WHERE tour_id = $delete_id");
        
        // Sau đó mới xóa tour
        mysqli_query($conn, "DELETE FROM tours WHERE id = $delete_id");
        $success = "Xóa tour thành công!";
    }
}

// Lấy danh sách tour
$sql = "SELECT t.*, d.name AS destination_name 
        FROM tours t 
        LEFT JOIN destinations d ON t.destination_id = d.id 
        ORDER BY t.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="mb-3 d-flex justify-content-end">
    <a href="add-tour.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Thêm Tour Mới</a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên Tour</th>
                    <th>Điểm đến</th>
                    <th>Giá</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($tour = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $tour['id'] ?></td>
                            <td>
                                <?php if (!empty($tour['thumbnail'])): ?>
                                    <img src="<?= htmlspecialchars($tour['thumbnail']) ?>" alt="Thumbnail" width="60"
                                        class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($tour['title']) ?></td>
                            <td><?= htmlspecialchars($tour['destination_name'] ?? 'Không rõ') ?></td>
                            <td><?= number_format($tour['price']) ?> ₫</td>
                            <td><?= $tour['duration_days'] ?> Ngày <?= $tour['duration_nights'] ?> Đêm</td>
                            <td>
                                <?php if ($tour['status'] == 'active'): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm ngưng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="tour-images.php?tour_id=<?= $tour['id'] ?>" class="btn btn-sm btn-info" title="Ảnh"><i class="bi bi-images"></i></a>
                                <a href="edit-tour.php?id=<?= $tour['id'] ?>" class="btn btn-sm btn-warning" title="Sửa"><i
                                        class="bi bi-pencil"></i></a>
                                <a href="tours.php?delete_id=<?= $tour['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');" title="Xóa"><i
                                        class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có tour nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>