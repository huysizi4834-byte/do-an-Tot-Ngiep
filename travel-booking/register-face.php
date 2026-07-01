<?php
$page_title = "Đăng ký Face ID";
require 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Vui lòng đăng nhập.</div></div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="mb-4">Cài Đặt Nhận Diện Khuôn Mặt (Face ID)</h2>
            <p class="text-muted mb-4">Vui lòng cấp quyền truy cập Camera và đưa khuôn mặt của bạn vào giữa khung hình. Hệ thống sẽ trích xuất dữ liệu sinh trắc học để phục vụ cho việc thanh toán và Check-in sau này.</p>
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 bg-dark rounded position-relative d-flex justify-content-center" style="min-height: 400px; overflow: hidden;">
                    <!-- Loading Text -->
                    <div id="loading" class="position-absolute top-50 start-50 translate-middle text-white z-1">
                        <div class="spinner-border text-light mb-2" role="status"></div>
                        <p class="mb-0">Đang tải mô hình AI...</p>
                    </div>

                    <!-- Video Feed -->
                    <video id="video" width="640" height="480" autoplay muted playsinline class="z-2 position-relative" style="display: none; border-radius: 10px; max-width: 100%; max-height: 500px; object-fit: cover;"></video>
                    
                    <!-- Canvas for face overlay -->
                    <canvas id="overlay" class="position-absolute top-0 start-0 z-3" style="width: 100%; height: 100%; pointer-events: none;"></canvas>
                </div>
            </div>

            <button id="captureBtn" class="btn btn-primary btn-lg px-5 rounded-pill" disabled>
                <i class="fa-solid fa-camera me-2"></i> Quét & Lưu Face ID
            </button>
            <a href="profile.php" class="btn btn-outline-secondary btn-lg px-4 rounded-pill ms-2">Trở về</a>
            
            <div id="statusMessage" class="mt-4 fw-bold fs-5"></div>
            
            <hr class="my-4">
            <div class="text-start bg-light p-3 rounded">
                <p class="mb-2 fw-bold text-secondary"><i class="fa-solid fa-circle-info me-1"></i> Máy tính không có Camera?</p>
                <div class="input-group">
                    <input type="file" class="form-control" id="imageUpload" accept="image/*">
                    <button class="btn btn-outline-primary" type="button" id="uploadBtn" disabled><i class="fa-solid fa-upload me-1"></i> Quét từ Ảnh</button>
                </div>
                <small class="text-muted">Tải một bức ảnh rõ khuôn mặt của bạn lên để hệ thống phân tích thay vì dùng Camera.</small>
            </div>
            <!-- Hidden img for upload fallback -->
            <img id="uploadedImage" style="display:none; max-width: 100%; max-height: 500px; object-fit: contain; border-radius: 10px;">
        </div>
    </div>
</div>

<!-- Load face-api.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const loading = document.getElementById('loading');
    const captureBtn = document.getElementById('captureBtn');
    const statusMessage = document.getElementById('statusMessage');

    const imageUpload = document.getElementById('imageUpload');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadedImage = document.getElementById('uploadedImage');

    const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/';

    try {
        // Load models
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        
        // Enable fallback upload immediately after models load
        uploadBtn.disabled = false;

        loading.innerHTML = '<div class="spinner-border text-info mb-2" role="status"></div><p class="mb-0">Đang mở Camera...</p>';

        // Start camera
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        video.srcObject = stream;
        
        video.addEventListener('play', () => {
            loading.style.display = 'none';
            video.style.display = 'block';
            captureBtn.disabled = false;

            const displaySize = { width: video.width, height: video.height };
            faceapi.matchDimensions(overlay, displaySize);

            // Draw bounding boxes continuously
            setInterval(async () => {
                const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks();
                const ctx = overlay.getContext('2d');
                ctx.clearRect(0, 0, overlay.width, overlay.height);
                
                if (detection) {
                    const resizedDetection = faceapi.resizeResults(detection, displaySize);
                    faceapi.draw.drawDetections(overlay, resizedDetection);
                    faceapi.draw.drawFaceLandmarks(overlay, resizedDetection);
                }
            }, 100);
        });

    } catch (err) {
        console.error(err);
        loading.innerHTML = '<div class="text-danger"><i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i><br>Không thể truy cập Camera hoặc lỗi tải AI Model. Vui lòng kiểm tra quyền truy cập.</div>';
    }

    // Capture and Save Logic for Video
    captureBtn.addEventListener('click', async () => {
        captureBtn.disabled = true;
        statusMessage.className = "mt-4 fw-bold fs-5 text-warning";
        statusMessage.innerText = "Đang phân tích khuôn mặt...";

        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
        
        // Capture frame as base64
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/jpeg', 0.8);

        handleDetection(detection, true, imageData);
    });

    // Capture and Save Logic for Uploaded Image
    uploadBtn.addEventListener('click', async () => {
        if (!imageUpload.files || imageUpload.files.length === 0) {
            alert('Vui lòng chọn một file ảnh trước!');
            return;
        }
        
        uploadBtn.disabled = true;
        statusMessage.className = "mt-4 fw-bold fs-5 text-warning";
        statusMessage.innerText = "Đang phân tích ảnh tải lên...";
        loading.style.display = 'block';
        loading.innerHTML = '<div class="spinner-border text-primary mb-2" role="status"></div><p class="mb-0">Đang quét ảnh...</p>';
        
        // Stop video if it's running
        if (video.srcObject) {
            video.srcObject.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
        video.style.display = 'none';

        // Load image to img tag
        const file = imageUpload.files[0];
        const reader = new FileReader();
        reader.onload = async (e) => {
            uploadedImage.src = e.target.result;
            uploadedImage.onload = async () => {
                // Show image in the box instead of video
                uploadedImage.style.display = 'block';
                uploadedImage.className = "z-2 position-relative rounded";
                document.querySelector('.card-body').appendChild(uploadedImage);
                
                loading.style.display = 'none';

                const detection = await faceapi.detectSingleFace(uploadedImage, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
                handleDetection(detection, false, uploadedImage.src);
            };
        };
        reader.readAsDataURL(file);
    });

    function handleDetection(detection, isVideo, imageData) {
        if (!detection) {
            statusMessage.className = "mt-4 fw-bold fs-5 text-danger";
            statusMessage.innerText = "Không tìm thấy khuôn mặt nào! Vui lòng thử lại.";
            captureBtn.disabled = !isVideo; // re-enable if it was video
            uploadBtn.disabled = false;
            return;
        }

        // We have the face descriptor (Float32Array)
        const descriptor = Array.from(detection.descriptor); // Convert to normal array for JSON

        statusMessage.className = "mt-4 fw-bold fs-5 text-info";
        statusMessage.innerText = "Đang lưu trữ dữ liệu...";

        // Send to server
        fetch('save-face.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ descriptor: descriptor, image: imageData })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusMessage.className = "mt-4 fw-bold fs-5 text-success";
                statusMessage.innerHTML = "<i class='fa-solid fa-check-circle'></i> " + data.message;
                
                if (isVideo && video.srcObject) {
                    const stream = video.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                }
                
                setTimeout(() => {
                    window.location.href = 'profile.php';
                }, 2000);
            } else {
                statusMessage.className = "mt-4 fw-bold fs-5 text-danger";
                statusMessage.innerText = data.message;
                captureBtn.disabled = !isVideo;
                uploadBtn.disabled = false;
            }
        })
        .catch(err => {
            statusMessage.className = "mt-4 fw-bold fs-5 text-danger";
            statusMessage.innerText = "Lỗi kết nối mạng.";
            captureBtn.disabled = !isVideo;
            uploadBtn.disabled = false;
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
