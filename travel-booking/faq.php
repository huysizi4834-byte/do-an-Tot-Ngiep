<?php
$page_title = "Tư vấn du lịch";
require 'includes/db.php';
include 'includes/header.php';

// Fetch all destinations
$sql = "SELECT * FROM destinations ORDER BY name ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-primary text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tư vấn du lịch</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold">Tư vấn du lịch</h2>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($dest = mysqli_fetch_assoc($result)): ?>
                <?php 
                // Tạo số lượng câu hỏi ngẫu nhiên hoặc dựa trên ID để giống thiết kế
                $question_count = ($dest['id'] * 7) % 50 + 40; 
                ?>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm destination-advice-card">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars($dest['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($dest['name']) ?>" 
                                 class="card-img-top object-fit-cover" 
                                 style="height: 180px;"
                                 onerror="this.src='https://picsum.photos/600/400?random=<?= $dest['id'] ?>'">
                            <div class="position-absolute bottom-0 start-0 bg-dark text-white px-2 py-1 m-0" style="font-size: 13px;">
                                <?= $question_count ?> câu hỏi
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-primary mb-2"><?= htmlspecialchars($dest['name']) ?></h5>
                            <p class="card-text text-muted flex-grow-1" style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($dest['description'] ?? 'Thông tin tư vấn du lịch và giải đáp các thắc mắc thường gặp về địa điểm này sẽ giúp bạn có một chuyến đi tuyệt vời nhất.') ?>
                            </p>
                            <a href="tours.php?destination=<?= urlencode($dest['name']) ?>" class="btn btn-warning fw-bold text-white w-100 mt-3" style="background-color: #f39c12; border: none;">Tư vấn du lịch</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Chưa có thông tin điểm đến nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.destination-advice-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.destination-advice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>

<?php include 'includes/footer.php'; ?>
