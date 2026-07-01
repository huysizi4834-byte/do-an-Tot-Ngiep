<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$user_id = (int) $_GET['id'];

// Xử lý khóa/mở khóa từ trang chi tiết
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'ban') {
        mysqli_query($conn, "UPDATE users SET status = 'banned' WHERE id = $user_id");
        $success = "Đã khóa tài khoản thành công!";
    } elseif ($action == 'unban') {
        mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $user_id");
        $success = "Đã mở khóa tài khoản thành công!";
    }
}

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Người dùng không tồn tại!");
}

// Lấy lịch sử đặt tour của user này
$booking_sql = "SELECT b.*, t.title 
                FROM bookings b 
                JOIN tours t ON b.tour_id = t.id 
                WHERE b.user_id = $user_id 
                ORDER BY b.created_at DESC";
$booking_result = mysqli_query($conn, $booking_sql);

$page_title = "Chi tiết Người Dùng: " . htmlspecialchars($user['full_name']);
include 'includes/admin-header.php';
?>

<div class="row">
    <div class="col-md-4">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="card mb-4 text-center">
            <div class="card-body">
                <img src="<?= !empty($user['avatar']) ? '../' . $user['avatar'] : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&background=random' ?>"
                    alt="Avatar" class="rounded-circle mb-3" width="150" style="object-fit: cover; height: 150px;">

                <h4 class="card-title"><?= htmlspecialchars($user['full_name']) ?></h4>
                <p class="text-muted mb-1">Thành viên từ <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>

                <?php if ($user['status'] == 'active'): ?>
                    <span class="badge bg-success mb-3">Hoạt động</span>
                <?php else: ?>
                    <span class="badge bg-danger mb-3">Bị khóa</span>
                <?php endif; ?>

                <div class="d-grid gap-2">
                    <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="btn btn-warning"><i
                            class="bi bi-envelope"></i> Gửi Email</a>

                    <?php if ($user['status'] == 'active'): ?>
                        <a href="user-detail.php?id=<?= $user['id'] ?>&action=ban" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc muốn khóa người dùng này?');"><i class="bi bi-lock"></i>
                            Khóa tài khoản</a>
                    <?php else: ?>
                        <a href="user-detail.php?id=<?= $user['id'] ?>&action=unban" class="btn btn-success"
                            onclick="return confirm('Bạn có chắc muốn mở khóa người dùng này?');"><i
                                class="bi bi-unlock"></i> Mở khóa tài khoản</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <h5 class="mb-0">Thông tin cá nhân</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Họ tên</div>
                    <div class="col-sm-9"><?= htmlspecialchars($user['full_name']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Email</div>
                    <div class="col-sm-9"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Số điện thoại</div>
                    <div class="col-sm-9"><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Mật khẩu</div>
                    <div class="col-sm-9">
                        <span class="text-secondary"><i class="fa-solid fa-lock me-1"></i> Đã mã hóa bảo mật (Không thể xem)</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Phân quyền</div>
                    <div class="col-sm-9">
                        <?= ($user['role'] == 'admin') ? '<span class="badge bg-danger">Quản trị viên</span>' : '<span class="badge bg-info text-dark">Khách hàng</span>' ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($user['face_descriptor'])): ?>
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <h5 class="mb-0">Dữ liệu Face ID</h5>
            </div>
            <div class="card-body text-center">
                <?php if (!empty($user['face_image'])): ?>
                    <img src="../<?= htmlspecialchars($user['face_image']) ?>" alt="Face ID" class="img-thumbnail rounded" style="max-height: 250px;">
                    <p class="mt-3 text-success fw-bold"><i class="bi bi-check-circle"></i> Đã xác thực khuôn mặt</p>
                <?php else: ?>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle"></i> Người dùng đã xác thực Face ID nhưng hệ thống chưa lưu ảnh khuôn mặt (dữ liệu cũ chỉ có mã đặc trưng).</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <h5 class="mb-0">Lịch sử đặt tour</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Mã ĐĐ</th>
                            <th>Tour</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($booking_result) > 0): ?>
                            <?php while ($bk = mysqli_fetch_assoc($booking_result)): ?>
                                <tr>
                                    <td><a href="booking-detail.php?id=<?= $bk['id'] ?>">#<?= $bk['id'] ?></a></td>
                                    <td><?= htmlspecialchars($bk['title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($bk['created_at'])) ?></td>
                                    <td>
                                        <?php
                                        $b_status = $bk['booking_status'];
                                        if ($b_status == 'confirmed' || $b_status == 'approved') {
                                            echo '<span class="badge bg-success">Đã duyệt</span>';
                                        } elseif ($b_status == 'completed') {
                                            echo '<span class="badge bg-primary">Hoàn thành</span>';
                                        } elseif ($b_status == 'cancelled') {
                                            echo '<span class="badge bg-danger">Đã hủy</span>';
                                        } else {
                                            echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Người dùng này chưa đặt tour nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="users.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>