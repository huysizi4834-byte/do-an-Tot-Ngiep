<?php
$page_title = "Quản lý Đánh giá";
require '../includes/db.php';

// Xử lý Xóa đánh giá
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $delete_id");
    $success = "Đã xóa đánh giá thành công!";
}

// Xử lý bộ lọc
$where = [];
$rating_filter = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;
$tour_filter = isset($_GET['tour_id']) ? (int)$_GET['tour_id'] : 0;
$keyword_filter = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, trim($_GET['keyword'])) : '';

if ($rating_filter > 0) {
    $where[] = "r.rating = $rating_filter";
}
if ($tour_filter > 0) {
    $where[] = "r.tour_id = $tour_filter";
}
if ($keyword_filter !== '') {
    $where[] = "(u.full_name LIKE '%$keyword_filter%' OR r.comment LIKE '%$keyword_filter%')";
}

$where_clause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// Lấy danh sách đánh giá
$sql = "SELECT r.*, u.full_name, t.title 
        FROM reviews r 
        JOIN users u ON r.user_id = u.id 
        JOIN tours t ON r.tour_id = t.id 
        $where_clause
        ORDER BY r.created_at DESC";

// Lấy danh sách Tour để đưa vào bộ lọc
$tours_result = mysqli_query($conn, "SELECT id, title FROM tours ORDER BY title ASC");
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Filter Form -->
        <form method="GET" action="reviews.php" class="mb-4 bg-light p-3 rounded">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Từ khóa</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Tên KH hoặc nội dung..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tour</label>
                    <select name="tour_id" class="form-select">
                        <option value="0">-- Tất cả Tour --</option>
                        <?php while ($t = mysqli_fetch_assoc($tours_result)): ?>
                            <option value="<?= $t['id'] ?>" <?= ($tour_filter == $t['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['title']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Số sao</label>
                    <select name="rating" class="form-select">
                        <option value="0">-- Tất cả --</option>
                        <option value="5" <?= ($rating_filter == 5) ? 'selected' : '' ?>>5 Sao</option>
                        <option value="4" <?= ($rating_filter == 4) ? 'selected' : '' ?>>4 Sao</option>
                        <option value="3" <?= ($rating_filter == 3) ? 'selected' : '' ?>>3 Sao</option>
                        <option value="2" <?= ($rating_filter == 2) ? 'selected' : '' ?>>2 Sao</option>
                        <option value="1" <?= ($rating_filter == 1) ? 'selected' : '' ?>>1 Sao</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-funnel"></i> Lọc</button>
                    <?php if (count($_GET) > 0): ?>
                        <a href="reviews.php" class="btn btn-outline-secondary ms-2" title="Xóa bộ lọc"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

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