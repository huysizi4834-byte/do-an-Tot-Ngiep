<?php
$page_title = "Cẩm nang Du lịch";
require 'includes/db.php';
include 'includes/header.php';

$sql = "SELECT * FROM guides ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5 mt-4">
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h1 class="fw-bold text-primary mb-3">Cẩm nang Du lịch</h1>
            <p class="text-muted fs-5">Kinh nghiệm, điểm đến và những câu chuyện truyền cảm hứng từ THEGIOI Travel.</p>
        </div>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: transform 0.3s ease;">
                        <a href="guide-detail.php?id=<?= $row['id'] ?>" class="text-decoration-none">
                            <?php if (!empty($row['image'])): ?>
                                <?php $img_src = (strpos($row['image'], 'http') === 0) ? $row['image'] : 'assets/images/guides/' . $row['image']; ?>
                                <img src="<?= htmlspecialchars($img_src) ?>" class="card-img-top" alt="Cover" style="height: 220px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary bg-opacity-25 d-flex justify-content-center align-items-center" style="height: 220px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body p-4 d-flex flex-column">
                            <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($row['created_at'])) ?></p>
                            <h5 class="card-title fw-bold mb-3">
                                <a href="guide-detail.php?id=<?= $row['id'] ?>" class="text-dark text-decoration-none text-hover-primary">
                                    <?= htmlspecialchars($row['title']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($row['excerpt']) ?>
                            </p>
                            <div class="mt-auto">
                                <a href="guide-detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary fw-bold rounded-pill px-4">Đọc tiếp <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                <h5 class="text-muted">Chưa có bài viết cẩm nang nào.</h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.text-hover-primary:hover {
    color: var(--bs-primary) !important;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
</style>

<?php include 'includes/footer.php'; ?>
