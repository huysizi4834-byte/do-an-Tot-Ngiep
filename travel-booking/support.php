<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h1 class="fw-bold text-primary mb-3">Liên hệ & Hỗ trợ</h1>
            <p class="text-muted fs-5">Chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi thắc mắc của bạn.</p>
        </div>
    </div>

    <div class="row g-5">
        <!-- Thông tin liên hệ -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100 rounded-4" style="background-color: #f8f9fa;">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-4">Thông tin liên hệ</h4>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-location-dot fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Địa chỉ văn phòng</h6>
                            <p class="text-muted mb-0">123 Đường Nguyễn Huệ, Quận 1, Hà Nội </p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-phone fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Hotline tư vấn</h6>
                            <p class="text-muted mb-0">1900 1234 (Phím 1)</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-envelope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email hỗ trợ</h6>
                            <p class="text-muted mb-0">support@thegioitravel.vn</p>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="fw-bold mb-3">Kết nối với chúng tôi</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form liên hệ -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h4>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_contact'])) {
                        $name = mysqli_real_escape_string($conn, $_POST['name']);
                        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
                        $message = mysqli_real_escape_string($conn, $_POST['message']);

                        $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 'NULL';

                        $sql = "INSERT INTO contacts (user_id, name, phone, email, subject, message) VALUES ($user_id, '$name', '$phone', '$email', '$subject', '$message')";
                        if (mysqli_query($conn, $sql)) {
                            echo '<div class="alert alert-success">Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi trong thời gian sớm nhất!</div>';
                        } else {
                            echo '<div class="alert alert-danger">Đã xảy ra lỗi, vui lòng thử lại sau!</div>';
                        }
                    }
                    ?>
                    <?php
                    $u_name = '';
                    $u_phone = '';
                    $u_email = '';
                    if (isset($_SESSION['user_id'])) {
                        // Fetch user info from db to be safe
                        $uid = (int)$_SESSION['user_id'];
                        $u_res = mysqli_query($conn, "SELECT full_name, phone, email FROM users WHERE id = $uid");
                        if ($u_row = mysqli_fetch_assoc($u_res)) {
                            $u_name = $u_row['full_name'];
                            $u_phone = $u_row['phone'];
                            $u_email = $u_row['email'];
                        }
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên</label>
                                <input type="text" class="form-control" name="name" required placeholder="Nhập họ tên của bạn" value="<?= htmlspecialchars($u_name) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone" required placeholder="Nhập số điện thoại" value="<?= htmlspecialchars($u_phone) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="Nhập email để chúng tôi phản hồi" value="<?= htmlspecialchars($u_email) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Chủ đề</label>
                            <select class="form-select" name="subject">
                                <option value="Tu Van Tour">Tư vấn chọn Tour</option>
                                <option value="Ve May Bay">Đặt vé máy bay</option>
                                <option value="Khach San">Đặt phòng khách sạn</option>
                                <option value="Gop Y">Góp ý dịch vụ</option>
                                <option value="Khac">Vấn đề khác</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung tin nhắn</label>
                            <textarea class="form-control" name="message" rows="5" required placeholder="Bạn cần hỗ trợ thêm thông tin gì..."></textarea>
                        </div>
                        <button type="submit" name="send_contact" class="btn btn-primary px-5 py-2 fw-bold w-100 rounded-pill">Gửi Yêu Cầu Hỗ Trợ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
