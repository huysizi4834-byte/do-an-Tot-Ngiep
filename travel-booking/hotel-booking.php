<?php
require 'includes/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    echo "<script>alert('Vui lòng đăng nhập để đặt phòng!'); window.location.href='login.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: hotels.php");
    exit;
}

$hotel_id = (int) $_GET['id'];
$sql = "SELECT * FROM hotels WHERE id = $hotel_id";
$result = mysqli_query($conn, $sql);
$hotel = mysqli_fetch_assoc($result);

if (!$hotel) {
    die("Khách sạn không tồn tại!");
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Thông tin nhập liệu -->
        <div class="col-md-8 mb-4">
            <h3 class="mb-4">Thông tin đặt phòng</h3>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="includes/hotel-process.php" method="POST" id="hotelBookingForm" enctype="multipart/form-data">
                        <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                        <input type="hidden" name="price_per_night" id="price_per_night"
                            value="<?= $hotel['price_per_night'] ?>">

                        <h5 class="fw-bold mb-3">1. Người đại diện đặt phòng</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Họ và tên</label>
                                <input type="text" name="guest_name" class="form-control"
                                    value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Số điện thoại liên hệ</label>
                                <input type="text" name="guest_phone" class="form-control"
                                    placeholder="Ví dụ: 0912345678" required>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-3">2. Chi tiết lưu trú</h5>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" class="form-control" required
                                    min="<?= date('Y-m-d') ?>" onchange="calculateTotal()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" class="form-control"
                                    required min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                    onchange="calculateTotal()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Số khách</label>
                                <select name="total_guests" id="total_guests" class="form-select" onchange="toggleVerification()">
                                    <option value="1">1 Người</option>
                                    <option value="2" selected>2 Người</option>
                                    <option value="3">3 Người</option>
                                    <option value="4">4 Người</option>
                                    <option value="5">5 Người</option>
                                    <option value="6">6 Người</option>
                                    <option value="7">7 Người</option>
                                    <option value="8">8 Người</option>
                                    <option value="9">9 Người</option>
                                    <option value="10">10 Người</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Yêu cầu đặc biệt (Không bắt buộc)</label>
                            <textarea name="special_requests" class="form-control" rows="3"
                                placeholder="Phòng không hút thuốc, tầng cao..."></textarea>
                        </div>

                        <div id="verificationSection" style="display: none;">
                            <h5 class="fw-bold mb-3">3. Xác minh danh tính</h5>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Ảnh CMND / CCCD (Mặt trước)</label>
                                    <input type="file" name="cccd_image" id="cccd_image" class="form-control" accept="image/*" onchange="handleCccdUpload()">
                                    <small class="text-danger d-block mb-2">Bắt buộc khi đặt phòng trên 4 người</small>
                                    
                                    <div id="cccd_preview_section" class="text-center bg-light p-2 rounded border" style="display: none;">
                                        <img id="cccd_preview" style="width: 100%; border-radius: 5px;" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Ảnh chụp khuôn mặt (Selfie) trực tiếp</label>
                                    <input type="hidden" name="face_image_base64" id="face_image_base64">
                                    <small class="text-danger d-block mb-2">Bắt buộc để xác thực người thật</small>
                                    <div id="camera_section" class="text-center bg-light p-2 rounded border">
                                        <video id="camera_stream" width="100%" autoplay playsinline style="border-radius: 5px;"></video>
                                        <canvas id="camera_canvas" style="display: none;"></canvas>
                                        <img id="camera_preview" style="display: none; width: 100%; border-radius: 5px;" />
                                        <button type="button" id="btn_capture" class="btn btn-info mt-2 w-100 text-white"><i class="fa-solid fa-camera me-2"></i>Chụp ảnh</button>
                                        <button type="button" id="btn_retake" class="btn btn-warning mt-2 w-100" style="display: none;"><i class="fa-solid fa-rotate-right me-2"></i>Chụp lại</button>
                                        
                                        <div class="mt-3 border-top pt-2">
                                            <span class="text-muted small">Hoặc tải ảnh có sẵn:</span>
                                            <input type="file" name="face_image" id="face_image" class="form-control mt-1" accept="image/*" onchange="handleFileUpload()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Voucher Section -->
                        <div class="mb-4 p-3 bg-light rounded border mt-4">
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
                        
                        <!-- Nút Tiếp tục ban đầu -->
                        <button type="button" class="btn btn-primary w-100 py-3 fw-bold fs-5 text-uppercase"
                            id="btnContinue" onclick="showPayment()" disabled>Xác nhận Đặt Phòng</button>

                        <!-- Phần Thanh toán (Bị ẩn lúc đầu) -->
                        <div id="paymentSection" style="display: none;" class="mt-4 p-4 border rounded bg-light">
                            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-credit-card me-2"></i>Chọn phương thức thanh toán</h5>
                            
                            <div class="form-check mb-3 p-3 border rounded bg-white">
                                <input class="form-check-input ms-1" type="radio" name="payment_type" id="pay_full" value="full" checked>
                                <label class="form-check-label fw-bold ms-2" for="pay_full">
                                    Thanh toán toàn bộ: <span class="text-danger fs-5" id="label_pay_full">0 ₫</span>
                                </label>
                                <div class="text-muted small ms-2 mt-1">Thanh toán 100% để giữ phòng chắc chắn nhất.</div>
                            </div>

                            <div class="form-check mb-4 p-3 border rounded bg-white">
                                <input class="form-check-input ms-1" type="radio" name="payment_type" id="pay_deposit" value="deposit">
                                <label class="form-check-label fw-bold ms-2" for="pay_deposit">
                                    Đặt cọc (50%): <span class="text-danger fs-5" id="label_pay_deposit">0 ₫</span>
                                </label>
                                <div class="text-muted small ms-2 mt-1">Thanh toán trước 50%, phần còn lại thanh toán khi check-in.</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5 text-uppercase" id="btnSubmit">Hoàn tất Thanh Toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cột tóm tắt khách sạn -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <img src="<?= htmlspecialchars($hotel['thumbnail']) ?>" class="card-img-top"
                    style="height: 180px; object-fit: cover;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($hotel['name']) ?></h5>
                    <div class="mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-solid fa-star <?= $i <= $hotel['star_rating'] ? 'text-warning' : 'text-muted' ?>"
                                style="font-size: 0.8rem;"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-muted small mb-4"><i class="fa-solid fa-location-dot me-1"></i>
                        <?= htmlspecialchars($hotel['address']) ?></p>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Giá mỗi đêm:</span>
                        <span class="text-dark"><?= formatPrice($hotel['price_per_night']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Số đêm lưu trú:</span>
                        <span class="text-dark fw-bold" id="summary_nights">0 đêm</span>
                    </div>
                    <div id="discount-display" class="text-success small mb-2 text-end" style="display: none;"></div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold">Tổng tiền:</span>
                        <span class="fs-4 fw-bold text-danger" id="summary_total"><?= formatPrice($hotel['price_per_night']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
<script>
    window.isFaceApiLoaded = false;
    async function loadFaceModels() {
        try {
            await faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/');
            window.isFaceApiLoaded = true;
            console.log("AI Models loaded for validation");
        } catch(e) {
            console.error("Lỗi tải AI Model:", e);
        }
    }

    function calculateTotal() {
        let checkIn = document.getElementById('check_in_date').value;
        let checkOut = document.getElementById('check_out_date').value;
        let pricePerNight = parseInt(document.getElementById('price_per_night').value);
        let btnContinue = document.getElementById('btnContinue');

        if (checkIn && checkOut) {
            let date1 = new Date(checkIn);
            let date2 = new Date(checkOut);

            let diffTime = date2 - date1;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                let totalNights = diffDays;
                document.getElementById('summary_nights').innerText = totalNights + ' đêm';
                
                // Tính toán tổng tiền
                const currencyFormat = "<?= $_SESSION['currency'] ?? 'VND' ?>";
                const exchangeRate = <?= isset($_SESSION['currency']) ? 
                    ($_SESSION['currency'] == 'USD' ? 25000 : 
                    ($_SESSION['currency'] == 'EUR' ? 27000 : 
                    ($_SESSION['currency'] == 'JPY' ? 170 : 1))) : 1 ?>;

                let rawTotalVND = pricePerNight * totalNights;
                let currentDiscount = parseFloat(document.getElementById('discount_amount').value) || 0;
                let finalTotalVND = rawTotalVND - currentDiscount;
                if (finalTotalVND < 0) finalTotalVND = 0;

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

                document.getElementById('summary_total').innerText = formattedTotal;
                
                // Cập nhật số tiền thanh toán
                let total = finalTotalVND;
                document.getElementById('label_pay_full').innerText = total.toLocaleString('vi-VN') + ' ₫';
                document.getElementById('label_pay_deposit').innerText = (total / 2).toLocaleString('vi-VN') + ' ₫';

                btnContinue.disabled = false;
            } else {
                document.getElementById('summary_nights').innerText = '0 đêm';
                document.getElementById('summary_total').innerText = 'Lỗi ngày!';
                btnContinue.disabled = true;
            }
        }
    }

    function showPayment() {
        // Kiểm tra HTML5 validation trước khi hiện form thanh toán
        let form = document.getElementById('hotelBookingForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        document.getElementById('btnContinue').style.display = 'none';
        document.getElementById('paymentSection').style.display = 'block';
    }

    // Hỗ trợ Camera thật (WebRTC) và Camera mô phỏng fallback
    let useMockCamera = false;
    let localStream = null;

    async function startCamera() {
        const video = document.getElementById('camera_stream');
        const canvas = document.getElementById('camera_canvas');
        useMockCamera = false;

        try {
            localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            video.srcObject = localStream;
            video.style.display = 'block';
            canvas.style.display = 'none';
        } catch (err) {
            console.warn("Không mở được camera thật (chuyển sang mô phỏng):", err);
            useMockCamera = true;
            video.style.display = 'none';
            canvas.style.display = 'block';
            canvas.style.margin = '0 auto';
            canvas.width = 400;
            canvas.height = 300;
            
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#e9ecef';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#495057';
            ctx.font = 'bold 20px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('Camera Mô Phỏng (Đang bật...)', canvas.width/2, 50);
            
            ctx.beginPath();
            ctx.arc(canvas.width/2, 140, 50, 0, Math.PI * 2, true); // Đầu
            ctx.fillStyle = '#adb5bd';
            ctx.fill();
            ctx.stroke();
            
            ctx.beginPath();
            ctx.arc(canvas.width/2, 280, 80, Math.PI, 0, false); // Thân
            ctx.fill();
            ctx.stroke();
        }
    }

    function stopCamera() {
        const video = document.getElementById('camera_stream');
        const canvas = document.getElementById('camera_canvas');
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
        video.srcObject = null;
        video.style.display = 'none';
        canvas.style.display = 'none';
    }

    document.getElementById('btn_capture').addEventListener('click', async () => {
        const video = document.getElementById('camera_stream');
        const canvas = document.getElementById('camera_canvas');
        const previewImg = document.getElementById('camera_preview');
        
        let dataUrl = '';
        if (useMockCamera) {
            dataUrl = canvas.toDataURL('image/jpeg');
        } else {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = video.videoWidth || 640;
            tempCanvas.height = video.videoHeight || 480;
            const ctx = tempCanvas.getContext('2d');
            ctx.drawImage(video, 0, 0, tempCanvas.width, tempCanvas.height);
            dataUrl = tempCanvas.toDataURL('image/jpeg');
        }
        
        document.getElementById('face_image_base64').value = dataUrl;
        
        previewImg.onload = async function() {
            if (!useMockCamera && window.isFaceApiLoaded) {
                const btnCapture = document.getElementById('btn_capture');
                const oldHTML = btnCapture.innerHTML;
                btnCapture.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang quét AI...';
                
                const detection = await faceapi.detectSingleFace(previewImg, new faceapi.TinyFaceDetectorOptions());
                
                if (!detection) {
                    alert("AI Cảnh báo: Không tìm thấy khuôn mặt trong ảnh chụp! Vui lòng chụp lại rõ khuôn mặt của bạn.");
                    document.getElementById('btn_retake').click();
                    btnCapture.innerHTML = oldHTML;
                    return;
                }
                btnCapture.innerHTML = oldHTML;
                document.getElementById('btn_capture').style.display = 'none';
                document.getElementById('btn_retake').style.display = 'block';
            } else {
                document.getElementById('btn_capture').style.display = 'none';
                document.getElementById('btn_retake').style.display = 'block';
            }
        };
        
        previewImg.src = dataUrl;
        previewImg.style.display = 'block';
        video.style.display = 'none';
        canvas.style.display = 'none';
    });

    document.getElementById('btn_retake').addEventListener('click', () => {
        document.getElementById('face_image_base64').value = '';
        document.getElementById('camera_preview').style.display = 'none';
        if (useMockCamera) {
            document.getElementById('camera_canvas').style.display = 'block';
        } else {
            document.getElementById('camera_stream').style.display = 'block';
        }
        document.getElementById('btn_capture').style.display = 'block';
        document.getElementById('btn_retake').style.display = 'none';
        document.getElementById('face_image').value = "";
    });

    function handleFileUpload() {
        const fileInput = document.getElementById('face_image');
        const preview = document.getElementById('camera_preview');
        const canvas = document.getElementById('camera_canvas');
        const btnCapture = document.getElementById('btn_capture');
        const btnRetake = document.getElementById('btn_retake');
        
        // Reset base64 từ camera
        document.getElementById('face_image_base64').value = '';

        if (fileInput.files && fileInput.files[0]) {
            // Nếu có file được chọn -> Hiển thị ảnh và ẩn camera
            const reader = new FileReader();
            
            preview.onload = async function() {
                if (window.isFaceApiLoaded) {
                    const detection = await faceapi.detectSingleFace(preview, new faceapi.TinyFaceDetectorOptions());
                    if (!detection) {
                        alert("AI Cảnh báo: Không tìm thấy khuôn mặt người thực trong ảnh tải lên! Vui lòng chọn ảnh Selfie thật của bạn.");
                        fileInput.value = "";
                        preview.src = "";
                        preview.style.display = 'none';
                        canvas.style.display = 'block';
                        btnCapture.style.display = 'block';
                    }
                }
            };
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                canvas.style.display = 'none';
                btnCapture.style.display = 'none';
                btnRetake.style.display = 'none';
            }
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            // Nếu hủy chọn file -> Quay về camera mô phỏng
            preview.style.display = 'none';
            preview.src = '';
            canvas.style.display = 'block';
            btnCapture.style.display = 'block';
            btnRetake.style.display = 'none';
        }
    }

    function handleCccdUpload() {
        const cccdInput = document.getElementById('cccd_image');
        const cccdPreviewSection = document.getElementById('cccd_preview_section');
        const cccdPreview = document.getElementById('cccd_preview');

        if (cccdInput.files && cccdInput.files[0]) {
            const reader = new FileReader();
            
            cccdPreview.onload = async function() {
                if (window.isFaceApiLoaded) {
                    const detection = await faceapi.detectSingleFace(cccdPreview, new faceapi.TinyFaceDetectorOptions());
                    if (!detection) {
                        alert("AI Cảnh báo: Hình như đây không phải là mặt trước CCCD/CMND! Không tìm thấy ảnh thẻ (khuôn mặt) trên giấy tờ. Vui lòng chụp lại rõ ràng hơn.");
                        cccdInput.value = "";
                        cccdPreview.src = "";
                        cccdPreviewSection.style.display = 'none';
                    }
                }
            };
            
            reader.onload = function(e) {
                cccdPreview.src = e.target.result;
                cccdPreviewSection.style.display = 'block';
            }
            reader.readAsDataURL(cccdInput.files[0]);
        } else {
            cccdPreview.src = '';
            cccdPreviewSection.style.display = 'none';
        }
    }

    function toggleVerification() {
        let guests = parseInt(document.getElementById('total_guests').value);
        let section = document.getElementById('verificationSection');
        let cccd = document.getElementById('cccd_image');
        let faceBase64 = document.getElementById('face_image_base64');
        
        let cccdPreviewSection = document.getElementById('cccd_preview_section');
        let cccdPreview = document.getElementById('cccd_preview');
        
        if (guests > 4) {
            section.style.display = 'block';
            cccd.required = true;
            startCamera();
        } else {
            section.style.display = 'none';
            cccd.required = false;
            cccd.value = ""; 
            faceBase64.value = "";
            cccdPreview.src = "";
            cccdPreviewSection.style.display = 'none';
            stopCamera();
        }
    }
    
    // Gọi một lần lúc load trang
    document.addEventListener("DOMContentLoaded", function() {
        toggleVerification();
        loadFaceModels();

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

                // Tính tổng tiền gốc
                let checkIn = document.getElementById('check_in_date').value;
                let checkOut = document.getElementById('check_out_date').value;
                let pricePerNight = parseInt(document.getElementById('price_per_night').value);
                let currentTotal = 0;
                if (checkIn && checkOut) {
                    let date1 = new Date(checkIn);
                    let date2 = new Date(checkOut);
                    let diffTime = date2 - date1;
                    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    if (diffDays > 0) {
                        currentTotal = diffDays * pricePerNight;
                    }
                }

                if (currentTotal <= 0) {
                    msgDiv.innerHTML = '<span class="text-danger">Vui lòng chọn ngày lưu trú hợp lệ.</span>';
                    return;
                }

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
                        
                        const formattedDiscount = new Intl.NumberFormat('vi-VN').format(data.discount_amount) + ' ₫';
                        const discDisplay = document.getElementById('discount-display');
                        if (discDisplay) {
                            discDisplay.innerText = '- Giảm: ' + formattedDiscount;
                            discDisplay.style.display = 'block';
                        }
                        calculateTotal();
                    } else {
                        msgDiv.innerHTML = '<span class="text-danger">' + data.message + '</span>';
                        document.getElementById('promotion_id').value = '';
                        document.getElementById('discount_amount').value = 0;
                        const discDisplay = document.getElementById('discount-display');
                        if (discDisplay) {
                            discDisplay.style.display = 'none';
                        }
                        calculateTotal();
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