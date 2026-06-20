<?php

session_start();

require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM users WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

// Tính toán Độ thân thiết (Loyalty Tier)
// Đếm số đơn tour (đã duyệt/hoàn thành)
$tour_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE user_id = $user_id AND booking_status IN ('confirmed', 'completed')");
$tour_count = mysqli_fetch_assoc($tour_query)['total'] ?? 0;

// Đếm số đơn vé máy bay (đã xác nhận)
$flight_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM flight_bookings WHERE user_id = $user_id AND booking_status = 'confirmed'");
$flight_count = mysqli_fetch_assoc($flight_query)['total'] ?? 0;

// Đếm số đơn phòng khách sạn (đã xác nhận/hoàn thành)
$hotel_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM hotel_bookings WHERE user_id = $user_id AND booking_status IN ('confirmed', 'completed')");
$hotel_count = mysqli_fetch_assoc($hotel_query)['total'] ?? 0;

$total_bookings = $tour_count + $flight_count + $hotel_count;

// Logic phân hạng
if ($total_bookings >= 10) {
    $tier = 'Hạng Kim Cương 💎';
    $tier_class = 'bg-info text-dark';
} elseif ($total_bookings >= 5) {
    $tier = 'Hạng Vàng 🥇';
    $tier_class = 'bg-warning text-dark';
} elseif ($total_bookings >= 2) {
    $tier = 'Hạng Bạc 🥈';
    $tier_class = 'bg-secondary';
} else {
    $tier = 'Thành viên Mới 🥉';
    $tier_class = 'bg-primary';
}

include 'includes/header.php';
?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="mb-3 position-relative d-inline-block">
                        <img src="<?= !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&background=random' ?>"
                            alt="Avatar" class="rounded-circle shadow-sm"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <span
                            class="position-absolute bottom-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle"
                            title="Tài khoản đang hoạt động"></span>
                    </div>
                    <h3 class="mb-1 fw-bold"><?= htmlspecialchars($user['full_name']) ?></h3>
                    <p class="text-muted mb-2"><?= htmlspecialchars($user['email']) ?></p>
                    <span class="badge rounded-pill fs-6 px-3 py-2 <?= $tier_class ?>"><?= $tier ?></span>
                    <p class="text-muted small mt-2 mb-0">Bạn đã hoàn thành <strong><?= $total_bookings ?></strong>
                        chuyến đi cùng chúng tôi.</p>
                </div>
            </div>

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h4 class="mb-4">
                        Cập nhật hồ sơ
                    </h4>

                    <!-- Cập nhật thông tin -->

                    <form action="includes/auth/update-profile.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện mới (Avatar)</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Họ và tên
                            </label>

                            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>"
                                class="form-control">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control"
                                disabled>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Số điện thoại
                            </label>

                            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"
                                class="form-control">

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật thông tin
                        </button>
                    </form>

                    <hr>

                    <!-- Face ID -->
                    <h4 class="mb-3">Bảo mật sinh trắc học</h4>
                    <p class="text-muted small">Cài đặt Face ID để tự động xác thực và check-in không cần giấy tờ.</p>
                    <a href="register-face.php" class="btn btn-outline-success">
                        <i class="fa-solid fa-face-smile me-2"></i> 
                        <?= empty($user['face_descriptor']) ? 'Cài đặt Face ID' : 'Cập nhật lại Face ID' ?>
                    </a>

                    <hr>

                    <!-- Đổi mật khẩu -->

                    <h4 class="mb-3">
                        Đổi mật khẩu
                    </h4>

                    <form action="includes/auth/change-password.php" method="POST">

                        <div class="mb-3">

                            <input type="password" name="old_password" class="form-control" placeholder="Mật khẩu cũ"
                                required>

                        </div>

                        <div class="mb-3">

                            <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới"
                                required>

                        </div>

                        <button type="submit" class="btn btn-danger">

                            Đổi mật khẩu

                        </button>

                    </form>

                    <hr>

                    <!-- Đăng xuất -->

                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#ratingModal">

                        Đăng xuất

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal đánh giá -->

<div class="modal fade" id="ratingModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Đánh giá trải nghiệm
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <form action="includes/auth/rate-and-logout.php" method="POST">

                <div class="modal-body">

                    <p class="text-center">

                        Bạn đánh giá website bao nhiêu sao?

                    </p>

                    <select name="rating" class="form-select">

                        <option value="5">
                            ⭐⭐⭐⭐⭐ 5 sao
                        </option>

                        <option value="4">
                            ⭐⭐⭐⭐ 4 sao
                        </option>

                        <option value="3">
                            ⭐⭐⭐ 3 sao
                        </option>

                        <option value="2">
                            ⭐⭐ 2 sao
                        </option>

                        <option value="1">
                            ⭐ 1 sao
                        </option>

                    </select>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Hủy

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Gửi & Đăng xuất

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>