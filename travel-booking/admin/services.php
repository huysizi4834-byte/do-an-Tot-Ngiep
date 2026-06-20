<?php
$page_title = "Quản lý Dịch Vụ Cộng Thêm";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý xóa dịch vụ
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    
    // Check bookings first
    $check_sql = "SELECT COUNT(*) as count FROM service_bookings WHERE service_id = $delete_id";
    $check_res = mysqli_query($conn, $check_sql);
    $count = mysqli_fetch_assoc($check_res)['count'];
    
    if ($count > 0) {
        $error = "Không thể xóa dịch vụ này vì đã có đơn đặt. Vui lòng hủy các đơn đặt trước.";
    } else {
        $delete_sql = "DELETE FROM additional_services WHERE id = $delete_id";
        if (mysqli_query($conn, $delete_sql)) {
            $success = "Xóa dịch vụ thành công!";
        } else {
            $error = "Lỗi khi xóa: " . mysqli_error($conn);
        }
    }
}

// Lấy danh sách dịch vụ
$sql = "SELECT * FROM additional_services ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản lý Dịch Vụ Cộng Thêm</h1>
    <a href="add-service.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Thêm dịch vụ mới
    </a>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Hình ảnh</th>
                        <th width="25%">Tên dịch vụ</th>
                        <th width="15%">Giá (VNĐ)</th>
                        <th width="25%">Mô tả ngắn</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td>
                                    <?php if ($row['image_url']): ?>
                                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="img-thumbnail" style="max-height: 80px;">
                                    <?php else: ?>
                                        <span class="text-muted">Không có ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($row['name']) ?></td>
                                <td class="text-danger fw-bold"><?= number_format($row['price']) ?> đ</td>
                                <td>
                                    <?php 
                                    $desc = strip_tags($row['description']);
                                    echo mb_strlen($desc) > 50 ? mb_substr($desc, 0, 50) . '...' : $desc;
                                    ?>
                                </td>
                                <td>
                                    <a href="edit-service.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary mb-1">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <a href="services.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">Chưa có dịch vụ cộng thêm nào. <a href="add-service.php">Thêm ngay</a></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
