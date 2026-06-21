<?php
require 'includes/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Lưu lại URL đang xem để sau khi login quay lại
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    echo "<script>alert('Vui lòng đăng nhập để đặt vé!'); window.location.href='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: flights.php");
    exit;
}

$flight_id = (int) $_GET['id'];
$sql = "SELECT * FROM flights WHERE id = $flight_id";
$result = mysqli_query($conn, $sql);
$flight = mysqli_fetch_assoc($result);

if (!$flight) {
    die("Chuyến bay không tồn tại!");
}

$total_passengers_get = isset($_GET['total_passengers']) ? (int)$_GET['total_passengers'] : 1;
$total_passengers_get = max(1, min(5, $total_passengers_get));

include 'includes/header.php';
?>

<div class="container py-5">
    <!-- Danh sách Voucher -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3"><i class="fas fa-gift text-danger"></i> Đặt vé trên web, nhận ngay mã giảm giá!</h4>
        <div class="d-flex gap-3 overflow-auto pb-2 voucher-scroll" style="white-space: nowrap;">
            <!-- Voucher 1 -->
            <div class="card border border-primary shadow-sm flex-shrink-0" style="width: 320px; border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-danger rounded-pill px-3 py-1">Sắp hết mã</span>
                        <small class="text-muted fw-bold"><i class="fas fa-clock"></i> HSD: Hôm nay</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 fs-5">Giảm 10% Vé Máy Bay</h6>
                    <p class="small text-muted mb-3 text-wrap" style="height: 40px; line-height: 1.4;">Tối đa giao dịch 3 triệu đồng, không giới hạn khung giờ.</p>
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded border border-dashed border-primary">
                        <span class="fw-bold font-monospace fs-6 text-primary" id="v_code1">GIAM10</span>
                        <button type="button" class="btn btn-sm btn-primary fw-bold px-3 rounded-pill" onclick="copyAndApply('v_code1')">Copy & Dùng</button>
                    </div>
                </div>
            </div>
            <!-- Voucher 2 -->
            <div class="card border border-success shadow-sm flex-shrink-0" style="width: 320px; border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-danger rounded-pill px-3 py-1">Sắp hết mã</span>
                        <small class="text-muted fw-bold"><i class="fas fa-clock"></i> HSD: 31/12</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 fs-5">Giảm 20% VIP/Visa</h6>
                    <p class="small text-muted mb-3 text-wrap" style="height: 40px; line-height: 1.4;">Tối thiểu giao dịch 4 triệu sử dụng thẻ Visa/MasterCard.</p>
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded border border-dashed border-success">
                        <span class="fw-bold font-monospace fs-6 text-success" id="v_code2">GIAM20</span>
                        <button type="button" class="btn btn-sm btn-success fw-bold px-3 rounded-pill" onclick="copyAndApply('v_code2')">Copy & Dùng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .voucher-scroll::-webkit-scrollbar { height: 8px; }
        .voucher-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        .border-dashed { border-style: dashed !important; }
    </style>

    <div class="row">
        <!-- Cột form nhập liệu -->
        <div class="col-md-8 mb-4">
            <h3 class="mb-4">Thông tin hành khách</h3>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="includes/flight-process.php" method="POST" id="flightBookingForm">
                        <input type="hidden" name="flight_id" value="<?= $flight['id'] ?>">
                        <input type="hidden" name="price_per_ticket" id="price_per_ticket"
                            value="<?= $flight['price'] ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Người đặt vé (Liên hệ)</label>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>" disabled>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Số lượng hành khách</label>
                            <select class="form-select w-50" name="total_passengers" id="total_passengers"
                                onchange="updateTotal()">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $total_passengers_get ? 'selected' : '' ?>><?= $i ?> Hành khách</option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div id="passenger_details_container">
                            <div class="mb-3 passenger-row">
                                <label class="form-label text-muted">Họ và tên hành khách 1</label>
                                <input type="text" name="passenger_names[]" class="form-control"
                                    placeholder="VD: NGUYEN VAN A" required>
                            </div>
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

                        <hr class="my-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5 text-uppercase">Xác nhận
                            Đặt Vé</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cột tóm tắt chuyến bay -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Tóm tắt chuyến bay</h5>

                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= htmlspecialchars($flight['thumbnail']) ?>" alt="Logo" width="40" class="me-3">
                        <div>
                            <div class="fw-bold"><?= htmlspecialchars($flight['airline']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($flight['flight_number']) ?></small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Khởi hành:</span>
                        <span class="fw-bold"><?= htmlspecialchars($flight['departure_city']) ?></span>
                    </div>
                    <div class="text-end text-muted small mb-3">
                        <?= date('H:i - d/m/Y', strtotime($flight['departure_time'])) ?>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Điểm đến:</span>
                        <span class="fw-bold"><?= htmlspecialchars($flight['arrival_city']) ?></span>
                    </div>
                    <div class="text-end text-muted small mb-4 border-bottom pb-3">
                        <?= date('H:i - d/m/Y', strtotime($flight['arrival_time'])) ?>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Giá 1 vé:</span>
                        <span class="text-dark"><?= formatPrice($flight['price']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Số lượng:</span>
                        <span class="text-dark" id="summary_passengers">1</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 d-none" id="discount_row">
                        <span>Giảm giá:</span>
                        <span class="text-success fw-bold" id="summary_discount">0</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold">Tổng tiền:</span>
                        <span class="fs-4 fw-bold text-danger" id="summary_total"><?= formatPrice($flight['price']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateTotal();
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

                let passengers = parseInt(document.getElementById('total_passengers').value);
                let pricePerTicket = parseInt(document.getElementById('price_per_ticket').value);
                let currentTotal = passengers * pricePerTicket;

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

    function copyAndApply(elementId) {
        let textToCopy = document.getElementById(elementId).innerText.trim();
        let discountInput = document.getElementById('voucher_code');
        
        discountInput.value = textToCopy;
        discountInput.style.transition = "box-shadow 0.3s ease-in-out";
        discountInput.style.boxShadow = "0 0 0 0.25rem rgba(13, 110, 253, 0.25)";
        setTimeout(() => discountInput.style.boxShadow = "none", 1500);

        document.getElementById('btn-apply-voucher').click();
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(textToCopy).catch(err => console.error("Clipboard err: ", err));
        }
    }

    function formatMoney(amount, currencyFormat) {
        if(currencyFormat === 'VND') {
            return new Intl.NumberFormat('vi-VN').format(amount) + ' ₫';
        } else if(currencyFormat === 'USD') {
            return '$' + new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(amount);
        } else if(currencyFormat === 'EUR') {
            return '€' + new Intl.NumberFormat('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(amount);
        } else if(currencyFormat === 'JPY') {
            return '¥' + new Intl.NumberFormat('ja-JP').format(amount);
        }
        return amount;
    }

    function updateTotal() {
        let passengers = parseInt(document.getElementById('total_passengers').value);
        let pricePerTicket = parseInt(document.getElementById('price_per_ticket').value);

        // Update summary texts
        document.getElementById('summary_passengers').innerText = passengers;
        
        const currencyFormat = "<?= $_SESSION['currency'] ?? 'VND' ?>";
        const exchangeRate = <?= isset($_SESSION['currency']) ? 
            ($_SESSION['currency'] == 'USD' ? 25000 : 
            ($_SESSION['currency'] == 'EUR' ? 27000 : 
            ($_SESSION['currency'] == 'JPY' ? 170 : 1))) : 1 ?>;
            
        let rawTotalVND = passengers * pricePerTicket;
        let discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
        let finalTotalVND = rawTotalVND - discountAmount;
        if (finalTotalVND < 0) finalTotalVND = 0;

        // Show/hide discount row
        if (discountAmount > 0) {
            document.getElementById('discount_row').classList.remove('d-none');
            let convertedDiscount = discountAmount / exchangeRate;
            document.getElementById('summary_discount').textContent = '-' + formatMoney(convertedDiscount, currencyFormat);
        } else {
            document.getElementById('discount_row').classList.add('d-none');
        }

        let convertedTotal = finalTotalVND / exchangeRate;
        document.getElementById('summary_total').textContent = formatMoney(convertedTotal, currencyFormat);
        
        // Update passenger input fields
        let container = document.getElementById('passenger_details_container');
        container.innerHTML = ''; // Clear existing
        for (let i = 1; i <= passengers; i++) {
            container.innerHTML += `
            <div class="mb-3 passenger-row">
                <label class="form-label text-muted">Họ và tên hành khách ${i}</label>
                <input type="text" name="passenger_names[]" class="form-control" placeholder="Hành khách ${i}" required>
            </div>
        `;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>