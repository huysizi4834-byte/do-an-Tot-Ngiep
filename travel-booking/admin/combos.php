<?php
$page_title = "Quản lý Combos";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý xóa combo
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    // Check if there are bookings for this combo before deleting
    $check_bookings = mysqli_query($conn, "SELECT id FROM combo_bookings WHERE combo_id = $delete_id");
    if (mysqli_num_rows($check_bookings) > 0) {
        $error = "Không thể xóa combo này vì đã có người đặt!";
    } else {
        mysqli_query($conn, "DELETE FROM combos WHERE id = $delete_id");
        $success = "Xóa combo thành công!";
    }
}

// Lấy danh sách combo
$sql = "SELECT * FROM combos ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="mb-3 d-flex justify-content-end">
    <a href="add-combo.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Thêm Combo Mới</a>
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
                    <th>Tên Combo</th>
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($combo = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $combo['id'] ?></td>
                            <td>
                                <?php if (!empty($combo['image'])): ?>
                                    <img src="<?= htmlspecialchars($combo['image']) ?>" alt="Thumbnail" width="60"
                                        class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($combo['name']) ?></td>
                            <td><?= !empty($combo['original_price']) ? number_format($combo['original_price']) . ' ₫' : '<span class="text-muted">-</span>' ?></td>
                            <td><?= number_format($combo['price']) ?> ₫</td>
                            <td><?= htmlspecialchars($combo['duration']) ?></td>
                            <td>
                                <?php if ($combo['status'] == 'active'): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm ngưng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit-combo.php?id=<?= $combo['id'] ?>" class="btn btn-sm btn-warning" title="Sửa"><i
                                        class="bi bi-pencil"></i></a>
                                <a href="combos.php?delete_id=<?= $combo['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa combo này không?');" title="Xóa"><i
                                        class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có combo nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
