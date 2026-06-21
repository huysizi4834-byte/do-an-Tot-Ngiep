<?php
$page_title = "Quản lý Khuyến mại";
require '../includes/db.php';
include 'includes/admin-header.php';

// Xử lý tìm kiếm
$search = $_GET['search'] ?? '';
$where_query = "";
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $where_query = " WHERE code LIKE '%$search_safe%' ";
}

$sql = "SELECT * FROM promotions $where_query ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center fw-bold">
        <span>Danh sách Khuyến mại</span>
        <a href="add-promotion.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Thêm mã mới</a>
    </div>
    <div class="card-body">
        <form method="GET" action="" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Tìm kiếm</button>
            </div>
            <?php if (!empty($search)): ?>
                <div class="col-md-2">
                    <a href="promotions.php" class="btn btn-outline-secondary w-100">Xóa lọc</a>
                </div>
            <?php endif; ?>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Giảm giá</th>
                        <th>Thời gian</th>
                        <th>Số lượt</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><span class="badge bg-primary fs-6"><?= htmlspecialchars($row['code']) ?></span></td>
                                <td>
                                    <?php if ($row['discount_type'] === 'percent'): ?>
                                        <?= floatval($row['discount_value']) ?>%
                                    <?php else: ?>
                                        <?= number_format($row['discount_value']) ?> ₫
                                    <?php endif; ?>
                                </td>
                                <td>
                                    Từ: <?= date('d/m/Y', strtotime($row['start_date'])) ?><br>
                                    Đến: <?= date('d/m/Y', strtotime($row['end_date'])) ?>
                                </td>
                                <td>
                                    <?= $row['used_count'] ?> / <?= $row['usage_limit'] ? $row['usage_limit'] : '∞' ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'active'): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tạm dừng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit-promotion.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                    <a href="delete-promotion.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mã này?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Chưa có mã khuyến mại nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
