<?php
$page_title = "Quản lý Cẩm nang du lịch";
require '../includes/db.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Xóa ảnh cũ nếu có
    $res = mysqli_query($conn, "SELECT image FROM guides WHERE id = $delete_id");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['image']) && file_exists("../assets/images/guides/" . $row['image'])) {
            unlink("../assets/images/guides/" . $row['image']);
        }
    }
    
    mysqli_query($conn, "DELETE FROM guides WHERE id = $delete_id");
    header("Location: guides.php");
    exit();
}

$sql = "SELECT * FROM guides ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Danh sách Cẩm nang du lịch</h2>
    <a href="add-guide.php" class="btn btn-primary fw-bold"><i class="bi bi-plus-lg"></i> Thêm bài viết mới</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="80">Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <?php $imgSrc = (strpos($row['image'], 'http') === 0) ? htmlspecialchars($row['image']) : "../assets/images/guides/" . htmlspecialchars($row['image']); ?>
                                        <img src="<?= $imgSrc ?>" alt="Cover" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <div class="bg-secondary bg-opacity-25 rounded" style="width: 60px; height: 40px;"></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($row['title']) ?></div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td class="text-end text-nowrap">
                                    <a href="guide-images.php?guide_id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white" title="Quản lý ảnh phụ"><i class="bi bi-images"></i></a>
                                    <a href="edit-guide.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Sửa</a>
                                    <a href="guides.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Chưa có bài viết nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
