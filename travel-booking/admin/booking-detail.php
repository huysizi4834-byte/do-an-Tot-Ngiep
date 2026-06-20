<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: bookings.php");
    exit;
}

$booking_id = (int) $_GET['id'];

// Xử lý cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE bookings SET booking_status = '$new_status' WHERE id = $booking_id");
    $success = "Cập nhật trạng thái thành công!";
}

// Lấy thông tin booking
$sql = "SELECT b.*, u.full_name, u.email, u.phone, t.title, d.name AS destination_name 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN tours t ON b.tour_id = t.id 
        LEFT JOIN destinations d ON t.destination_id = d.id 
        WHERE b.id = $booking_id";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Booking không tồn tại!");
}

$page_title = "Chi tiết Đặt Tour #" . $booking['id'];
include 'includes/admin-header.php';
?>

<div class="row">
    <div class="col-md-8">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thông tin Tour</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Tên Tour:</th>
                            <td><?= htmlspecialchars($booking['title']) ?></td>
                        </tr>
                        <tr>
                            <th>Điểm đến:</th>
                            <td><?= htmlspecialchars($booking['destination_name'] ?? 'Không rõ') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày khởi hành:</th>
                            <td><?= date('d/m/Y', strtotime($booking['departure_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Số lượng người:</th>
                            <td><?= $booking['total_people'] ?> Người</td>
                        </tr>
                        <tr>
                            <th>Ngày đặt:</th>
                            <td><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thông tin Khách hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Họ tên:</th>
                            <td><?= htmlspecialchars($booking['full_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td><?= htmlspecialchars($booking['phone'] ?? 'Chưa cập nhật') ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= htmlspecialchars($booking['email']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($booking['payment_face_image']) || !empty($booking['representative_name']) || !empty($booking['cccd'])): ?>
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Xác minh danh tính</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($booking['payment_face_image'])): ?>
                    <div class="col-md-6 mb-3">
                        <h6>Ảnh quét lúc Thanh toán (Face ID)</h6>
                        <img src="../<?= htmlspecialchars($booking['payment_face_image']) ?>" class="img-fluid rounded border border-success" alt="Payment Face Snapshot">
                        <small class="text-muted fst-italic">Hình ảnh mang tính chất minh họa/đối chiếu.</small>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($booking['representative_name']) || !empty($booking['cccd'])): ?>
                <?php if (!empty($booking['payment_face_image'])) echo '<hr>'; ?>
                <h6 class="fw-bold">Thông tin đại diện (Nhóm > 5 người)</h6>
                <p class="mb-1"><strong>Họ tên:</strong> <?= htmlspecialchars($booking['representative_name']) ?></p>
                <p class="mb-0"><strong>Số CCCD:</strong> <?= htmlspecialchars($booking['cccd']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Trạng thái hiện tại</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 text-center">
                    <?php
                    $status = $booking['booking_status'];
                    if ($status == 'confirmed' || $status == 'approved') {
                        echo '<span class="badge bg-success fs-6 w-100 p-2">Đã duyệt</span>';
                    } elseif ($status == 'completed') {
                        echo '<span class="badge bg-primary fs-6 w-100 p-2">Hoàn thành</span>';
                    } elseif ($status == 'cancelled') {
                        echo '<span class="badge bg-danger fs-6 w-100 p-2">Đã hủy</span>';
                    } else {
                        echo '<span class="badge bg-warning text-dark fs-6 w-100 p-2">Chờ duyệt</span>';
                    }
                    ?>
                </div>

                <hr>

                <form action="booking-detail.php?id=<?= $booking_id ?>" method="POST">
                    <div class="mb-3">
                        <label for="status" class="form-label">Cập nhật trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Chờ duyệt</option>
                            <option value="confirmed" <?= ($status == 'confirmed' || $status == 'approved') ? 'selected' : '' ?>>Đã duyệt</option>
                            <option value="completed" <?= ($status == 'completed') ? 'selected' : '' ?>>Đã hoàn thành
                            </option>
                            <option value="cancelled" <?= ($status == 'cancelled') ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <a href="bookings.php" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>