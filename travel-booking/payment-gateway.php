<?php
require 'includes/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['code'])) {
    die("Mã đơn hàng không hợp lệ.");
}

$code = mysqli_real_escape_string($conn, $_GET['code']);
$user_id = $_SESSION['user_id'];

// Get user face descriptor
$user_query = mysqli_query($conn, "SELECT face_descriptor FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);
$face_descriptor = $user_data['face_descriptor'];

$prefix = substr($code, 0, 2);
$sql = "";

if ($prefix === 'HT') {
    $sql = "SELECT hb.*, h.name as item_name, h.city as location FROM hotel_bookings hb JOIN hotels h ON hb.hotel_id = h.id WHERE hb.booking_code = '$code' AND hb.user_id = '$user_id'";
} elseif ($prefix === 'FL') {
    $sql = "SELECT fb.*, CONCAT(f.airline, ' - ', f.flight_number) as item_name, CONCAT(f.departure_city, ' -> ', f.arrival_city) as location FROM flight_bookings fb JOIN flights f ON fb.flight_id = f.id WHERE fb.booking_code = '$code' AND fb.user_id = '$user_id'";
} elseif ($prefix === 'TR') {
    $sql = "SELECT b.*, t.title as item_name, 'Tour du lịch' as location FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.booking_code = '$code' AND b.user_id = '$user_id'";
} elseif ($prefix === 'SV') {
    $sql = "SELECT sb.*, s.name as item_name, 'Dịch vụ cộng thêm' as location FROM service_bookings sb JOIN additional_services s ON sb.service_id = s.id WHERE sb.booking_code = '$code' AND sb.user_id = '$user_id'";
} elseif ($prefix === 'CB') {
    $sql = "SELECT cb.*, c.name as item_name, c.duration as location FROM combo_bookings cb JOIN combos c ON cb.combo_id = c.id WHERE cb.booking_code = '$code' AND cb.user_id = '$user_id'";
} else {
    die("Loại đơn hàng không hỗ trợ thanh toán trực tuyến.");
}

$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Không tìm thấy thông tin đơn hàng.");
}

$qty = 0;
if ($prefix === 'HT') $qty = $booking['total_guests'];
elseif ($prefix === 'FL') $qty = $booking['total_passengers'];
elseif ($prefix === 'TR') $qty = $booking['total_people'];
elseif ($prefix === 'SV') $qty = $booking['quantity'];
elseif ($prefix === 'CB') $qty = $booking['total_people'];

if ($booking['payment_status'] == 'paid') {
    die("Đơn hàng này đã được thanh toán.");
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="bg-primary text-white p-4 text-center">
                    <h3 class="mb-0"><i class="fa-solid fa-shield-halved me-2"></i>Cổng Thanh Toán An Toàn</h3>
                </div>
                
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h5 class="text-muted">Mã đơn hàng: <strong class="text-dark">#<?= htmlspecialchars($booking['booking_code']) ?></strong></h5>
                        <h2 class="text-danger fw-bold display-5 my-3"><?= formatPrice($booking['amount_paid']) ?></h2>
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6 rounded-pill">
                            <?= $booking['payment_type'] == 'deposit' ? 'Đặt cọc 50%' : 'Thanh toán 100%' ?>
                        </span>
                    </div>

                    <hr class="mb-4">

                    <h5 class="fw-bold mb-3">Chọn phương thức thanh toán</h5>
                    <form action="includes/process-payment.php" method="POST" id="paymentForm">
                        <input type="hidden" name="txn_code" autocomplete="off" value="<?= htmlspecialchars($booking['booking_code']) ?>">
                        <input type="hidden" name="face_verified" id="face_verified" value="0">
                        <input type="hidden" name="payment_face_image_b64" id="payment_face_image_b64" value="">

                        <?php if ($qty > 5): ?>
                            <div class="alert alert-warning mb-4">
                                <h6 class="fw-bold mb-2"><i class="fa-solid fa-users me-2"></i>Thông tin trưởng đoàn bắt buộc</h6>
                                <p class="small mb-3">Do nhóm của bạn có trên 5 người (Tổng: <?= $qty ?> người), theo quy định cần cung cấp thông tin người đại diện và CCCD.</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Họ tên Người đại diện</label>
                                        <input type="text" name="representative_name" class="form-control" required placeholder="Nhập họ tên...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Số CCCD / Hộ chiếu</label>
                                        <input type="text" name="cccd" class="form-control" required placeholder="Nhập số CCCD...">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="list-group mb-4">
                            <!-- QR Code -->
                            <label class="list-group-item p-3 payment-option" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-3" type="radio" name="payment_method" value="qr_code" onchange="toggleQR()" checked>
                                    <i class="fa-solid fa-qrcode fa-2x text-primary me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">Quét mã QR (ZaloPay / MoMo)</h6>
                                        <small class="text-muted">Mở ứng dụng quét mã để thanh toán nhanh chóng</small>
                                    </div>
                                </div>
                                
                                <!-- Box chứa mã QR (Sẽ hiện khi chọn QR) -->
                                <div id="qrBox" class="text-center mt-4 mb-2 p-3 bg-light rounded border">
                                    <p class="fw-bold text-primary mb-2">Quét mã QR bên dưới bằng ứng dụng MoMo / ZaloPay</p>
                                    <?php 
                                        // Tạo nội dung QR giả có mã đơn hàng và số tiền
                                        $qr_data = urlencode("Thanh toan don hang: " . $booking['booking_code'] . " - So tien: " . number_format($booking['amount_paid']) . " VND"); 
                                    ?>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $qr_data ?>" class="img-thumbnail shadow-sm mb-3" alt="QR Code">
                                    <p class="small text-danger fst-italic mb-0">* Đây là mã QR giả lập thử nghiệm.</p>
                                </div>
                            </label>

                            <!-- Thẻ ngân hàng -->
                            <label class="list-group-item d-flex align-items-center p-3 payment-option" style="cursor: pointer;">
                                <input class="form-check-input me-3" type="radio" name="payment_method" value="credit_card" onchange="toggleQR()">
                                <i class="fa-brands fa-cc-visa text-primary fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Thẻ ngân hàng (Visa / MasterCard / ATM)</h6>
                                    <small class="text-muted">Nhập thông tin thẻ của bạn</small>
                                </div>
                            </label>

                            <!-- Internet Banking -->
                            <label class="list-group-item d-flex align-items-center p-3 payment-option" style="cursor: pointer;">
                                <input class="form-check-input me-3" type="radio" name="payment_method" value="internet_banking" onchange="toggleQR()">
                                <i class="fa-solid fa-building-columns text-success fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Internet Banking</h6>
                                    <small class="text-muted">Chuyển khoản trực tuyến qua ngân hàng</small>
                                </div>
                            </label>

                            <!-- BNPL -->
                            <label class="list-group-item d-flex align-items-center p-3 payment-option" style="cursor: pointer;">
                                <input class="form-check-input me-3" type="radio" name="payment_method" value="bnpl" onchange="toggleQR()">
                                <i class="fa-solid fa-hand-holding-dollar text-warning fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">Trả sau (Buy Now Pay Later)</h6>
                                    <small class="text-muted">Mua trước, trả tiền sau qua đối tác Kredivo / SPayLater</small>
                                </div>
                            </label>
                        </div>

                        <div class="mb-4" id="passwordGroup">
                            <label class="form-label fw-bold">Nhập mật khẩu tài khoản để xác nhận thanh toán</label>
                            <input type="password" name="password" id="paymentPassword" class="form-control form-control-lg" placeholder="Mật khẩu của bạn...">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" id="normalSubmitBtn" class="btn btn-primary py-3 fw-bold fs-5 rounded-pill shadow" onclick="return checkPasswordOrFace()">
                                <i class="fa-solid fa-lock me-2"></i> Xác nhận Thanh toán
                            </button>
                            
                            <?php if (!empty($face_descriptor)): ?>
                            <button type="button" id="faceAuthBtn" class="btn btn-outline-success py-2 fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#faceAuthModal">
                                <i class="fa-solid fa-face-viewfinder me-2"></i> Xác thực bằng Khuôn mặt (Face ID)
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3 text-muted">
                <i class="fa-solid fa-shield-cat"></i> Thanh toán được bảo mật chuẩn SSL 256-bit.
            </div>
        </div>
    </div>
</div>

<?php if (!empty($face_descriptor)): ?>
<!-- Face ID Modal -->
<div class="modal fade" id="faceAuthModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa-solid fa-face-viewfinder me-2"></i>Xác Thực Khuôn Mặt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeFaceModalBtn" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center position-relative">
                <div id="faceLoading" class="mb-3">
                    <div class="spinner-border text-success mb-2" role="status"></div>
                    <p class="mb-0">Đang bật Camera & tải mô hình AI...</p>
                </div>
                
                <div class="position-relative d-inline-block rounded overflow-hidden shadow-sm" style="width:100%; max-width:400px; min-height: 300px; background: #000;">
                    <video id="faceVideo" width="400" height="300" autoplay muted playsinline class="z-1" style="display: none; width: 100%; height: auto;"></video>
                    <canvas id="faceOverlay" class="position-absolute top-0 start-0 z-2" style="width: 100%; height: 100%; pointer-events: none;"></canvas>
                    <img id="faceUploadedImg" class="z-1 position-relative" style="display:none; width: 100%; height: auto;">
                </div>
                
                <p id="faceStatusMsg" class="mt-3 fw-bold fs-5 text-muted">Vui lòng nhìn thẳng vào Camera</p>
                
                <hr>
                <div class="text-start bg-light p-3 rounded">
                    <p class="mb-2 fw-bold text-secondary text-center"><i class="fa-solid fa-circle-info me-1"></i> Quét ảnh giả lập (Webcam hỏng?)</p>
                    <div class="input-group input-group-sm">
                        <input type="file" class="form-control" id="faceImageUpload" accept="image/*">
                        <button class="btn btn-outline-success" type="button" id="faceUploadBtn" disabled><i class="fa-solid fa-upload me-1"></i> Quét</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const faceAuthModal = document.getElementById('faceAuthModal');
    if (!faceAuthModal) return;

    const video = document.getElementById('faceVideo');
    const overlay = document.getElementById('faceOverlay');
    const loading = document.getElementById('faceLoading');
    const statusMsg = document.getElementById('faceStatusMsg');
    const closeBtn = document.getElementById('closeFaceModalBtn');
    
    const faceImageUpload = document.getElementById('faceImageUpload');
    const faceUploadBtn = document.getElementById('faceUploadBtn');
    const faceUploadedImg = document.getElementById('faceUploadedImg');
    
    // Parse stored descriptor from DB
    const storedDescriptorArray = <?php echo $face_descriptor; ?>;
    const storedDescriptor = new Float32Array(storedDescriptorArray);
    
    let stream = null;
    let detectionInterval = null;
    let isVerifying = false;

    faceAuthModal.addEventListener('shown.bs.modal', async () => {
        statusMsg.className = "mt-3 fw-bold fs-5 text-muted";
        statusMsg.innerText = "Đang khởi tạo...";
        loading.style.display = 'block';
        video.style.display = 'none';
        faceUploadedImg.style.display = 'none';
        isVerifying = false;

        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/';
        try {
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
            ]);
            
            faceUploadBtn.disabled = false;
            
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            
            video.onplay = () => {
                loading.style.display = 'none';
                video.style.display = 'block';
                const displaySize = { width: video.width, height: video.height };
                faceapi.matchDimensions(overlay, displaySize);
                
                statusMsg.innerText = "Vui lòng nhìn thẳng vào Camera";
                
                detectionInterval = setInterval(async () => {
                    if (isVerifying) return;

                    const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
                    
                    const ctx = overlay.getContext('2d');
                    ctx.clearRect(0, 0, overlay.width, overlay.height);
                    
                    if (detection) {
                        const resizedDetection = faceapi.resizeResults(detection, displaySize);
                        faceapi.draw.drawDetections(overlay, resizedDetection);
                        
                        // Compare faces
                        const distance = faceapi.euclideanDistance(storedDescriptor, detection.descriptor);
                        if (distance < 0.5) { // Match!
                            isVerifying = true;
                            statusMsg.className = "mt-3 fw-bold fs-4 text-success";
                            statusMsg.innerHTML = "<i class='fa-solid fa-check-circle'></i> Xác thực thành công!";
                            clearInterval(detectionInterval);
                            
                            setTimeout(() => {
                                // Capture face snapshot
                                const canvas = document.createElement('canvas');
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                canvas.getContext('2d').drawImage(video, 0, 0);
                                document.getElementById('payment_face_image_b64').value = canvas.toDataURL('image/jpeg', 0.8);
                                document.getElementById('face_verified').value = '1';
                                
                                stopCamera();
                                const form = document.getElementById('paymentForm');
                                if (form.checkValidity()) {
                                    form.submit();
                                } else {
                                    faceAuthModalObj.hide();
                                    form.reportValidity();
                                }
                            }, 1500);
                        } else {
                            statusMsg.className = "mt-3 fw-bold fs-6 text-danger";
                            statusMsg.innerText = "Khuôn mặt không khớp. Vui lòng thử lại.";
                        }
                    }
                }, 500);
            };
        } catch (err) {
            console.error(err);
            statusMsg.className = "mt-3 fw-bold text-danger";
            statusMsg.innerText = "Lỗi Camera hoặc AI Model!";
        }
    });

    faceUploadBtn.addEventListener('click', async () => {
        if (!faceImageUpload.files || faceImageUpload.files.length === 0) {
            alert('Vui lòng chọn một file ảnh trước!');
            return;
        }
        
        faceUploadBtn.disabled = true;
        statusMsg.className = "mt-3 fw-bold fs-5 text-warning";
        statusMsg.innerText = "Đang phân tích ảnh...";
        loading.style.display = 'block';
        
        stopCamera();
        video.style.display = 'none';
        
        const file = faceImageUpload.files[0];
        const reader = new FileReader();
        reader.onload = async (e) => {
            faceUploadedImg.src = e.target.result;
            faceUploadedImg.onload = async () => {
                faceUploadedImg.style.display = 'block';
                loading.style.display = 'none';
                
                const detection = await faceapi.detectSingleFace(faceUploadedImg, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
                
                if (!detection) {
                    statusMsg.className = "mt-3 fw-bold fs-6 text-danger";
                    statusMsg.innerText = "Không tìm thấy khuôn mặt nào trong ảnh!";
                    faceUploadBtn.disabled = false;
                    return;
                }
                
                const distance = faceapi.euclideanDistance(storedDescriptor, detection.descriptor);
                if (distance < 0.5) {
                    statusMsg.className = "mt-3 fw-bold fs-4 text-success";
                    statusMsg.innerHTML = "<i class='fa-solid fa-check-circle'></i> Xác thực thành công!";
                    setTimeout(() => {
                        const canvas = document.createElement('canvas');
                        canvas.width = faceUploadedImg.naturalWidth;
                        canvas.height = faceUploadedImg.naturalHeight;
                        canvas.getContext('2d').drawImage(faceUploadedImg, 0, 0);
                        document.getElementById('payment_face_image_b64').value = canvas.toDataURL('image/jpeg', 0.8);
                        document.getElementById('face_verified').value = '1';
                        
                        const form = document.getElementById('paymentForm');
                        if (form.checkValidity()) {
                            form.submit();
                        } else {
                            faceAuthModalObj.hide();
                            form.reportValidity();
                        }
                    }, 1500);
                } else {
                    statusMsg.className = "mt-3 fw-bold fs-6 text-danger";
                    statusMsg.innerText = "Khuôn mặt không khớp. Vui lòng thử lại.";
                    faceUploadBtn.disabled = false;
                }
            };
        };
        reader.readAsDataURL(file);
    });

    faceAuthModal.addEventListener('hidden.bs.modal', stopCamera);

    function stopCamera() {
        if (detectionInterval) clearInterval(detectionInterval);
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
    }
});
</script>
<?php endif; ?>

<style>
.payment-option:hover { background-color: #f8f9fa; }
.payment-option input[type="radio"]:checked { background-color: #0d6efd; border-color: #0d6efd; }
</style>

<script>
function toggleQR() {
    let qrBox = document.getElementById('qrBox');
    let radios = document.getElementsByName('payment_method');
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked && radios[i].value === 'qr_code') {
            qrBox.style.display = 'block';
            return;
        }
    }
    qrBox.style.display = 'none';
}
// Init on load
toggleQR();

function checkPasswordOrFace() {
    let faceVerified = document.getElementById('face_verified').value;
    let pwd = document.getElementById('paymentPassword').value;
    if (faceVerified === '0' && pwd.trim() === '') {
        alert('Vui lòng nhập mật khẩu hoặc dùng Face ID để xác nhận thanh toán!');
        return false;
    }
    return true;
}

let faceAuthModalObj;
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('faceAuthModal');
    if (el) {
        faceAuthModalObj = new bootstrap.Modal(el);
    }
});
</script>

<?php include 'includes/footer.php'; ?>
