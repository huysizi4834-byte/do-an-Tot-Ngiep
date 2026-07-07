<?php
$page_title = "Quét Face ID Check-in";
require '../includes/db.php';

// API trả về danh sách toàn bộ users có face_descriptor
if (isset($_GET['api']) && $_GET['api'] == 'get_faces') {
    header('Content-Type: application/json');
    $sql = "SELECT id, full_name, email, face_descriptor FROM users WHERE face_descriptor IS NOT NULL AND status = 'active'";
    $res = mysqli_query($conn, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($res)) {
        // Parse JSON string back to array
        $row['face_descriptor'] = json_decode($row['face_descriptor']);
        $users[] = $row;
    }
    echo json_encode($users);
    exit;
}

// API xử lý Check-in khi tìm thấy user_id
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['api']) && $data['api'] == 'do_checkin') {
    header('Content-Type: application/json');
    $uid = (int) $data['user_id'];
    
    // Tìm các booking chưa check-in của user này
    // Đối với hệ thống này, ta update flight_bookings
    $sql = "UPDATE flight_bookings SET check_in_status = 'checked_in' WHERE user_id = $uid AND booking_status = 'confirmed' AND check_in_status = 'pending'";
    mysqli_query($conn, $sql);
    $affected = mysqli_affected_rows($conn);
    
    if ($affected > 0) {
        // Get user name
        $u_res = mysqli_query($conn, "SELECT full_name FROM users WHERE id = $uid");
        $u_name = mysqli_fetch_assoc($u_res)['full_name'];
        echo json_encode(['success' => true, 'message' => "Đã Check-in thành công $affected chuyến bay cho hành khách: $u_name!"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Không tìm thấy vé hợp lệ cần Check-in của hành khách này."]);
    }
    exit;
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-face-viewfinder me-2"></i> Face ID Check-in</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-body text-center bg-dark rounded position-relative" style="min-height: 500px; overflow: hidden;">
                <div id="loading" class="position-absolute top-50 start-50 translate-middle text-white z-1">
                    <div class="spinner-border text-success mb-2" role="status"></div>
                    <p class="mb-0" id="loadingText">Đang tải mô hình AI & Dữ liệu Khuôn mặt...</p>
                </div>

                <video id="video" width="640" height="480" autoplay muted playsinline class="z-2 position-relative" style="display: none; border-radius: 10px; max-width: 100%;"></video>
                <canvas id="overlay" class="position-absolute top-0 start-0 z-3" style="width: 100%; height: 100%; pointer-events: none;"></canvas>
                <img id="uploadedImg" class="z-1 position-relative rounded" style="display:none; max-width: 100%; max-height: 480px;">
            </div>
        </div>
        
        <div class="card shadow mb-4">
            <div class="card-body bg-light">
                <h6 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-file-arrow-up me-2"></i>Chế độ giả lập (Quét qua ảnh tải lên)</h6>
                <div class="input-group">
                    <input type="file" class="form-control" id="imageUpload" accept="image/*">
                    <button class="btn btn-primary" type="button" id="uploadBtn" disabled><i class="fa-solid fa-upload me-1"></i> Nhận diện từ Ảnh</button>
                </div>
                <small class="text-muted mt-2 d-block">Sử dụng tính năng này nếu hệ thống lỗi Camera hoặc muốn test nhanh bằng file ảnh.</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-success text-white">
                <h6 class="m-0 fw-bold"><i class="fa-solid fa-bars-progress me-2"></i> Trạng thái Nhận diện</h6>
            </div>
            <div class="card-body">
                <div id="statusBox" class="alert alert-secondary text-center">
                    <i class="fa-solid fa-camera fa-2x mb-2"></i><br>
                    Camera đang tắt
                </div>
                
                <h6 class="fw-bold mt-4 border-bottom pb-2">Lịch sử nhận diện gần nhất:</h6>
                <ul id="historyList" class="list-group list-group-flush small" style="max-height: 300px; overflow-y: auto;">
                    <!-- Lịch sử sẽ xuất hiện ở đây -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const loading = document.getElementById('loading');
    const loadingText = document.getElementById('loadingText');
    const statusBox = document.getElementById('statusBox');
    const historyList = document.getElementById('historyList');
    
    const imageUpload = document.getElementById('imageUpload');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadedImg = document.getElementById('uploadedImg');

    const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/';
    let faceMatcher = null;
    let isProcessing = false; // Prevent multiple check-ins for the same person instantly
    let detectionInterval = null;
    let stream = null;

    function addHistory(text, type) {
        const li = document.createElement('li');
        li.className = `list-group-item text-${type}`;
        li.innerHTML = `<i class="fa-solid fa-${type === 'success' ? 'check' : (type === 'danger' ? 'xmark' : 'info')}-circle me-2"></i> ${new Date().toLocaleTimeString()} - ${text}`;
        historyList.prepend(li);
    }

    try {
        // 1. Load Face Models
        loadingText.innerText = "Đang tải mô hình AI (1/2)...";
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);

        // 2. Fetch User Descriptors
        loadingText.innerText = "Đang tải dữ liệu khuôn mặt (2/2)...";
        const response = await fetch('face-checkin.php?api=get_faces');
        const users = await response.json();

        if (users.length === 0) {
            loading.innerHTML = '<div class="text-warning"><i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i><br>Chưa có người dùng nào đăng ký Face ID trong hệ thống.</div>';
            return;
        }

        // Prepare LabeledFaceDescriptors
        const labeledDescriptors = users.map(user => {
            const descriptorArray = new Float32Array(user.face_descriptor);
            // Label is the user ID and Name joined by a special separator
            return new faceapi.LabeledFaceDescriptors(`${user.id}|||${user.full_name}`, [descriptorArray]);
        });
        
        faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.5); // 0.5 is distance threshold
        
        uploadBtn.disabled = false; // Enable fallback button

        // 3. Start Camera
        loadingText.innerText = "Đang mở Camera...";
        stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        video.srcObject = stream;

        video.addEventListener('play', () => {
            loading.style.display = 'none';
            video.style.display = 'block';
            statusBox.className = "alert alert-info text-center";
            statusBox.innerHTML = '<i class="fa-solid fa-eye fa-2x mb-2"></i><br>Hệ thống đang quan sát...';

            const displaySize = { width: video.width, height: video.height };
            faceapi.matchDimensions(overlay, displaySize);

            // Recognition Loop
            detectionInterval = setInterval(async () => {
                if (video.style.display === 'none') return; // Skip if in upload mode
                
                const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
                
                const ctx = overlay.getContext('2d');
                ctx.clearRect(0, 0, overlay.width, overlay.height);
                
                if (detection) {
                    const resizedDetection = faceapi.resizeResults(detection, displaySize);
                    
                    // Match Face
                    const bestMatch = faceMatcher.findBestMatch(detection.descriptor);
                    
                    // Draw Box
                    const box = resizedDetection.detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, { 
                        label: bestMatch.label.split('|||')[1] || bestMatch.label,
                        boxColor: bestMatch.label !== 'unknown' ? 'green' : 'red' 
                    });
                    drawBox.draw(overlay);

                    if (bestMatch.label !== 'unknown' && !isProcessing) {
                        isProcessing = true;
                        const [userId, userName] = bestMatch.label.split('|||');
                        
                        statusBox.className = "alert alert-success text-center";
                        statusBox.innerHTML = `<i class="fa-solid fa-user-check fa-2x mb-2"></i><br>Nhận diện: <b>${userName}</b>`;
                        
                        // Call Check-in API
                        fetch('face-checkin.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ api: 'do_checkin', user_id: userId })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                addHistory(data.message, 'success');
                            } else {
                                addHistory(data.message, 'warning');
                            }
                        })
                        .catch(err => {
                            addHistory("Lỗi kết nối khi check-in.", 'danger');
                        })
                        .finally(() => {
                            // Cooldown 5 seconds before checking the same/another person
                            setTimeout(() => {
                                isProcessing = false;
                                statusBox.className = "alert alert-info text-center";
                                statusBox.innerHTML = '<i class="fa-solid fa-eye fa-2x mb-2"></i><br>Hệ thống đang quan sát...';
                            }, 5000);
                        });
                    }
                }
            }, 500); // Check every 500ms
        });

    } catch (err) {
        console.error(err);
        loading.innerHTML = '<div class="text-danger"><i class="fa-solid fa-circle-xmark fa-2x mb-2"></i><br>Không tìm thấy Camera, vui lòng dùng chức năng Tải ảnh giả lập phía dưới.</div>';
    }

    // Logic for Uploaded Image
    uploadBtn.addEventListener('click', async () => {
        if (!imageUpload.files || imageUpload.files.length === 0) {
            alert('Vui lòng chọn một file ảnh trước!');
            return;
        }
        
        uploadBtn.disabled = true;
        statusBox.className = "alert alert-warning text-center";
        statusBox.innerHTML = '<i class="fa-solid fa-spinner fa-spin fa-2x mb-2"></i><br>Đang phân tích ảnh tải lên...';
        
        // Stop video
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
        video.style.display = 'none';
        loading.style.display = 'block';
        loading.innerHTML = '<div class="spinner-border text-primary mb-2" role="status"></div><p class="mb-0">Đang quét ảnh...</p>';

        const file = imageUpload.files[0];
        const reader = new FileReader();
        reader.onload = async (e) => {
            uploadedImg.src = e.target.result;
            uploadedImg.onload = async () => {
                uploadedImg.style.display = 'block';
                loading.style.display = 'none';
                
                // Clear old drawings
                const ctx = overlay.getContext('2d');
                ctx.clearRect(0, 0, overlay.width, overlay.height);

                const detection = await faceapi.detectSingleFace(uploadedImg, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
                
                if (!detection) {
                    statusBox.className = "alert alert-danger text-center";
                    statusBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i><br>Không tìm thấy khuôn mặt nào trong ảnh!';
                    uploadBtn.disabled = false;
                    return;
                }

                const bestMatch = faceMatcher.findBestMatch(detection.descriptor);

                if (bestMatch.label !== 'unknown') {
                    const [userId, userName] = bestMatch.label.split('|||');
                    
                    statusBox.className = "alert alert-success text-center";
                    statusBox.innerHTML = `<i class="fa-solid fa-user-check fa-2x mb-2"></i><br>Nhận diện: <b>${userName}</b>`;
                    
                    fetch('face-checkin.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ api: 'do_checkin', user_id: userId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            addHistory(data.message + " (Giả lập qua ảnh)", 'success');
                        } else {
                            addHistory(data.message + " (Giả lập qua ảnh)", 'warning');
                        }
                    })
                    .catch(err => {
                        addHistory("Lỗi kết nối khi check-in.", 'danger');
                    })
                    .finally(() => {
                        uploadBtn.disabled = false;
                    });
                } else {
                    statusBox.className = "alert alert-danger text-center";
                    statusBox.innerHTML = `<i class="fa-solid fa-user-xmark fa-2x mb-2"></i><br>Nhận diện: <b>Người lạ (Không có trong HT)</b>`;
                    addHistory("Phát hiện người lạ qua ảnh tải lên.", 'danger');
                    uploadBtn.disabled = false;
                }
            };
        };
        reader.readAsDataURL(file);
    });
});
</script>

<?php include 'includes/admin-footer.php'; ?>
