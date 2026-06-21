<?php
$page_title = "Săn Voucher Khuyến Mại";
require 'includes/db.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'] ?? null;

// Lấy danh sách các mã khuyến mại đang hoạt động và còn hạn, còn lượt
$sql = "SELECT p.*, 
        (SELECT COUNT(*) FROM user_promotions up WHERE up.promotion_id = p.id AND up.user_id = " . ($user_id ? $user_id : 0) . ") as is_claimed 
        FROM promotions p 
        WHERE p.status = 'active' 
        AND p.end_date >= CURDATE() 
        AND (p.usage_limit IS NULL OR p.used_count < p.usage_limit)
        ORDER BY p.discount_value DESC";
$result = mysqli_query($conn, $sql);
$promotions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $promotions[] = $row;
}
?>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h2 class="fw-bold text-danger"><i class="fa-solid fa-gift"></i> Kho Voucher Khuyến Mại</h2>
            <p class="text-muted">Săn ngay các mã giảm giá hấp dẫn để chuyến đi của bạn thêm phần trọn vẹn và tiết kiệm.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <?php if ($user_id): ?>
                <button class="btn btn-warning fw-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#luckyWheelModal">
                    <i class="fa-solid fa-dharmachakra fa-spin"></i> Vòng Quay May Mắn
                </button>
            <?php else: ?>
                <a href="login.php" class="btn btn-warning fw-bold px-4 py-2">
                    <i class="fa-solid fa-dharmachakra"></i> Đăng nhập để Quay thưởng
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <?php if (count($promotions) > 0): ?>
            <?php foreach ($promotions as $promo): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="voucher-card d-flex border rounded overflow-hidden shadow-sm position-relative">
                        <div class="voucher-left bg-danger text-white d-flex flex-column justify-content-center align-items-center p-3" style="width: 35%; border-right: 2px dashed #fff;">
                            <?php if ($promo['discount_type'] === 'percent'): ?>
                                <span class="fs-1 fw-bold"><?= floatval($promo['discount_value']) ?>%</span>
                            <?php else: ?>
                                <span class="fs-4 fw-bold"><?= number_format($promo['discount_value']) ?>đ</span>
                            <?php endif; ?>
                            <small class="text-uppercase text-center">Giảm giá</small>
                        </div>
                        <div class="voucher-right bg-white p-3 d-flex flex-column justify-content-between" style="width: 65%;">
                            <div>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($promo['code']) ?></h5>
                                <p class="text-muted small mb-0">HSD: <?= date('d/m/Y', strtotime($promo['end_date'])) ?></p>
                                <?php if ($promo['usage_limit']): ?>
                                    <p class="text-muted small mb-0">Còn lại: <?= $promo['usage_limit'] - $promo['used_count'] ?> lượt</p>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3 text-end">
                                <?php if (!$user_id): ?>
                                    <a href="login.php" class="btn btn-sm btn-outline-danger">Đăng nhập để Lưu</a>
                                <?php elseif ($promo['is_claimed'] > 0): ?>
                                    <button class="btn btn-sm btn-secondary" disabled>Đã Lưu</button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-danger claim-voucher-btn" data-id="<?= $promo['id'] ?>">Lưu Mã</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cut-circle top"></div>
                        <div class="cut-circle bottom"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Hiện tại chưa có mã khuyến mại nào.</h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Lucky Wheel Modal -->
<div class="modal fade" id="luckyWheelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <div class="wheel-container d-inline-block position-relative bg-white rounded-4 p-4 shadow-lg text-center" style="max-width: 400px;">
                    <h4 class="fw-bold text-danger mb-4">Vòng Quay May Mắn</h4>
                    
                    <div class="wheel-wrapper position-relative mx-auto" style="width: 250px; height: 250px;">
                        <!-- Mũi tên chỉ -->
                        <div class="wheel-pointer position-absolute top-0 start-50 translate-middle-x" style="z-index: 5; width: 0; height: 0; border-left: 15px solid transparent; border-right: 15px solid transparent; border-top: 30px solid #dc3545; margin-top: -10px;"></div>
                        
                        <!-- Vòng quay -->
                        <img src="assets/images/lucky_wheel.png" id="wheel-image" class="w-100 h-100 rounded-circle shadow-sm" alt="Wheel" style="transition: transform 4s cubic-bezier(0.17, 0.67, 0.12, 0.99);">
                    </div>
                    
                    <button id="spin-btn" class="btn btn-warning btn-lg fw-bold mt-4 w-100 text-uppercase rounded-pill shadow-sm">
                        Quay Ngay
                    </button>
                    <p class="text-muted small mt-3 mb-0" id="spin-msg">Mỗi ngày bạn có 1 lượt quay miễn phí!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.voucher-card {
    transition: transform 0.3s ease;
}
.voucher-card:hover {
    transform: translateY(-5px);
}
.cut-circle {
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: #f8fafc;
    border-radius: 50%;
    left: 35%;
    transform: translateX(-50%);
    border-right: 1px solid #dee2e6;
}
.cut-circle.top {
    top: -10px;
    border-bottom: 1px solid #dee2e6;
}
.cut-circle.bottom {
    bottom: -10px;
    border-top: 1px solid #dee2e6;
}
body {
    background-color: #f8fafc;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lưu mã voucher
    document.querySelectorAll('.claim-voucher-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const promoId = this.getAttribute('data-id');
            const button = this;
            
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            button.disabled = true;

            fetch('api_claim_voucher.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'promotion_id=' + promoId
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-secondary');
                    button.innerText = 'Đã Lưu';
                    alert('Lưu mã thành công! Bạn có thể xem trong Hồ sơ > Kho Voucher.');
                } else {
                    button.innerHTML = 'Lưu Mã';
                    button.disabled = false;
                    alert(data.message || 'Có lỗi xảy ra.');
                }
            })
            .catch(err => {
                button.innerHTML = 'Lưu Mã';
                button.disabled = false;
                alert('Lỗi kết nối.');
            });
        });
    });

    // Vòng quay may mắn
    const spinBtn = document.getElementById('spin-btn');
    const wheelImg = document.getElementById('wheel-image');
    const spinMsg = document.getElementById('spin-msg');
    let isSpinning = false;

    if (spinBtn) {
        spinBtn.addEventListener('click', function() {
            if (isSpinning) return;
            isSpinning = true;
            spinBtn.disabled = true;
            spinBtn.innerText = 'Đang quay...';

            fetch('api_spin_wheel.php', { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    isSpinning = false;
                    spinBtn.disabled = false;
                    spinBtn.innerText = 'Quay Ngay';
                    return;
                }

                // Giả lập quay (random degree + spin 5 rounds)
                const extraDegree = Math.floor(Math.random() * 360);
                const totalDegree = 360 * 5 + extraDegree;
                
                wheelImg.style.transform = `rotate(${totalDegree}deg)`;

                setTimeout(() => {
                    alert(data.message);
                    isSpinning = false;
                    spinBtn.innerText = 'Quay Xong';
                    spinMsg.innerText = 'Hẹn gặp lại bạn vào ngày mai!';
                    
                    // Xóa style rotate để reset nếu muốn, hoặc cứ để
                    // Tải lại trang để update danh sách voucher nếu trúng
                    if (data.won) {
                        window.location.reload();
                    }
                }, 4200); // 4s cho animation + 200ms
            })
            .catch(err => {
                alert('Lỗi kết nối.');
                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.innerText = 'Quay Ngay';
            });
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
