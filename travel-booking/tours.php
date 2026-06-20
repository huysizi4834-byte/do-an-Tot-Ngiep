<?php
require 'includes/db.php';

// Xử lý tìm kiếm
$search = $_GET['search'] ?? '';
$destination = $_GET['destination'] ?? '';

$where_clauses = [];
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $where_clauses[] = "(t.title LIKE '%$search_safe%' OR d.name LIKE '%$search_safe%')";
}

if (!empty($destination)) {
    $dest_safe = mysqli_real_escape_string($conn, $destination);
    $where_clauses[] = "d.name = '$dest_safe'";
}

$where_query = "";
if (count($where_clauses) > 0) {
    $where_query = " WHERE " . implode(' AND ', $where_clauses);
}

// Lấy danh sách tour
$sql = "
SELECT
    t.*,
    d.name AS destination_name
FROM tours t
LEFT JOIN destinations d
ON t.destination_id = d.id
$where_query
ORDER BY t.created_at DESC
";

$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<div class="container py-5">
    <h2 class="mb-4 text-center">
        <?php
        if (!empty($search)) {
            echo "Kết quả tìm kiếm cho: '" . htmlspecialchars($search) . "'";
        } elseif (!empty($destination)) {
            echo "Tour Du Lịch " . htmlspecialchars($destination);
        } else {
            echo "Danh Sách Các Tour Du Lịch";
        }
        ?>
    </h2>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($tour = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="tour-card h-100">
                        <!-- Sử dụng object-fit để hình ảnh hiển thị đẹp hơn, không bị méo -->
                        <img src="<?= htmlspecialchars($tour['thumbnail']) ?>" alt="<?= htmlspecialchars($tour['title']) ?>"
                            style="height: 250px; width: 100%; object-fit: cover;">

                        <div class="tour-info d-flex flex-column" style="height: 100%;">
                            <h5 class="mb-2">
                                <?= htmlspecialchars($tour['title']) ?>
                            </h5>

                            <p class="text-muted mb-3">
                                <i class="fa-solid fa-location-dot"></i>
                                <?= htmlspecialchars($tour['destination_name'] ?? 'Chưa xác định') ?>
                            </p>

                            <div class="tour-price mt-auto mb-3 text-danger fw-bold fs-5">
                                <?= formatPrice($tour['price']) ?>
                            </div>

                            <a href="tour-detail.php?id=<?= $tour['id'] ?>" class="btn btn-primary w-100 mt-auto">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Hiện chưa có tour nào được đăng tải.</h4>
                <a href="index.php" class="btn btn-primary mt-3">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>