<?php
require 'includes/db.php';
include 'includes/header.php';

// Fetch all services
$sql = "SELECT * FROM additional_services ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <h1 class="text-center mb-5">Danh Sách Dịch Vụ Cộng Thêm</h1>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($service = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 tour-card">
                        <?php if ($service['image_url']): ?>
                            <img src="<?= htmlspecialchars($service['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($service['name']) ?>" style="height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fa-solid fa-image fa-2x"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="card-title fw-bold text-primary mb-2" style="font-size: 0.95rem; line-height: 1.3;">
                                <a href="service-detail.php?id=<?= $service['id'] ?>" class="text-decoration-none text-primary">
                                    <?= htmlspecialchars($service['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text flex-grow-1 text-muted" style="font-size: 0.8rem; line-height: 1.4;">
                                <?php 
                                $desc = strip_tags($service['description']);
                                echo mb_strlen($desc) > 80 ? mb_substr($desc, 0, 80) . '...' : $desc;
                                ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <span class="fs-6 fw-bold text-danger"><?= formatPrice($service['price']) ?></span>
                                <a href="service-detail.php?id=<?= $service['id'] ?>" class="btn btn-sm btn-outline-primary" style="font-size: 0.8rem;">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Hiện chưa có dịch vụ cộng thêm nào được đăng tải.</p>
                <a href="index.php" class="btn btn-primary">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
