<?php

require 'includes/db.php';

if (!isset($_GET['id'])) {

    die("Không tìm thấy tour");

}

$id = (int) $_GET['id'];

$sql = "
SELECT *
FROM tours
WHERE id = $id
";

$result = mysqli_query($conn, $sql);

$tour = mysqli_fetch_assoc($result);

if (!$tour) {

    die("Tour không tồn tại");

}

// Xử lý gửi đánh giá
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];
        $rating = (int)$_POST['rating'];
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        
        $insert_review = "INSERT INTO reviews (user_id, tour_id, rating, comment) VALUES ($user_id, $id, $rating, '$comment')";
        if (mysqli_query($conn, $insert_review)) {
            $review_success = "Cảm ơn bạn đã đánh giá!";
        } else {
            $review_error = "Có lỗi xảy ra, vui lòng thử lại sau.";
        }
    } else {
        $review_error = "Bạn cần đăng nhập để đánh giá.";
    }
}
// Lấy danh sách đánh giá
$reviews_query = mysqli_query($conn, "
    SELECT r.*, u.full_name, u.avatar 
    FROM reviews r 
    JOIN users u ON r.user_id = u.id 
    WHERE r.tour_id = $id 
    ORDER BY r.created_at DESC
");
$reviews = [];
$total_rating = 0;
while ($row = mysqli_fetch_assoc($reviews_query)) {
    $reviews[] = $row;
    $total_rating += $row['rating'];
}
$avg_rating = count($reviews) > 0 ? round($total_rating / count($reviews), 1) : 0;

// Lấy danh sách ảnh gallery
$gallery_query = mysqli_query($conn, "SELECT image_url FROM tour_images WHERE tour_id = $id ORDER BY id ASC");
$gallery_images = [];
while ($row = mysqli_fetch_assoc($gallery_query)) {
    $gallery_images[] = $row['image_url'];
}

// Luôn đưa thumbnail vào đầu mảng ảnh nếu mảng rỗng hoặc để đảm bảo có ảnh
$all_images = [];
if (!empty($tour['thumbnail'])) {
    $all_images[] = $tour['thumbnail'];
}
foreach ($gallery_images as $img) {
    if (!in_array($img, $all_images)) {
        $all_images[] = $img;
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="container tour-detail-page mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="#">Du lịch</a></li>
            <li class="breadcrumb-item"><a href="#">Trong nước</a></li>
            <li class="breadcrumb-item"><a href="#">Miền Bắc</a></li>
            <li class="breadcrumb-item"><a href="#">...</a></li>
            <li class="breadcrumb-item"><a href="#">Ninh Bình</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= htmlspecialchars($tour['title'] ?? 'Hà Nội - Vịnh Hạ Long - Chùa Bái Đính - Tràng An - Tuyệt Tình Cốc') ?>
            </li>
        </ol>
    </nav>

    <!-- Tour Title Card -->
    <div class="tour-title-card mb-4">
        <h1><?= htmlspecialchars($tour['title'] ?? 'Hà Nội - Vịnh Hạ Long - Chùa Bái Đính - Tràng An - Tuyệt Tình Cốc') ?>
        </h1>
    </div>

    <div class="row">
        <!-- Left Column: Images -->
        <div class="col-lg-8 mb-4">
            <!-- Auto-playing Carousel -->
            <div id="tourImageCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 20px; overflow: hidden; box-shadow: var(--card-shadow);">
                <div class="carousel-inner" style="height: 450px;">
                    <?php if (count($all_images) > 0): ?>
                        <?php foreach ($all_images as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="height: 100%;">
                                <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="Tour Image <?= $index + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active" style="height: 100%;">
                            <img src="https://images.unsplash.com/photo-1599839619722-39751411ea63?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="Default Image">
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (count($all_images) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#tourImageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tourImageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <?php endif; ?>
            </div>

            <!-- Tour Description Summary -->
            <div class="tour-description-summary mt-5 p-4 bg-white rounded" style="box-shadow: var(--card-shadow);">
                <h4 class="mb-3 fw-bold">Điểm nhấn hành trình</h4>
                
                <!-- Display content as a list of highlights if possible, or just a truncated text -->
                <div class="summary-content text-muted" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                    <?= $tour['description'] ?? 'Mô tả chương trình tour chi tiết...' ?>
                </div>
                
                <button type="button" class="btn btn-outline-primary mt-3 rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#descriptionModal">
                    Xem thêm
                </button>
            </div>

            <!-- Description Modal -->
            <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius: 15px;">
                  <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold fs-4" id="descriptionModalLabel">Chi tiết chương trình</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body px-4 py-4" style="line-height: 1.8;">
                    <?= $tour['description'] ?? 'Mô tả chương trình tour chi tiết...' ?>
                  </div>
                  <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <!-- Right Column: Info & Booking -->
        <div class="col-lg-4">
            <div class="tour-info-card sticky-top" style="top: 100px;">
                <div class="d-flex justify-content-between mb-3 info-row">
                    <span class="info-label"><i class="fa-regular fa-id-card"></i> Mã chương trình:</span>
                    <span class="info-value text-primary font-weight-bold">#<?= htmlspecialchars($tour['id']) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-4 info-row">
                    <span class="info-label"><i class="fa-regular fa-clock"></i> Thời gian:</span>
                    <span class="info-value text-primary font-weight-bold"><?= htmlspecialchars($tour['duration_days'] ?? 0) ?> ngày <?= htmlspecialchars($tour['duration_nights'] ?? 0) ?> đêm</span>
                </div>
                <div class="d-flex justify-content-between mb-4 info-row">
                    <span class="info-label"><i class="fa-regular fa-star"></i> Đánh giá:</span>
                    <span class="info-value text-warning fw-bold">
                        <?php if ($avg_rating > 0): ?>
                            <?= number_format($avg_rating, 1) ?> <i class="fa-solid fa-star"></i> 
                            <small class="text-muted">(<?= count($reviews) ?> đánh giá)</small>
                        <?php else: ?>
                            <span class="text-muted">Chưa có đánh giá</span>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="price-section d-flex align-items-end justify-content-between mt-4 pt-3 border-top mb-4">
                    <span class="price-label">Giá từ:</span>
                    <span class="price-amount text-primary"><?= formatPrice($tour['price'] ?? 0) ?></span>
                </div>

                <div class="action-buttons d-flex gap-3">
                    <a href="tel:19001234"
                        class="btn btn-primary phone-btn rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px; flex-shrink: 0;">
                        <i class="fa-solid fa-phone"></i>
                    </a>
                    <a href="booking.php?tour_id=<?= $tour['id'] ?? 1 ?>"
                        class="btn btn-danger book-btn flex-grow-1 rounded-pill fw-bold fs-5 d-flex align-items-center justify-content-center">
                        Chọn ngày
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần đánh giá khách hàng -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2">Đánh giá từ Khách hàng</h3>
            <?php if (count($reviews) > 0): ?>
                <!-- Bộ lọc đánh giá -->
                <div class="review-filters mb-3 d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary filter-btn rounded-pill px-3 fw-bold shadow-sm" data-filter="all">Tất cả</button>
                    <button class="btn btn-sm btn-outline-primary filter-btn rounded-pill px-3 fw-bold shadow-sm" data-filter="good">Đánh giá tốt (4-5 <i class="fa-solid fa-star text-warning" style="font-size: 10px;"></i>)</button>
                    <button class="btn btn-sm btn-outline-primary filter-btn rounded-pill px-3 fw-bold shadow-sm" data-filter="bad">Cần cải thiện (1-3 <i class="fa-solid fa-star text-warning" style="font-size: 10px;"></i>)</button>
                </div>
                
                <!-- Horizontal scroll container cho bình luận -->
                <div class="d-flex flex-row flex-nowrap overflow-auto pb-3 gap-3" id="reviews-container" style="scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                    <?php foreach ($reviews as $review): ?>
                        <div class="card border-0 shadow-sm flex-shrink-0 review-item" data-rating="<?= $review['rating'] ?>" style="width: 350px; border-radius: 12px; transition: all 0.3s ease;">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <?php if (!empty($review['avatar'])): ?>
                                            <img src="<?= htmlspecialchars($review['avatar']) ?>" alt="Avatar" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #f8f9fa;">
                                        <?php else: ?>
                                            <i class="fa-solid fa-circle-user text-secondary" style="font-size: 45px;"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold" style="font-size: 15px;"><?= htmlspecialchars($review['full_name']) ?></h6>
                                        <small class="text-muted" style="font-size: 12px;"><?= date('d/m/Y', strtotime($review['created_at'])) ?></small>
                                    </div>
                                </div>
                                <div class="text-warning mb-2" style="font-size: 14px;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review['rating']): ?>
                                            <i class="fa-solid fa-star"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="card-text text-secondary mb-0" style="font-size: 14px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= nl2br(htmlspecialchars($review['comment'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center py-4 text-muted">
                    <i class="fa-regular fa-comment-dots fa-2x mb-2"></i>
                    <p class="mb-0">Chưa có đánh giá nào cho tour này. Hãy là người đầu tiên trải nghiệm và để lại đánh giá!</p>
                </div>
            <?php endif; ?>

            <!-- Form Đánh giá -->
            <div class="review-form mt-5 p-4 bg-light rounded">
                <h4 class="mb-3">Viết đánh giá của bạn</h4>
                <?php if (isset($review_success)): ?>
                    <div class="alert alert-success"><?= $review_success ?></div>
                <?php endif; ?>
                <?php if (isset($review_error)): ?>
                    <div class="alert alert-danger"><?= $review_error ?></div>
                <?php endif; ?>
                
                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['user_id'])): 
                ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Chọn số sao:</label>
                            <div class="rating-stars mb-2" style="font-size: 24px; color: #ffc107; cursor: pointer;">
                                <i class="fa-solid fa-star star-input" data-value="1"></i>
                                <i class="fa-solid fa-star star-input" data-value="2"></i>
                                <i class="fa-solid fa-star star-input" data-value="3"></i>
                                <i class="fa-solid fa-star star-input" data-value="4"></i>
                                <i class="fa-solid fa-star star-input" data-value="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label fw-bold">Nhận xét của bạn:</label>
                            <textarea class="form-control" name="comment" id="comment" rows="4" required placeholder="Chia sẻ trải nghiệm của bạn về tour này..."></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-primary px-4 py-2 fw-bold">Gửi đánh giá</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info mb-0">
                        Vui lòng <a href="login.php" class="alert-link">đăng nhập</a> để có thể viết đánh giá.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-input');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;
            updateStars(value);
        });
        
        star.addEventListener('mouseover', function() {
            const value = this.getAttribute('data-value');
            updateStars(value);
        });
    });
    
    const starContainer = document.querySelector('.rating-stars');
    if(starContainer) {
        starContainer.addEventListener('mouseleave', function() {
            const currentValue = ratingInput.value;
            updateStars(currentValue);
        });
    }
    
    function updateStars(value) {
        stars.forEach(s => {
            if (s.getAttribute('data-value') <= value) {
                s.classList.remove('fa-regular');
                s.classList.add('fa-solid');
            } else {
                s.classList.remove('fa-solid');
                s.classList.add('fa-regular');
            }
        });
    }

    // Xử lý bộ lọc đánh giá
    const filterBtns = document.querySelectorAll('.filter-btn');
    const reviewItems = document.querySelectorAll('.review-item');
    
    if (filterBtns.length > 0 && reviewItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Đổi class active
                filterBtns.forEach(b => {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-primary');
                });
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                
                const filterValue = this.getAttribute('data-filter');
                let visibleCount = 0;
                
                reviewItems.forEach(item => {
                    const rating = parseInt(item.getAttribute('data-rating'));
                    let show = false;
                    
                    if (filterValue === 'all') {
                        show = true;
                    } else if (filterValue === 'good' && rating >= 4) {
                        show = true;
                    } else if (filterValue === 'bad' && rating <= 3) {
                        show = true;
                    }
                    
                    if (show) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                // Nếu không có đánh giá nào phù hợp với bộ lọc
                let emptyMsg = document.getElementById('empty-filter-msg');
                if (visibleCount === 0) {
                    if (!emptyMsg) {
                        emptyMsg = document.createElement('div');
                        emptyMsg.id = 'empty-filter-msg';
                        emptyMsg.className = 'alert alert-light text-center w-100 py-4 text-muted border-0 shadow-sm';
                        emptyMsg.style.borderRadius = '12px';
                        emptyMsg.innerHTML = '<i class="fa-regular fa-face-frown fa-2x mb-2 text-secondary"></i><p class="mb-0">Không có đánh giá nào phù hợp với bộ lọc này.</p>';
                        document.getElementById('reviews-container').appendChild(emptyMsg);
                    }
                    emptyMsg.style.display = 'block';
                } else if (emptyMsg) {
                    emptyMsg.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>