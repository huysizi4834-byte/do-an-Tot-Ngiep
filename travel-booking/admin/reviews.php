<?php
$page_title = "Quản lý Đánh giá";
require '../includes/db.php';

// Xử lý Xóa đánh giá
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $delete_id");
    $success = "Đã xóa đánh giá thành công!";
}

// Lấy danh sách đánh giá
$sql = "SELECT r.*, u.full_name, t.title 
        FROM reviews r 
        JOIN users u ON r.user_id = u.id 
        JOIN tours t ON r.tour_id = t.id 
        ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Tour</th>
                    <th>Đánh giá (Sao)</th>
                    <th>Nội dung</th>
                    <th>Ngày đăng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($review = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $review['id'] ?></td>
                            <td><?= htmlspecialchars($review['full_name']) ?></td>
                            <td><?= htmlspecialchars($review['title']) ?></td>
                            <td>
                                <span class="text-warning">
                                    <?php
                                    $rating = (int) $review['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    }
                                    ?>
                                </span>
                            </td>
                            <td><?= nl2br(htmlspecialchars($review['comment'] ?? '')) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></td>
                            <td>
                                <a href="reviews.php?delete_id=<?= $review['id'] ?>" class="btn btn-sm btn-danger"
                                    title="Xóa đánh giá"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?');"><i
                                        class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có đánh giá nào từ khách hàng.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>