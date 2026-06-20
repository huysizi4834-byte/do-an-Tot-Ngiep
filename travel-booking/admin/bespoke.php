<?php
$page_title = "Yêu cầu Bespoke";
require '../includes/db.php';

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM bespoke_requests WHERE id = $delete_id");
    header("Location: bespoke.php");
    exit();
}

$sql = "SELECT * FROM bespoke_requests ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Danh sách Yêu cầu Bespoke</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Khách hàng</th>
                        <th>Điểm đến</th>
                        <th>Khởi hành</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($row['phone']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['destination']) ?></td>
                                <td>
                                    <?= date('d/m/Y', strtotime($row['start_date'])) ?>
                                    <br><small class="text-muted"><?= $row['duration'] ?> ngày, <?= $row['pax'] ?> người</small>
                                </td>
                                <td>
                                    <?php
                                    switch ($row['status']) {
                                        case 'new':
                                            echo '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">Yêu cầu mới</span>';
                                            break;
                                        case 'processing':
                                            echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">Đang xử lý</span>';
                                            break;
                                        case 'completed':
                                            echo '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">Đã hoàn thành</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="view-bespoke.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white me-1" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                                    <a href="bespoke.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này?');" title="Xóa"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có yêu cầu Bespoke nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
