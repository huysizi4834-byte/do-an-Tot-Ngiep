<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Bespoke - Thiết Kế Tour Riêng";
require 'includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $duration = (int)$_POST['duration'];
    $pax = (int)$_POST['pax'];
    $budget = mysqli_real_escape_string($conn, $_POST['budget']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 'NULL';

    $sql = "INSERT INTO bespoke_requests (user_id, name, phone, email, destination, start_date, duration, pax, budget, requirements) 
            VALUES ($user_id, '$name', '$phone', '$email', '$destination', '$start_date', $duration, $pax, '$budget', '$requirements')";
            
    if (mysqli_query($conn, $sql)) {
        $success = "Cảm ơn bạn! Yêu cầu thiết kế tour đã được gửi thành công. Chuyên viên của THEGIOI Travel sẽ liên hệ với bạn trong thời gian sớm nhất.";
    } else {
        $error = "Đã xảy ra lỗi hệ thống: " . mysqli_error($conn);
    }
}

// Lấy thông tin user nếu đã đăng nhập để điền sẵn form
$u_name = '';
$u_phone = '';
$u_email = '';
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT full_name, phone, email FROM users WHERE id = $uid");
    if ($row = mysqli_fetch_assoc($res)) {
        $u_name = $row['full_name'];
        $u_phone = $row['phone'];
        $u_email = $row['email'];
    }
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<div class="bespoke-hero py-5 text-white position-relative" style="background: linear-gradient(rgba(0, 59, 115, 0.8), rgba(0, 59, 115, 0.9)), url('assets/images/bespoke-bg.jpg') center/cover; min-height: 400px; display: flex; align-items: center;">
    <div class="container text-center position-relative z-index-1">
        <h1 class="display-3 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Thiết Kế Tour Riêng Cao Cấp</h1>
        <p class="lead fs-4 fw-light w-75 mx-auto">Trải nghiệm hành trình độc bản, được may đo tỉ mỉ theo đúng sở thích và phong cách của riêng bạn.</p>
    </div>
</div>

<div class="container py-5 mt-4">
    <!-- Intro Section -->
    <div class="row align-items-center mb-5 pb-4 border-bottom">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="fw-bold text-primary mb-4">Vì sao chọn Bespoke Tour?</h2>
            <div class="d-flex mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-star"></i>
                </div>
                <div>
                    <h5 class="fw-bold">Lịch trình độc bản</h5>
                    <p class="text-muted">Không gò bó thời gian, tự do lựa chọn điểm đến. Mỗi chuyến đi là một kiệt tác dành riêng cho bạn.</p>
                </div>
            </div>
            <div class="d-flex mb-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-diamond"></i>
                </div>
                <div>
                    <h5 class="fw-bold">Dịch vụ thượng lưu</h5>
                    <p class="text-muted">Lưu trú tại các resort 5 sao+, xe sang đưa đón riêng, thưởng thức ẩm thực Michelin.</p>
                </div>
            </div>
            <div class="d-flex">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-headset"></i>
                </div>
                <div>
                    <h5 class="fw-bold">Chuyên viên hỗ trợ 24/7</h5>
                    <p class="text-muted">Đội ngũ chuyên gia du lịch giàu kinh nghiệm luôn đồng hành cùng bạn trên mọi nẻo đường.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-light p-5 rounded-4 border-start border-primary border-5">
                <h4 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif;">"Du lịch không chỉ là đi, mà là trải nghiệm cuộc sống theo cách của riêng bạn."</h4>
                <p class="text-end text-muted fw-bold mb-0">- THEGIOI Travel</p>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center" id="request-form">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="row g-0">
                    <!-- Form Image/Info Sidebar -->
                    <div class="col-md-4 bg-primary text-white p-5 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-4">Bắt đầu hành trình</h3>
                            <p class="opacity-75 mb-5">Vui lòng cung cấp cho chúng tôi một vài thông tin cơ bản để chuyên viên có thể thiết kế một lịch trình hoàn hảo nhất.</p>
                            
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-telephone fs-4 me-3"></i>
                                <div>
                                    <small class="opacity-75 d-block">Hotline hỗ trợ 24/7</small>
                                    <span class="fw-bold fs-5">1900 1234</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope-paper fs-4 me-3"></i>
                                <div>
                                    <small class="opacity-75 d-block">Email yêu cầu</small>
                                    <span class="fw-bold fs-5">bespoke@thegioitravel.vn</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Fields -->
                    <div class="col-md-8 p-5">
                        <h4 class="fw-bold text-dark mb-4">Gửi Yêu Cầu Thiết Kế Tour</h4>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success rounded-3 py-3 border-0 bg-success bg-opacity-10 text-success fw-bold">
                                <i class="bi bi-check-circle-fill me-2"></i> <?= $success ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger rounded-3 py-3 border-0 bg-danger bg-opacity-10 text-danger fw-bold">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form action="#request-form" method="POST">
                            <h6 class="text-primary fw-bold text-uppercase mb-3 mt-4" style="letter-spacing: 1px;">1. Thông tin chuyến đi</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold small">Điểm đến mong muốn *</label>
                                    <input type="text" class="form-control bg-light border-0 py-2" name="destination" placeholder="VD: Pháp, Maldives, Nhật Bản..." required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold small">Ngân sách dự kiến (VND) *</label>
                                    <select class="form-select bg-light border-0 py-2" name="budget" required>
                                        <option value="" selected disabled>Chọn mức ngân sách</option>
                                        <option value="Dưới 50 triệu">Dưới 50 triệu / người</option>
                                        <option value="50 - 100 triệu">50 - 100 triệu / người</option>
                                        <option value="100 - 200 triệu">100 - 200 triệu / người</option>
                                        <option value="Trên 200 triệu">Trên 200 triệu / người</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-bold small">Ngày khởi hành *</label>
                                    <input type="date" class="form-control bg-light border-0 py-2" name="start_date" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-bold small">Số ngày đi *</label>
                                    <input type="number" class="form-control bg-light border-0 py-2" name="duration" min="1" placeholder="VD: 7" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted fw-bold small">Số người *</label>
                                    <input type="number" class="form-control bg-light border-0 py-2" name="pax" min="1" placeholder="VD: 2" required>
                                </div>
                            </div>

                            <h6 class="text-primary fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">2. Yêu cầu đặc biệt</h6>
                            <div class="mb-4">
                                <textarea class="form-control bg-light border-0" name="requirements" rows="4" placeholder="Ví dụ: Cần khách sạn có view biển, muốn ăn tối trên du thuyền, có người già đi cùng cần xe lăn..."></textarea>
                            </div>

                            <h6 class="text-primary fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">3. Thông tin liên hệ</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label text-muted fw-bold small">Họ và tên *</label>
                                    <input type="text" class="form-control bg-light border-0 py-2" name="name" value="<?= htmlspecialchars($u_name) ?>" required <?= $u_name ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold small">Số điện thoại *</label>
                                    <input type="tel" class="form-control bg-light border-0 py-2" name="phone" value="<?= htmlspecialchars($u_phone) ?>" required <?= $u_phone ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold small">Email *</label>
                                    <input type="email" class="form-control bg-light border-0 py-2" name="email" value="<?= htmlspecialchars($u_email) ?>" required <?= $u_email ? 'readonly' : '' ?>>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill px-5 shadow-sm">Gửi Yêu Cầu <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap');
.form-control:focus, .form-select:focus {
    box-shadow: none;
    border: 1px solid var(--bs-primary) !important;
    background-color: #fff !important;
}
</style>

<?php include 'includes/footer.php'; ?>
