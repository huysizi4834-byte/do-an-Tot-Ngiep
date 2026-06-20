<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: hotel-bookings.php");
    exit;
}

$booking_id = (int) $_GET['id'];

// Xử lý cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE hotel_bookings SET booking_status = '$new_status' WHERE id = $booking_id");
    $success = "Cập nhật trạng thái thành công!";
}

// Lấy thông tin booking
$sql = "SELECT hb.*, u.email as user_email, u.full_name as user_full_name, h.name as hotel_name, h.city 
        FROM hotel_bookings hb 
        JOIN users u ON hb.user_id = u.id 
        JOIN hotels h ON hb.hotel_id = h.id 
        WHERE hb.id = $booking_id";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Đơn đặt phòng không tồn tại!");
}

$page_title = "Chi tiết Đặt Phòng #" . $booking['booking_code'];
include 'includes/admin-header.php';
?>

<div class="row">
    <div class="col-md-8">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thông tin Đặt Phòng</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Mã đơn:</th>
                            <td class="fw-bold text-info">#<?= htmlspecialchars($booking['booking_code']) ?></td>
                        </tr>
                        <tr>
                            <th>Khách sạn:</th>
                            <td><?= htmlspecialchars($booking['hotel_name']) ?> -
                                <?= htmlspecialchars($booking['city']) ?></td>
                        </tr>
                        <tr>
                            <th>Lịch lưu trú:</th>
                            <td>
                                Nhận phòng: <?= date('d/m/Y', strtotime($booking['check_in_date'])) ?> <br>
                                Trả phòng: <?= date('d/m/Y', strtotime($booking['check_out_date'])) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Số lượng:</th>
                            <td><?= $booking['total_nights'] ?> Đêm / <?= $booking['total_guests'] ?> Khách</td>
                        </tr>
                        <tr>
                            <th>Tổng tiền:</th>
                            <td class="text-danger fw-bold"><?= number_format($booking['total_amount']) ?> ₫</td>
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
                <h5 class="mb-0">Thông tin Khách hàng liên hệ</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Họ tên:</th>
                            <td><?= htmlspecialchars($booking['guest_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td><?= htmlspecialchars($booking['guest_phone']) ?></td>
                        </tr>
                        <tr>
                            <th>Tài khoản Email:</th>
                            <td><?= htmlspecialchars($booking['user_email']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($booking['cccd_image']) || !empty($booking['face_image']) || !empty($booking['payment_face_image']) || !empty($booking['representative_name'])): ?>
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Xác minh danh tính</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($booking['cccd_image'])): ?>
                    <div class="col-md-6 mb-3">
                        <h6>Ảnh CMND / CCCD</h6>
                        <img src="../<?= htmlspecialchars($booking['cccd_image']) ?>" class="img-fluid rounded border" alt="CCCD Image">
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($booking['face_image'])): ?>
                    <div class="col-md-6 mb-3">
                        <h6>Ảnh khuôn mặt (Selfie)</h6>
                        <img src="../<?= htmlspecialchars($booking['face_image']) ?>" class="img-fluid rounded border" alt="Face Image">
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($booking['payment_face_image'])): ?>
                    <div class="col-md-6 mb-3">
                        <h6>Ảnh quét lúc Thanh toán (Face ID)</h6>
                        <img src="../<?= htmlspecialchars($booking['payment_face_image']) ?>" class="img-fluid rounded border border-success" alt="Payment Face Snapshot">
                        <small class="text-muted fst-italic">Hình ảnh mang tính chất minh họa/đối chiếu.</small>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($booking['representative_name']) || !empty($booking['cccd'])): ?>
                <hr>
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
                    if ($status == 'confirmed') {
                        echo '<span class="badge bg-success fs-6 w-100 p-2">Đã xác nhận</span>';
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

                <form action="hotel-booking-detail.php?id=<?= $booking_id ?>" method="POST">
                    <div class="mb-3">
                        <label for="status" class="form-label">Cập nhật trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Chờ duyệt</option>
                            <option value="confirmed" <?= ($status == 'confirmed') ? 'selected' : '' ?>>Xác nhận (Đã duyệt)
                            </option>
                            <option value="completed" <?= ($status == 'completed') ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="cancelled" <?= ($status == 'cancelled') ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <a href="hotel-bookings.php" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>