<?php
require 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: guide.php");
    exit();
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM guides WHERE id = $id";
$result = mysqli_query($conn, $sql);
$guide = mysqli_fetch_assoc($result);

if (!$guide) {
    header("Location: guide.php");
    exit();
}

$page_title = htmlspecialchars($guide['title']);
include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="guide.php" class="text-decoration-none">Cẩm nang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
                </ol>
            </nav>

            <h1 class="fw-bold mb-3"><?= htmlspecialchars($guide['title']) ?></h1>
            <p class="text-muted mb-4"><i class="bi bi-calendar3 me-2"></i> Đăng ngày: <?= date('d/m/Y', strtotime($guide['created_at'])) ?> &bull; Bởi <b>THEGIOI Travel</b></p>
            
            <?php if (!empty($guide['image'])): ?>
                <?php $img_src = (strpos($guide['image'], 'http') === 0) ? $guide['image'] : 'assets/images/guides/' . $guide['image']; ?>
                <div class="mb-5">
                    <img src="<?= htmlspecialchars($img_src) ?>" alt="Cover" class="img-fluid rounded-4 w-100 shadow-sm" style="max-height: 500px; object-fit: cover;">
                </div>
            <?php endif; ?>

            <div class="lead text-secondary fw-medium mb-4 pb-4 border-bottom" style="font-style: italic;">
                <?= htmlspecialchars($guide['excerpt']) ?>
            </div>

            <div class="guide-content fs-5 text-dark" style="line-height: 1.8;">
                <?= $guide['content'] ?>
            </div>
            
            <?php
            // Fetch gallery images
            $images_res = mysqli_query($conn, "SELECT image FROM guide_images WHERE guide_id = $id");
            if (mysqli_num_rows($images_res) > 0):
            ?>
            <div class="mt-5 pt-4">
                <h4 class="fw-bold mb-4">Hình ảnh bài viết</h4>
                <div class="row g-3">
                    <?php while ($img = mysqli_fetch_assoc($images_res)): ?>
                    <?php $g_img_src = (strpos($img['image'], 'http') === 0) ? $img['image'] : 'assets/images/guides/' . $img['image']; ?>
                    <div class="col-6 col-md-4">
                        <img src="<?= htmlspecialchars($g_img_src) ?>" alt="Gallery Image" class="img-fluid rounded-4 shadow-sm w-100" style="height: 200px; object-fit: cover;">
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="mt-5 pt-4 border-top text-center">
                <h5 class="fw-bold mb-3">Chia sẻ bài viết này</h5>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></button>
                    <button class="btn btn-info text-white rounded-circle" style="width: 40px; height: 40px;"><i class="bi bi-twitter"></i></button>
                    <button class="btn btn-secondary rounded-circle" style="width: 40px; height: 40px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!');"><i class="bi bi-link-45deg"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.guide-content img {
    max-width: 100%;
    border-radius: 8px;
    margin: 15px 0;
}
</style>

<?php include 'includes/footer.php'; ?>
