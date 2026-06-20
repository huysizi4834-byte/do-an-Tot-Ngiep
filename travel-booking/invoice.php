<?php
require 'includes/db.php';
require_once 'includes/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Truy cập bị từ chối.");
}

if (!isset($_GET['code'])) {
    die("Mã đơn hàng không hợp lệ.");
}

$code = mysqli_real_escape_string($conn, $_GET['code']);
$user_id = $_SESSION['user_id'];
$prefix = substr($code, 0, 2);

if ($prefix === 'HT') {
    $sql = "SELECT hb.*, h.name as item_name, h.address as address, u.email, u.phone as u_phone, u.full_name as u_name FROM hotel_bookings hb JOIN hotels h ON hb.hotel_id = h.id JOIN users u ON hb.user_id = u.id WHERE hb.booking_code = '$code' AND hb.user_id = '$user_id'";
} elseif ($prefix === 'FL') {
    $sql = "SELECT fb.*, CONCAT(f.airline, ' - ', f.flight_number) as item_name, CONCAT(f.departure_city, ' -> ', f.arrival_city) as address, u.email, u.phone as u_phone, u.full_name as u_name FROM flight_bookings fb JOIN flights f ON fb.flight_id = f.id JOIN users u ON fb.user_id = u.id WHERE fb.booking_code = '$code' AND fb.user_id = '$user_id'";
} elseif ($prefix === 'TR') {
    $sql = "SELECT b.*, t.title as item_name, 'Tour du lịch' as address, u.email, u.phone as u_phone, u.full_name as u_name FROM bookings b JOIN tours t ON b.tour_id = t.id JOIN users u ON b.user_id = u.id WHERE b.booking_code = '$code' AND b.user_id = '$user_id'";
} elseif ($prefix === 'SV') {
    $sql = "SELECT sb.*, sb.total_price as total_amount, s.name as item_name, 'Dịch vụ cộng thêm' as address, u.email, u.phone as u_phone, u.full_name as u_name FROM service_bookings sb JOIN additional_services s ON sb.service_id = s.id JOIN users u ON sb.user_id = u.id WHERE sb.booking_code = '$code' AND sb.user_id = '$user_id'";
} elseif ($prefix === 'CB') {
    $sql = "SELECT cb.*, cb.total_price as total_amount, c.name as item_name, c.duration as address, u.email, u.phone as u_phone, u.full_name as u_name FROM combo_bookings cb JOIN combos c ON cb.combo_id = c.id JOIN users u ON cb.user_id = u.id WHERE cb.booking_code = '$code' AND cb.user_id = '$user_id'";
} else {
    die("Loại hóa đơn không hỗ trợ. Mã truyền vào là: " . htmlspecialchars($code));
}

$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Không tìm thấy thông tin đơn hàng.");
}

$remaining = $booking['total_amount'] - $booking['amount_paid'];
$guest_name = $booking['guest_name'] ?? $booking['u_name'];
$guest_phone = $booking['guest_phone'] ?? $booking['u_phone'];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn - #<?= htmlspecialchars($booking['booking_code']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .invoice-box {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        @media print {
            body {
                background-color: white;
            }

            .invoice-box {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }

        .invoice-header {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(0, 0, 0, 0.05);
            z-index: 0;
            pointer-events: none;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="container relative">
        <div class="invoice-box position-relative">

            <?php if ($booking['payment_status'] == 'paid'): ?>
                <div class="watermark fw-bold text-success" style="color: rgba(25, 135, 84, 0.1) !important;">ĐÃ THANH TOÁN
                </div>
                <?php endif; ?>

            <!-- Nút điều khiển in -->
            <div class="text-end mb-4 no-print">
                <button onclick="window.print()" class="btn btn-primary"><i class="fa-solid fa-print me-2"></i>In Hóa Đơn</button>
                <button onclick="window.close(); window.history.back();" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Quay lại / Đóng</button>
            </div>

            <div class="invoice-header d-flex justify-content-between align-items-center position-relative z-1">
                <div>
                    <h2 class="fw-bold text-primary mb-0">THEGIOI <span class="text-dark">TRAVEL & TOUR</span></h2>
                    <small class="text-muted">Mang thế giới đến trong tầm tay bạn</small>
                </div>
                <div class="text-end">
                    <h1 class="text-uppercase text-muted mb-0">Hóa Đơn</h1>
                    <p class="mb-0 fw-bold">Số: #<?= htmlspecialchars($booking['booking_code']) ?></p>
                    <p class="mb-0 text-muted small">Ngày lập: <?= date('d/m/Y H:i') ?></p>
                </div>
            </div>

            <div class="row mb-5 position-relative z-1">
                <div class="col-sm-6">
                    <h6 class="text-muted text-uppercase mb-3">Nhà cung cấp:</h6>
                    <h5 class="fw-bold mb-1">CÔNG TY TNHH THEGIOI TRAVEL</h5>
                    <p class="mb-0">Tòa nhà Landmark 81, Vinhomes Central Park</p>
                    <p class="mb-0">Quận Bình Thạnh, TP. Hồ Chí Minh</p>
                    <p class="mb-0">Email: contact@thegioi.vn</p>
                    <p class="mb-0">Hotline: 1900 1234</p>
                </div>
                <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                    <h6 class="text-muted text-uppercase mb-3">Thông tin Khách hàng:</h6>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($guest_name) ?></h5>
                    <p class="mb-0"><i class="fa-solid fa-phone me-1"></i> <?= htmlspecialchars($guest_phone) ?></p>
                    <p class="mb-0"><i class="fa-solid fa-envelope me-1"></i> <?= htmlspecialchars($booking['email']) ?>
                    </p>
                </div>
            </div>

            <h5 class="fw-bold mb-3 position-relative z-1 text-primary">Chi tiết Đơn hàng</h5>
            <div class="table-responsive mb-4 position-relative z-1">
                <table class="table table-bordered border-dark align-middle">
                    <thead class="table-light border-dark">
                        <tr>
                            <th>Dịch vụ</th>
                            <th class="text-center">Thông tin thêm</th>
                            <th class="text-center">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong class="d-block"><?= htmlspecialchars($booking['item_name']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($booking['address']) ?></small>
                            </td>
                            <td class="text-center">
                                    <?php if ($prefix === 'HT'): ?>
                                    Nhận: <?= date('d/m/Y', strtotime($booking['check_in_date'])) ?><br>
                                    Trả: <?= date('d/m/Y', strtotime($booking['check_out_date'])) ?>
                                    <?php elseif ($prefix === 'FL'): ?>
                                    Mã: <?= htmlspecialchars($booking['booking_code']) ?>
                                    <?php elseif ($prefix === 'TR'): ?>
                                    Khởi hành: <?= date('d/m/Y', strtotime($booking['departure_date'])) ?>
                                    <?php elseif ($prefix === 'SV'): ?>
                                    Ngày sử dụng: <?= date('d/m/Y', strtotime($booking['service_date'])) ?>
                                    <?php elseif ($prefix === 'CB'): ?>
                                    Ngày đi: <?= date('d/m/Y', strtotime($booking['travel_date'])) ?>
                                    <?php endif; ?>
                            </td>
                            <td class="text-center">
                                    <?php if ($prefix === 'HT'): ?>
                                        <?= $booking['total_nights'] ?> đêm<br>
                                        <?= $booking['total_guests'] ?> khách
                                    <?php elseif ($prefix === 'FL'): ?>
                                        <?= $booking['total_passengers'] ?> khách
                                    <?php elseif ($prefix === 'TR'): ?>
                                        <?= $booking['total_people'] ?> khách
                                    <?php elseif ($prefix === 'SV'): ?>
                                        <?= $booking['quantity'] ?> lượt
                                    <?php elseif ($prefix === 'CB'): ?>
                                        <?= $booking['total_people'] ?> khách
                                    <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row position-relative z-1">
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted">Phương thức thanh toán:</h6>
                    <p class="mb-1">
                            <?php
                            if ($booking['payment_type'] == 'deposit')
                                echo "Thanh toán đặt cọc 50%";
                            else
                                echo "Thanh toán toàn bộ 100%";
                            ?>
                    </p>
                    <p class="mb-0 text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> Đã thanh toán
                        thành công qua Cổng điện tử</p>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless text-end">
                        <tr>
                            <td><strong>Tổng cộng tiền:</strong></td>
                            <td class="fs-5"><?= formatPrice($booking['total_amount']) ?></td>
                        </tr>
                        <tr class="border-bottom border-dark">
                            <td><strong>Số tiền ĐÃ THANH TOÁN:</strong></td>
                            <td class="fs-5 text-success fw-bold">- <?= formatPrice($booking['amount_paid']) ?></td>
                        </tr>
                        <tr>
                            <td class="pt-3"><strong class="fs-5">SỐ TIỀN CÒN LẠI PHẢI TRẢ:</strong></td>
                            <td class="pt-3 fs-4 fw-bold text-danger"><?= formatPrice($remaining) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-5 text-center position-relative z-1">
                <p class="text-muted fst-italic mb-0">Hóa đơn này được tạo tự động từ hệ thống THEGIOI Travel & Tour.
                </p>
                <p class="text-muted fst-italic">Cảm ơn quý khách và chúc quý khách một kỳ nghỉ tuyệt vời!</p>
            </div>

        </div>
    </div>

    <script>
        // Tự động mở hộp thoại in nếu trang được mở với tham số print=1
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === '1') {
                window.print();
            }
        }
    </script>
</body>

</html>