<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/db.php';

if (!isset($_GET['id'])) {
    include 'includes/header.php';
    echo "<div class='container py-5 text-center'><h1>Không tìm thấy dịch vụ</h1><a href='services.php' class='btn btn-primary mt-3'>Quay lại</a></div>";
    include 'includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM additional_services WHERE id = $id";
$result = mysqli_query($conn, $sql);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    include 'includes/header.php';
    echo "<div class='container py-5 text-center'><h1>Dịch vụ không tồn tại</h1><a href='services.php' class='btn btn-primary mt-3'>Quay lại</a></div>";
    include 'includes/footer.php';
    exit;
}

// Xử lý gửi đánh giá
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];
        $rating = (int)$_POST['rating'];
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        
        $insert_review = "INSERT INTO service_reviews (user_id, service_id, rating, comment) VALUES ($user_id, $id, $rating, '$comment')";
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
    FROM service_reviews r 
    JOIN users u ON r.user_id = u.id 
    WHERE r.service_id = $id 
    ORDER BY r.created_at DESC
");
$reviews = [];
$total_rating = 0;
while ($row = mysqli_fetch_assoc($reviews_query)) {
    $reviews[] = $row;
    $total_rating += $row['rating'];
}
$avg_rating = count($reviews) > 0 ? round($total_rating / count($reviews), 1) : 0;

// Xử lý form đặt dịch vụ TRƯỚC KHI gọi header.php để tránh lỗi Cannot modify header
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_service'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];
        $service_date = mysqli_real_escape_string($conn, $_POST['service_date']);
        $quantity = (int)$_POST['quantity'];
        
        if ($quantity > 0 && !empty($service_date)) {
            $discount_amount = isset($_POST['discount_amount']) ? (float)$_POST['discount_amount'] : 0;
            $promotion_id = isset($_POST['promotion_id']) ? (int)$_POST['promotion_id'] : 0;

            $raw_price = $service['price'] * $quantity;
            $total_price = $raw_price - $discount_amount;
            if ($total_price < 0) $total_price = 0;
            $payment_type = $_POST['payment_type'] ?? 'full';
            $amount_paid = ($payment_type === 'deposit') ? ($total_price / 2) : $total_price;
            $booking_code = 'SV' . strtoupper(substr(uniqid(), -6));
            
            $insert_sql = "INSERT INTO service_bookings (user_id, service_id, booking_code, service_date, quantity, total_price, payment_type, amount_paid, payment_status, status) 
                           VALUES ($user_id, $id, '$booking_code', '$service_date', $quantity, $total_price, '$payment_type', $amount_paid, 'pending', 'pending')";
                           
            if (mysqli_query($conn, $insert_sql)) {
                if ($promotion_id > 0) {
                    mysqli_query($conn, "UPDATE user_promotions SET status = 'used', used_at = NOW() WHERE user_id = $user_id AND promotion_id = $promotion_id");
                    mysqli_query($conn, "UPDATE promotions SET used_count = used_count + 1 WHERE id = $promotion_id");
                }
                header("Location: payment-gateway.php?code=" . $booking_code);
                exit;
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại sau.";
            }
        } else {
            $error = "Vui lòng nhập ngày sử dụng và số lượng hợp lệ.";
        }
    } else {
        $error = "Vui lòng đăng nhập để đặt dịch vụ.";
    }
}

include 'includes/header.php';
?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="services.php" class="text-decoration-none">Dịch vụ cộng thêm</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($service['name']) ?></li>
        </ol>
    </nav>

    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Cột chi tiết dịch vụ -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <?php if ($service['image_url']): ?>
                    <img src="<?= htmlspecialchars($service['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($service['name']) ?>" style="max-height: 400px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body p-4">
                    <h1 class="card-title fw-bold text-primary mb-3"><?= htmlspecialchars($service['name']) ?></h1>
                    
                    <div class="d-flex align-items-center mb-4 text-muted">
                        <i class="fa-solid fa-tags me-2"></i> Dịch vụ tiện ích
                    </div>

                    <h4 class="fw-bold mb-3 border-bottom pb-2">Chi tiết dịch vụ</h4>
                    <div class="service-description" style="line-height: 1.8;">
                        <div class="service-description"><?= $service['description'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột đặt dịch vụ -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h4 class="card-title fw-bold mb-4 text-center">Đặt Dịch Vụ</h4>
                    
                    <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
                        <span class="text-muted">Đơn giá:</span>
                        <span class="fs-4 fw-bold text-danger" id="unit-price" data-price="<?= $service['price'] ?>">
                            <?= formatPrice($service['price']) ?>
                        </span>
                    </div>

                    <form action="" method="POST" id="bookingForm">
                        <div class="mb-3">
                            <label for="service_date" class="form-label fw-bold">Ngày sử dụng <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="service_date" name="service_date" required min="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                        </div>

                        <div class="mb-4 p-3 bg-light rounded border">
                            <label class="form-label fw-bold">Mã giảm giá (Tùy chọn)</label>
                            <div class="input-group mb-2">
                                <input type="text" id="voucher_code" class="form-control" placeholder="Nhập mã giảm giá...">
                                <button type="button" id="btn-apply-voucher" class="btn btn-outline-danger">Áp dụng</button>
                            </div>
                            <div id="voucher-msg" class="small"></div>
                        </div>

                        <input type="hidden" name="promotion_id" id="promotion_id" value="">
                        <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                        <div class="d-flex justify-content-between mb-2 text-success" id="discount-row" style="display: none !important;">
                            <span class="fw-bold">Giảm giá:</span>
                            <span class="fw-bold" id="discount-display">0</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-4 p-3 bg-light rounded">
                            <span class="fw-bold">Tổng tiền:</span>
                            <span class="fs-4 fw-bold text-danger" id="total-price">
                                <?= formatPrice($service['price']) ?>
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Hình thức thanh toán</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_type" id="pay_full" value="full" checked>
                                <label class="form-check-label fw-bold" for="pay_full">Thanh toán toàn bộ 100%</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_type" id="pay_deposit" value="deposit">
                                <label class="form-check-label fw-bold" for="pay_deposit">Đặt cọc trước 50%</label>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="submit" name="book_service" class="btn btn-danger w-100 py-3 fw-bold fs-5 rounded-pill">
                                Đặt Ngay
                            </button>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary w-100 py-3 fw-bold fs-5 rounded-pill">
                                Đăng nhập để đặt
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần đánh giá khách hàng -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2 d-flex justify-content-between align-items-center">
                <span>Đánh giá từ Khách hàng</span>
            </h3>
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
                <div class="alert alert-light text-center py-4 text-muted border-0 shadow-sm" style="border-radius: 12px;">
                    <i class="fa-regular fa-comment-dots fa-2x mb-2 text-secondary"></i>
                    <p class="mb-0">Chưa có đánh giá nào cho dịch vụ này. Hãy là người đầu tiên trải nghiệm và để lại đánh giá!</p>
                </div>
            <?php endif; ?>

            <!-- Form Đánh giá -->
            <div class="review-form mt-5 p-4 bg-light rounded shadow-sm">
                <h4 class="mb-3 fw-bold">Viết đánh giá của bạn</h4>
                <?php if (isset($review_success)): ?>
                    <div class="alert alert-success"><?= $review_success ?></div>
                <?php endif; ?>
                <?php if (isset($review_error)): ?>
                    <div class="alert alert-danger"><?= $review_error ?></div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['user_id'])): ?>
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
                            <textarea class="form-control border-0 shadow-sm" name="comment" id="comment" rows="4" required placeholder="Chia sẻ trải nghiệm của bạn về dịch vụ này..."></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">Gửi đánh giá</button>
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
    const quantityInput = document.getElementById('quantity');
    const totalPriceEl = document.getElementById('total-price');
    const unitPrice = parseInt(document.getElementById('unit-price').getAttribute('data-price'), 10);

    const currencyFormat = "<?= $_SESSION['currency'] ?? 'VND' ?>";
    const exchangeRate = <?= isset($_SESSION['currency']) ? 
        ($_SESSION['currency'] == 'USD' ? 25000 : 
        ($_SESSION['currency'] == 'EUR' ? 27000 : 
        ($_SESSION['currency'] == 'JPY' ? 170 : 1))) : 1 ?>;

    function updateTotal() {
        let quantity = parseInt(quantityInput.value, 10);
        if (isNaN(quantity) || quantity < 1) quantity = 1;
        
        let rawTotalVND = quantity * unitPrice;
        let discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
        let finalTotalVND = rawTotalVND - discountAmount;
        if (finalTotalVND < 0) finalTotalVND = 0;

        if (discountAmount > 0) {
            document.getElementById('discount-row').style.setProperty('display', 'flex', 'important');
            let convertedDiscount = discountAmount / exchangeRate;
            let formattedDiscount = '';
            if(currencyFormat === 'VND') {
                formattedDiscount = '-' + new Intl.NumberFormat('vi-VN').format(convertedDiscount) + ' ₫';
            } else if(currencyFormat === 'USD') {
                formattedDiscount = '-$' + new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedDiscount);
            } else if(currencyFormat === 'EUR') {
                formattedDiscount = '-€' + new Intl.NumberFormat('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedDiscount);
            } else if(currencyFormat === 'JPY') {
                formattedDiscount = '-¥' + new Intl.NumberFormat('ja-JP').format(convertedDiscount);
            }
            document.getElementById('discount-display').textContent = formattedDiscount;
        } else {
            document.getElementById('discount-row').style.setProperty('display', 'none', 'important');
        }

        let convertedTotal = finalTotalVND / exchangeRate;
        
        let formattedTotal = '';
        if(currencyFormat === 'VND') {
            formattedTotal = new Intl.NumberFormat('vi-VN').format(convertedTotal) + ' ₫';
        } else if(currencyFormat === 'USD') {
            formattedTotal = '$' + new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedTotal);
        } else if(currencyFormat === 'EUR') {
            formattedTotal = '€' + new Intl.NumberFormat('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedTotal);
        } else if(currencyFormat === 'JPY') {
            formattedTotal = '¥' + new Intl.NumberFormat('ja-JP').format(convertedTotal);
        }
        
        totalPriceEl.textContent = formattedTotal;
    }

    quantityInput.addEventListener('input', updateTotal);

    // Xử lý áp dụng mã giảm giá
    const btnApply = document.getElementById('btn-apply-voucher');
    const inputCode = document.getElementById('voucher_code');
    const msgDiv = document.getElementById('voucher-msg');
    
    if (btnApply) {
        btnApply.addEventListener('click', function() {
            const code = inputCode.value.trim();
            if (!code) {
                msgDiv.innerHTML = '<span class="text-danger">Vui lòng nhập mã.</span>';
                return;
            }

            let quantity = parseInt(quantityInput.value, 10);
            if (isNaN(quantity) || quantity < 1) quantity = 1;
            let currentTotal = quantity * unitPrice;

            btnApply.disabled = true;
            btnApply.innerText = 'Đang kt...';

            const formData = new URLSearchParams();
            formData.append('code', code);
            formData.append('total_amount', currentTotal);

            fetch('api_check_voucher.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(res => res.json())
            .then(data => {
                btnApply.disabled = false;
                btnApply.innerText = 'Áp dụng';

                if (data.success) {
                    msgDiv.innerHTML = '<span class="text-success">' + data.message + '</span>';
                    document.getElementById('promotion_id').value = data.promotion_id;
                    document.getElementById('discount_amount').value = data.discount_amount;
                    updateTotal();
                } else {
                    msgDiv.innerHTML = '<span class="text-danger">' + data.message + '</span>';
                    document.getElementById('promotion_id').value = '';
                    document.getElementById('discount_amount').value = 0;
                    updateTotal();
                }
            })
            .catch(err => {
                btnApply.disabled = false;
                btnApply.innerText = 'Áp dụng';
                msgDiv.innerHTML = '<span class="text-danger">Lỗi kết nối.</span>';
            });
        });
    }

    // Logic cho Đánh giá (Review)
    const stars = document.querySelectorAll('.star-input');
    const ratingInput = document.getElementById('rating-input');
    
    if (stars.length > 0) {
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
