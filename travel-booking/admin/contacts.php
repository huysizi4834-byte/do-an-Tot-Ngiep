<?php
$page_title = "Quản lý Liên hệ";
require '../includes/db.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM contacts WHERE id = $delete_id");
    header("Location: contacts.php");
    exit();
}

$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Danh sách Liên hệ / Hỗ trợ</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Chủ đề</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>#<?= $row['id'] ?></td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'new'): ?>
                                        <span class="badge bg-danger rounded-pill px-3">Chưa đọc</span>
                                    <?php elseif ($row['status'] == 'read'): ?>
                                        <span class="badge bg-primary rounded-pill px-3">Đã đọc</span>
                                    <?php else: ?>
                                        <span class="badge bg-success rounded-pill px-3">Đã xử lý</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="view-contact.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white me-1"><i class="bi bi-eye"></i> Xem</a>
                                    <a href="contacts.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có tin nhắn liên hệ nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
