<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy danh sách Tour
$sql_tours = "
SELECT b.*, t.title 
FROM bookings b 
INNER JOIN tours t ON b.tour_id = t.id 
WHERE b.user_id = '$user_id' 
ORDER BY b.departure_date DESC
";
$result_tours = mysqli_query($conn, $sql_tours);

// Lấy danh sách Vé máy bay
$sql_flights = "
SELECT fb.*, f.airline, f.flight_number, f.departure_city, f.arrival_city, f.departure_time 
FROM flight_bookings fb 
INNER JOIN flights f ON fb.flight_id = f.id 
WHERE fb.user_id = '$user_id' 
ORDER BY f.departure_time DESC
";
$result_flights = mysqli_query($conn, $sql_flights);

// Lấy danh sách Khách sạn
$sql_hotels = "
SELECT hb.*, h.name as hotel_name, h.city 
FROM hotel_bookings hb 
INNER JOIN hotels h ON hb.hotel_id = h.id 
WHERE hb.user_id = '$user_id' 
ORDER BY hb.check_in_date DESC
";
$result_hotels = mysqli_query($conn, $sql_hotels);

// Lấy danh sách Combo
$sql_combos = "
SELECT cb.*, c.name as combo_name 
FROM combo_bookings cb 
INNER JOIN combos c ON cb.combo_id = c.id 
WHERE cb.user_id = '$user_id' 
ORDER BY cb.travel_date DESC
";
$result_combos = mysqli_query($conn, $sql_combos);

// Lấy danh sách Dịch vụ cộng thêm
$sql_services = "
SELECT sb.*, s.name as service_name 
FROM service_bookings sb 
INNER JOIN additional_services s ON sb.service_id = s.id 
WHERE sb.user_id = '$user_id' 
ORDER BY sb.service_date DESC
";
$result_services = mysqli_query($conn, $sql_services);

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dịch vụ của tôi</h2>
        <a href="profile.php" class="btn btn-outline-primary"><i class="fa-solid fa-user me-2"></i> Hồ sơ cá nhân</a>
    </div>

    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-3 rounded-pill" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours" type="button" role="tab"><i class="fa-solid fa-umbrella-beach me-2"></i>Tour</button>
                </li>
                <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link fw-bold px-3 rounded-pill" id="flights-tab" data-bs-toggle="tab" data-bs-target="#flights" type="button" role="tab"><i class="fa-solid fa-plane me-2"></i>Vé máy bay</button>
                </li>
                <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link fw-bold px-3 rounded-pill" id="hotels-tab" data-bs-toggle="tab" data-bs-target="#hotels" type="button" role="tab"><i class="fa-solid fa-hotel me-2"></i>Khách sạn</button>
                </li>
                <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link fw-bold px-3 rounded-pill" id="combos-tab" data-bs-toggle="tab" data-bs-target="#combos" type="button" role="tab"><i class="fa-solid fa-layer-group me-2"></i>Combo</button>
                </li>
                <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link fw-bold px-3 rounded-pill" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab"><i class="fa-solid fa-box-seam me-2"></i>Dịch vụ</button>
                </li>
            </ul>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="fa-solid fa-filter text-muted"></i></span>
                <input type="text" id="tableFilter" class="form-control" placeholder="Lọc theo Mã Đặt, Tên, Trạng thái...">
            </div>
        </div>
    </div>

    <!-- Tabs Content -->
    <div class="tab-content" id="myTabContent">
        
        <!-- Tab Tours -->
        <div class="tab-pane fade show active" id="tours" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_tours) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã ĐĐ</th>
                                        <th>Tên Tour</th>
                                        <th>Ngày khởi hành</th>
                                        <th>Số người</th>
                                        <th>Thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($booking = mysqli_fetch_assoc($result_tours)): ?>
                                        <tr>
                                            <td><span class="badge bg-secondary">#<?= htmlspecialchars($booking['booking_code'] ?? $booking['id']) ?></span></td>
                                            <td class="fw-bold"><?= htmlspecialchars($booking['title']) ?></td>
                                            <td><?= htmlspecialchars($booking['departure_date']) ?></td>
                                            <td><?= htmlspecialchars($booking['total_people']) ?></td>
                                            <td>
                                                <?php if (($booking['payment_status'] ?? '') == 'paid'): ?>
                                                    <span class="badge bg-success"><i class="fa-solid fa-check-circle"></i> Đã thanh toán</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock"></i> Chờ thanh toán</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $booking['status'] ?? 'pending';
                                                if ($status == 'approved' || $status == 'completed') {
                                                    echo '<span class="badge bg-success">Đã duyệt</span>';
                                                } elseif ($status == 'cancelled') {
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if (!empty($booking['booking_code'])): ?>
                                                    <?php if (($booking['payment_status'] ?? '') != 'paid'): ?>
                                                        <a href="payment-gateway.php?code=<?= htmlspecialchars($booking['booking_code']) ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-credit-card"></i> Thanh toán
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="invoice.php?code=<?= htmlspecialchars($booking['booking_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                                                            <i class="fa-solid fa-file-invoice"></i> Hóa đơn
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-calendar-xmark fa-3x mb-3 text-light"></i>
                            <h5>Bạn chưa đặt tour nào</h5>
                            <a href="tours.php" class="btn btn-primary mt-2">Xem danh sách Tour</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Flights -->
        <div class="tab-pane fade" id="flights" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_flights) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã Đặt Vé</th>
                                        <th>Chuyến bay</th>
                                        <th>Hành trình</th>
                                        <th>Khởi hành</th>
                                        <th>Số vé</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fb = mysqli_fetch_assoc($result_flights)): ?>
                                        <tr>
                                            <td><span class="badge bg-dark fw-bold"><?= htmlspecialchars($fb['booking_code']) ?></span></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($fb['airline']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($fb['flight_number']) ?></small>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($fb['departure_city']) ?> <i class="fa-solid fa-arrow-right mx-1 text-muted"></i> <?= htmlspecialchars($fb['arrival_city']) ?>
                                            </td>
                                            <td><?= date('H:i d/m/Y', strtotime($fb['departure_time'])) ?></td>
                                            <td><?= htmlspecialchars($fb['total_passengers']) ?></td>
                                            <td class="text-danger fw-bold"><?= formatPrice($fb['total_amount']) ?></td>
                                            <td>
                                                <?php
                                                $fstatus = $fb['booking_status'] ?? 'pending';
                                                if ($fstatus == 'confirmed') {
                                                    echo '<span class="badge bg-success">Đã xuất vé</span>';
                                                } elseif ($fstatus == 'cancelled') {
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Đang xử lý</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($fb['booking_code'])): ?>
                                                    <?php if (($fb['payment_status'] ?? '') != 'paid'): ?>
                                                        <a href="payment-gateway.php?code=<?= htmlspecialchars($fb['booking_code']) ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-credit-card me-1"></i> Thanh toán
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="invoice.php?code=<?= htmlspecialchars($fb['booking_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                                                            <i class="fa-solid fa-file-invoice me-1"></i> Hóa đơn
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-plane-slash fa-3x mb-3 text-light"></i>
                            <h5>Bạn chưa đặt vé máy bay nào</h5>
                            <a href="flights.php" class="btn btn-primary mt-2">Tìm vé máy bay</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Hotels -->
        <div class="tab-pane fade" id="hotels" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_hotels) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã Đặt Phòng</th>
                                        <th>Khách sạn</th>
                                        <th>Ngày nhận/trả phòng</th>
                                        <th>Số đêm</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($hb = mysqli_fetch_assoc($result_hotels)): ?>
                                        <tr>
                                            <td><span class="badge bg-info text-dark fw-bold"><?= htmlspecialchars($hb['booking_code']) ?></span></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($hb['hotel_name']) ?></div>
                                                <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> <?= htmlspecialchars($hb['city']) ?></small>
                                            </td>
                                            <td>
                                                <small class="d-block text-muted">Vào: <span class="text-dark"><?= date('d/m/Y', strtotime($hb['check_in_date'])) ?></span></small>
                                                <small class="d-block text-muted">Ra: <span class="text-dark"><?= date('d/m/Y', strtotime($hb['check_out_date'])) ?></span></small>
                                            </td>
                                            <td><?= $hb['total_nights'] ?> đêm</td>
                                            <td class="text-danger fw-bold"><?= formatPrice($hb['total_amount']) ?></td>
                                            <td>
                                                <?php
                                                $hstatus = $hb['booking_status'] ?? 'pending';
                                                if ($hstatus == 'confirmed') {
                                                    echo '<span class="badge bg-success">Đã xác nhận</span>';
                                                } elseif ($hstatus == 'completed') {
                                                    echo '<span class="badge bg-primary">Đã hoàn thành</span>';
                                                } elseif ($hstatus == 'cancelled') {
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($hb['booking_code'])): ?>
                                                    <?php if (($hb['payment_status'] ?? '') != 'paid'): ?>
                                                        <a href="payment-gateway.php?code=<?= htmlspecialchars($hb['booking_code']) ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-credit-card me-1"></i> Thanh toán
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="invoice.php?code=<?= htmlspecialchars($hb['booking_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                                                            <i class="fa-solid fa-file-invoice me-1"></i> Hóa đơn
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-hotel fa-3x mb-3 text-light"></i>
                            <h5>Bạn chưa đặt phòng khách sạn nào</h5>
                            <a href="hotels.php" class="btn btn-primary mt-2">Tìm khách sạn</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Combos -->
        <div class="tab-pane fade" id="combos" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_combos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã Đặt</th>
                                        <th>Tên Combo</th>
                                        <th>Ngày khởi hành</th>
                                        <th>Số người</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($cb = mysqli_fetch_assoc($result_combos)): ?>
                                        <tr>
                                            <td><span class="badge bg-secondary">#<?= htmlspecialchars($cb['booking_code'] ?? $cb['id']) ?></span></td>
                                            <td class="fw-bold"><?= htmlspecialchars($cb['combo_name']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($cb['travel_date'])) ?></td>
                                            <td><?= htmlspecialchars($cb['total_people']) ?></td>
                                            <td class="text-danger fw-bold"><?= formatPrice($cb['total_price']) ?></td>
                                            <td>
                                                <?php
                                                $cstatus = $cb['status'] ?? 'pending';
                                                if ($cstatus == 'confirmed') {
                                                    echo '<span class="badge bg-success">Đã duyệt</span>';
                                                } elseif ($cstatus == 'cancelled') {
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if (!empty($cb['booking_code'])): ?>
                                                    <?php if (($cb['payment_status'] ?? '') != 'paid'): ?>
                                                        <a href="payment-gateway.php?code=<?= htmlspecialchars($cb['booking_code']) ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-credit-card"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="invoice.php?code=<?= htmlspecialchars($cb['booking_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                                                            <i class="fa-solid fa-file-invoice"></i> Hóa đơn
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-layer-group fa-3x mb-3 text-light"></i>
                            <h5>Bạn chưa đặt combo nào</h5>
                            <a href="combos.php" class="btn btn-primary mt-2">Xem danh sách Combo</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Services -->
        <div class="tab-pane fade" id="services" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_services) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã Đặt</th>
                                        <th>Tên Dịch vụ</th>
                                        <th>Ngày sử dụng</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($sb = mysqli_fetch_assoc($result_services)): ?>
                                        <tr>
                                            <td><span class="badge bg-primary">#<?= htmlspecialchars($sb['booking_code'] ?? $sb['id']) ?></span></td>
                                            <td class="fw-bold"><?= htmlspecialchars($sb['service_name']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($sb['service_date'])) ?></td>
                                            <td><?= htmlspecialchars($sb['quantity']) ?></td>
                                            <td class="text-danger fw-bold"><?= formatPrice($sb['total_price']) ?></td>
                                            <td>
                                                <?php
                                                $sstatus = $sb['status'] ?? 'pending';
                                                if ($sstatus == 'confirmed') {
                                                    echo '<span class="badge bg-success">Đã xác nhận</span>';
                                                } elseif ($sstatus == 'completed') {
                                                    echo '<span class="badge bg-primary">Hoàn thành</span>';
                                                } elseif ($sstatus == 'cancelled') {
                                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if (!empty($sb['booking_code'])): ?>
                                                    <?php if (($sb['payment_status'] ?? '') != 'paid'): ?>
                                                        <a href="payment-gateway.php?code=<?= htmlspecialchars($sb['booking_code']) ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-credit-card"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="invoice.php?code=<?= htmlspecialchars($sb['booking_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                                                            <i class="fa-solid fa-file-invoice"></i> Hóa đơn
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-box-seam fa-3x mb-3 text-light"></i>
                            <h5>Bạn chưa đặt dịch vụ cộng thêm nào</h5>
                            <a href="services.php" class="btn btn-primary mt-2">Xem danh sách Dịch vụ</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('tableFilter').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    
    // Tìm tab đang active
    let activeTab = document.querySelector('.tab-pane.active');
    if (activeTab) {
        let rows = activeTab.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.indexOf(value) > -1 ? '' : 'none';
        });
    }
});

// Khi chuyển tab thì apply lại filter nếu có
document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (event) {
        let eventObj = new Event('keyup');
        document.getElementById('tableFilter').dispatchEvent(eventObj);
    });
});
</script>

<?php include 'includes/footer.php'; ?>