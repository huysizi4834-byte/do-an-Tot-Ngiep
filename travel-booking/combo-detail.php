<?php
session_start();
require 'includes/db.php';

if (!isset($_GET['id'])) {
    die("Không tìm thấy combo");
}

$id = (int) $_GET['id'];
$sql = "SELECT * FROM combos WHERE id = $id AND status = 'active'";
$result = mysqli_query($conn, $sql);
$combo = mysqli_fetch_assoc($result);

if (!$combo) {
    die("Combo không tồn tại hoặc đã bị tạm ngưng");
}

// Xử lý đặt combo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_combo'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
    $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $total_people = (int)$_POST['total_people'];

    $discount_amount = isset($_POST['discount_amount']) ? (float)$_POST['discount_amount'] : 0;
    $promotion_id = isset($_POST['promotion_id']) ? (int)$_POST['promotion_id'] : 0;

    $raw_price = $combo['price'] * $total_people;
    $total_price = $raw_price - $discount_amount;
    if ($total_price < 0) $total_price = 0;
    $payment_type = $_POST['payment_type'] ?? 'full';
    $amount_paid = ($payment_type === 'deposit') ? ($total_price / 2) : $total_price;
    $booking_code = 'CB' . strtoupper(substr(uniqid(), -6));
    
    $insert_sql = "INSERT INTO combo_bookings (user_id, combo_id, booking_code, travel_date, total_people, total_price, payment_type, amount_paid, payment_status, status, created_at) 
                   VALUES ($user_id, $id, '$booking_code', '$travel_date', $total_people, $total_price, '$payment_type', $amount_paid, 'pending', 'pending', NOW())";
                   
    if (mysqli_query($conn, $insert_sql)) {
        if ($promotion_id > 0) {
            mysqli_query($conn, "UPDATE user_promotions SET status = 'used', used_at = NOW() WHERE user_id = $user_id AND promotion_id = $promotion_id");
            mysqli_query($conn, "UPDATE promotions SET used_count = used_count + 1 WHERE id = $promotion_id");
        }
        header("Location: payment-gateway.php?code=" . $booking_code);
        exit;
    } else {
        $error = "Có lỗi xảy ra khi đặt combo: " . mysqli_error($conn);
    }
}

include 'includes/header.php';
?>

<div class="container tour-detail-page mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="combos.php">Combos</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= htmlspecialchars($combo['name']) ?>
            </li>
        </ol>
    </nav>

    <!-- Combo Title Card -->
    <div class="tour-title-card mb-4">
        <h1><?= htmlspecialchars($combo['name']) ?></h1>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Left Column: Images -->
        <div class="col-lg-8 mb-4">
            <div class="tour-gallery">
                <div class="main-image-container">
                    <img src="<?= htmlspecialchars($combo['image'] ?: 'assets/images/default.jpg') ?>"
                        alt="Main Combo Image" class="main-tour-img" style="width: 100%; border-radius: 10px;">
                </div>
            </div>

            <div class="tour-description mt-5 bg-white p-4 rounded shadow-sm">
                <?php if (!empty($combo['description'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3 border-bottom pb-2">Mô tả tổng quan</h4>
                    <div class="combo-description"><?= $combo['description'] ?></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($combo['highlights'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3 text-primary border-bottom pb-2"><i class="fas fa-star"></i> Điểm nhấn hành trình</h4>
                    <div class="combo-description"><?= $combo['highlights'] ?></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($combo['price_details'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3 text-success border-bottom pb-2"><i class="fas fa-money-bill-wave"></i> Chi tiết giá & Dịch vụ</h4>
                    <div class="combo-description"><?= $combo['price_details'] ?></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($combo['hotel_system'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3 text-info border-bottom pb-2"><i class="fas fa-hotel"></i> Hệ thống khách sạn</h4>
                    <div class="combo-description"><?= $combo['hotel_system'] ?></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($combo['policy'])): ?>
                <div class="mb-4">
                    <h4 class="mb-3 text-warning border-bottom pb-2"><i class="fas fa-exclamation-triangle"></i> Chính sách & Lưu ý</h4>
                    <div class="combo-description"><?= $combo['policy'] ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Info & Booking -->
        <div class="col-lg-4">
            <div class="tour-info-card sticky-top bg-white p-4 rounded shadow-sm" style="top: 100px;">
                <div class="d-flex justify-content-between mb-4 info-row pb-3 border-bottom">
                    <span class="info-label"><i class="bi bi-clock"></i> Thời gian:</span>
                    <span class="info-value text-primary font-weight-bold"><?= htmlspecialchars($combo['duration']) ?></span>
                </div>

                <div class="price-section d-flex align-items-end justify-content-between mb-4">
                    <span class="price-label">Giá mỗi người:</span>
                    <span class="price-amount text-danger fs-3 fw-bold" id="unit-price" data-price="<?= $combo['price'] ?>"><?= formatPrice($combo['price']) ?></span>
                </div>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="travel_date" class="form-label">Ngày khởi hành dự kiến</label>
                        <input type="date" class="form-control" id="travel_date" name="travel_date" required min="<?= date('Y-m-d') ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label for="total_people" class="form-label">Số người</label>
                        <input type="number" class="form-control" id="total_people" name="total_people" value="1" min="1" required>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded border" id="voucherSection" style="display: none;">
                        <label class="form-label fw-bold">Mã giảm giá (Tùy chọn)</label>
                        <div class="input-group mb-2">
                            <input type="text" id="voucher_code" class="form-control" placeholder="Nhập mã giảm giá...">
                            <button type="button" id="btn-apply-voucher" class="btn btn-outline-danger">Áp dụng</button>
                        </div>
                        <div id="voucher-msg" class="small"></div>
                    </div>

                    <input type="hidden" name="promotion_id" id="promotion_id" value="">
                    <input type="hidden" name="discount_amount" id="discount_amount" value="0">

                    <div class="mb-4" id="paymentOptions" style="display: none;">
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

                    <button type="submit" name="book_combo" class="btn btn-danger w-100 py-2 fw-bold fs-5 rounded-pill">
                        Đặt Combo Ngay
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const peopleInput = document.getElementById('total_people');
    const unitPrice = parseInt(document.getElementById('unit-price').getAttribute('data-price'), 10);
    const submitBtn = document.querySelector('button[name="book_combo"]');
    
    // We can show total price by injecting a new element
    const form = document.querySelector('form');
    const paymentOptions = document.getElementById('paymentOptions');
    paymentOptions.style.display = 'block'; // Show payment options when JS loads
    const voucherSection = document.getElementById('voucherSection');
    if (voucherSection) voucherSection.style.display = 'block';

    const discountDiv = document.createElement('div');
    discountDiv.className = 'd-flex justify-content-between mb-2 text-success';
    discountDiv.style.display = 'none';
    discountDiv.id = 'discount-row';
    discountDiv.innerHTML = `
        <span class="fw-bold">Giảm giá:</span>
        <span class="fw-bold" id="discount-display">0</span>
    `;
    form.insertBefore(discountDiv, paymentOptions);

    const totalDiv = document.createElement('div');
    totalDiv.className = 'd-flex justify-content-between align-items-end mb-4 pb-3 border-top pt-3';
    totalDiv.innerHTML = `
        <span class="fw-bold">Tổng tiền:</span>
        <span class="fs-4 fw-bold text-danger" id="total-price"></span>
    `;
    form.insertBefore(totalDiv, paymentOptions);
    
    const totalPriceEl = document.getElementById('total-price');

    const currencyFormat = "<?= $_SESSION['currency'] ?? 'VND' ?>";
    const exchangeRate = <?= isset($_SESSION['currency']) ? 
        ($_SESSION['currency'] == 'USD' ? 25000 : 
        ($_SESSION['currency'] == 'EUR' ? 27000 : 
        ($_SESSION['currency'] == 'JPY' ? 170 : 1))) : 1 ?>;
        
    function updateTotal() {
        let people = parseInt(peopleInput.value, 10);
        if (isNaN(people) || people < 1) people = 1;
        
        let rawTotalVND = people * unitPrice;
        let discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
        let finalTotalVND = rawTotalVND - discountAmount;
        if (finalTotalVND < 0) finalTotalVND = 0;

        if (discountAmount > 0) {
            document.getElementById('discount-row').style.display = 'flex';
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
            document.getElementById('discount-row').style.display = 'none';
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

            let people = parseInt(peopleInput.value, 10);
            if (isNaN(people) || people < 1) people = 1;
            let currentTotal = people * unitPrice;

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

    peopleInput.addEventListener('input', updateTotal);
    updateTotal(); // initial call
});
</script>

<?php include 'includes/footer.php'; ?>
