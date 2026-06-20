<?php
require 'includes/db.php';

// Xử lý tìm kiếm
$search = $_GET['search'] ?? '';
$search_query = "";
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $search_query = " AND name LIKE '%$search_safe%' ";
}

// Lấy danh sách combo và sắp xếp theo % giảm giá
$sql = "SELECT *, 
        (original_price - price) / original_price * 100 AS discount_percent 
        FROM combos 
        WHERE status = 'active' $search_query 
        ORDER BY discount_percent DESC, created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<div class="container py-5">
    <h2 class="mb-4 text-center">
        <?= !empty($search) ? "Kết quả tìm kiếm combo cho: '" . htmlspecialchars($search) . "'" : "Danh Sách Combo Du Lịch" ?>
    </h2>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($combo = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="tour-card h-100 border rounded overflow-hidden shadow-sm position-relative">
                        <?php 
                        $discount = 0;
                        if (!empty($combo['original_price']) && $combo['original_price'] > $combo['price']) {
                            $discount = round(($combo['original_price'] - $combo['price']) / $combo['original_price'] * 100);
                        }
                        ?>
                        
                        <?php if ($discount > 0): ?>
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded fw-bold" style="z-index: 2; font-size: 0.8rem; <?= $discount >= 30 ? 'animation: pulse 1.5s infinite;' : '' ?>">
                                -<?= $discount ?>%
                                <?php if ($discount >= 30): ?> <i class="fa-solid fa-fire"></i> <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <img src="<?= htmlspecialchars($combo['image'] ?: 'assets/images/default.jpg') ?>" alt="<?= htmlspecialchars($combo['name']) ?>"
                            style="height: 180px; width: 100%; object-fit: cover;">

                        <div class="tour-info d-flex flex-column p-2" style="height: 100%;">
                            <h6 class="mb-1" style="font-size: 0.95rem; line-height: 1.3;">
                                <?= htmlspecialchars($combo['name']) ?>
                            </h6>

                            <p class="text-muted mb-2" style="font-size: 0.8rem;">
                                <i class="bi bi-clock"></i> <?= htmlspecialchars($combo['duration']) ?>
                            </p>

                            <div class="mt-auto mb-2">
                                <?php if ($discount > 0): ?>
                                    <div class="text-muted text-decoration-line-through" style="font-size: 0.75rem;">
                                        <?= formatPrice($combo['original_price']) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="text-danger fw-bold" style="font-size: 1.1rem;">
                                    <?= formatPrice($combo['price']) ?>
                                </div>
                            </div>

                            <a href="combo-detail.php?id=<?= $combo['id'] ?>" class="btn btn-sm btn-outline-primary w-100 mt-auto" style="font-size: 0.85rem;">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Hiện chưa có combo nào được đăng tải.</h4>
                <a href="index.php" class="btn btn-primary mt-3">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
