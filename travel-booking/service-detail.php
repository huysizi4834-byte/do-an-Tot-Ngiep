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
});
</script>

<?php include 'includes/footer.php'; ?>
