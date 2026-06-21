<?php
$page_title = "Dashboard";
require '../includes/db.php';
include 'includes/admin-header.php';

// 1. Thống kê tổng số Tours
$tour_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tours");
$total_tours = mysqli_fetch_assoc($tour_query)['total'] ?? 0;

// 2. Thống kê đơn đặt mới (chờ duyệt) tổng cộng
$new_bookings = 0;
$bk_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE booking_status = 'pending'");
$new_bookings += mysqli_fetch_assoc($bk_q)['total'] ?? 0;
$hb_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM hotel_bookings WHERE booking_status = 'pending'");
$new_bookings += mysqli_fetch_assoc($hb_q)['total'] ?? 0;
$fb_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM flight_bookings WHERE booking_status = 'pending'");
$new_bookings += mysqli_fetch_assoc($fb_q)['total'] ?? 0;
$cb_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM combo_bookings WHERE status = 'pending'");
$new_bookings += mysqli_fetch_assoc($cb_q)['total'] ?? 0;
$sb_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM service_bookings WHERE status = 'pending'");
$new_bookings += mysqli_fetch_assoc($sb_q)['total'] ?? 0;

// 3. Thống kê người dùng
$user_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$total_users = mysqli_fetch_assoc($user_query)['total'] ?? 0;

// 4. Thống kê tổng doanh thu và Lịch sử (Theo Tháng hoặc Tuần)
$view = $_GET['view'] ?? 'month';
$history = [];

if ($view === 'day') {
    // 14 ngày gần nhất
    for ($i = 0; $i < 14; $i++) {
        $day = date('Y-m-d', strtotime("-$i days"));
        $history[$day] = 0;
    }
    $date_expr = "DATE(b.created_at)";
    $date_expr_no_b = "DATE(created_at)";
    $interval = "14 DAY";
} elseif ($view === 'week') {
    // 12 tuần gần nhất
    for ($i = 0; $i < 12; $i++) {
        $monday = date('Y-m-d', strtotime("monday this week -$i week"));
        $history[$monday] = 0;
    }
    // MySQL WEEKDAY() trả về 0 cho Thứ 2, 6 cho Chủ nhật. 
    $date_expr = "DATE(b.created_at - INTERVAL WEEKDAY(b.created_at) DAY)";
    $date_expr_no_b = "DATE(created_at - INTERVAL WEEKDAY(created_at) DAY)";
    $interval = "12 WEEK";
} else {
    // 6 tháng gần nhất
    for ($i = 0; $i < 6; $i++) {
        $month = date('Y-m', strtotime("first day of this month -$i month"));
        $history[$month] = 0;
    }
    $date_expr = "DATE_FORMAT(b.created_at, '%Y-%m')";
    $date_expr_no_b = "DATE_FORMAT(created_at, '%Y-%m')";
    $interval = "6 MONTH";
}

// Hàm query gom nhóm
$queries = [
    "SELECT $date_expr as m, SUM(b.total_people * t.price) as total FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.booking_status IN ('confirmed', 'approved', 'completed') AND b.created_at >= DATE_SUB(NOW(), INTERVAL $interval) GROUP BY m",
    "SELECT $date_expr_no_b as m, SUM(total_amount) as total FROM hotel_bookings WHERE booking_status IN ('confirmed', 'completed') AND created_at >= DATE_SUB(NOW(), INTERVAL $interval) GROUP BY m",
    "SELECT $date_expr_no_b as m, SUM(total_amount) as total FROM flight_bookings WHERE booking_status IN ('confirmed', 'completed') AND created_at >= DATE_SUB(NOW(), INTERVAL $interval) GROUP BY m",
    "SELECT $date_expr_no_b as m, SUM(total_price) as total FROM combo_bookings WHERE status IN ('confirmed', 'completed') AND created_at >= DATE_SUB(NOW(), INTERVAL $interval) GROUP BY m",
    "SELECT $date_expr_no_b as m, SUM(total_price) as total FROM service_bookings WHERE status IN ('confirmed', 'completed') AND created_at >= DATE_SUB(NOW(), INTERVAL $interval) GROUP BY m"
];

foreach ($queries as $q) {
    $res = mysqli_query($conn, $q);
    if ($res) {
        while($row = mysqli_fetch_assoc($res)) {
            if(isset($history[$row['m']])) {
                $history[$row['m']] += $row['total'];
            }
        }
    }
}

// Chuẩn bị dữ liệu cho Chart.js (đảo ngược mảng để cũ nhất đứng trước)
$chart_labels = array_reverse(array_keys($history));
$chart_data = array_reverse(array_values($history));

// Doanh thu tháng hiện tại
$current_month = date('Y-m');
$revenue = 0;
// Nếu đang view week thì lấy lại doanh thu tháng này để hiển thị trên card
$rev_q = "SELECT SUM(total) as current_rev FROM (
    SELECT SUM(b.total_people * t.price) as total FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.booking_status IN ('confirmed', 'approved', 'completed') AND DATE_FORMAT(b.created_at, '%Y-%m') = '$current_month'
    UNION ALL SELECT SUM(total_amount) as total FROM hotel_bookings WHERE booking_status IN ('confirmed', 'completed') AND DATE_FORMAT(created_at, '%Y-%m') = '$current_month'
    UNION ALL SELECT SUM(total_amount) as total FROM flight_bookings WHERE booking_status IN ('confirmed', 'completed') AND DATE_FORMAT(created_at, '%Y-%m') = '$current_month'
    UNION ALL SELECT SUM(total_price) as total FROM combo_bookings WHERE status IN ('confirmed', 'completed') AND DATE_FORMAT(created_at, '%Y-%m') = '$current_month'
    UNION ALL SELECT SUM(total_price) as total FROM service_bookings WHERE status IN ('confirmed', 'completed') AND DATE_FORMAT(created_at, '%Y-%m') = '$current_month'
) as rev_table";
$rev_res = mysqli_query($conn, $rev_q);
if ($rev_res) {
    $revenue = mysqli_fetch_assoc($rev_res)['current_rev'] ?? 0;
}

// 5. Lấy danh sách 5 đơn đặt gần đây nhất
$recent_bookings_sql = "
    SELECT b.*, u.full_name, t.title 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN tours t ON b.tour_id = t.id 
    ORDER BY b.created_at DESC 
    LIMIT 5
";
$recent_bookings_result = mysqli_query($conn, $recent_bookings_sql);
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Tổng số Tours</h5>
                <h2 class="card-text"><?= $total_tours ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Đơn chờ duyệt</h5>
                <h2 class="card-text"><?= $new_bookings ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Khách hàng</h5>
                <h2 class="card-text"><?= $total_users ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Doanh thu (Tháng <?= date('m') ?>)</h5>
                <h2 class="card-text">
                    <?php
                    if ($revenue >= 1000000) {
                        echo round($revenue / 1000000, 1) . 'M ₫';
                    } else {
                        echo number_format($revenue) . ' ₫';
                    }
                    ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mt-4">
            <div class="card-header bg-white fw-bold">
                Đơn đặt gần đây
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Mã ĐĐ</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($recent_bookings_result) > 0): ?>
                            <?php while ($bk = mysqli_fetch_assoc($recent_bookings_result)): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($bk['id']) ?></td>
                                    <td><?= htmlspecialchars($bk['full_name']) ?></td>
                                    <td><?= htmlspecialchars($bk['title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($bk['created_at'])) ?></td>
                                    <td>
                                        <?php
                                        $status = $bk['booking_status'];
                                        if ($status == 'confirmed' || $status == 'approved') {
                                            echo '<span class="badge bg-success">Đã duyệt</span>';
                                        } elseif ($status == 'completed') {
                                            echo '<span class="badge bg-primary">Hoàn thành</span>';
                                        } elseif ($status == 'cancelled') {
                                            echo '<span class="badge bg-danger">Đã hủy</span>';
                                        } else {
                                            echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="booking-detail.php?id=<?= $bk['id'] ?>" class="btn btn-sm btn-info text-white"><i
                                                class="bi bi-eye"></i> Xem</a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Chưa có lượt đặt tour nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card mt-4" id="report-section">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-chart-bar me-2"></i> Báo cáo Doanh thu</span>
                <div>
                    <a href="?view=day" class="btn btn-sm <?= $view === 'day' ? 'btn-primary' : 'btn-outline-primary' ?>">Theo Ngày</a>
                    <a href="?view=week" class="btn btn-sm <?= $view === 'week' ? 'btn-primary' : 'btn-outline-primary' ?> ms-1">Theo Tuần</a>
                    <a href="?view=month" class="btn btn-sm <?= $view === 'month' ? 'btn-primary' : 'btn-outline-primary' ?> ms-1">Theo Tháng</a>
                    <button id="exportPdfBtn" onclick="exportPDF()" class="btn btn-sm btn-danger ms-2"><i class="fa-solid fa-file-pdf me-1"></i> Xuất PDF</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Biểu đồ -->
                    <div class="col-md-8">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                    <!-- Danh sách dữ liệu -->
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-3">Dữ liệu chi tiết</h6>
                        <ul id="data-list-ul" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                            <?php foreach($history as $m => $val): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $view === 'day' ? 'Ngày ' . date('d/m/Y', strtotime($m)) : ($view === 'week' ? 'Tuần ' . date('d/m/Y', strtotime($m)) : 'Tháng ' . date('m/Y', strtotime($m . '-01'))) ?>
                                <span class="fw-bold text-danger"><?= number_format($val) ?> ₫</span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const labels = <?= json_encode($chart_labels) ?>;
    const dataVals = <?= json_encode($chart_data) ?>;
    const viewType = '<?= $view ?>';
    
    // Định dạng lại nhãn cho đẹp
    const formattedLabels = labels.map(label => {
        if (viewType === 'day') {
            const parts = label.split('-');
            return parts[2] + '/' + parts[1]; // Ngày/Tháng
        } else if (viewType === 'week') {
            const parts = label.split('-');
            return parts[2] + '/' + parts[1]; // Ngày/Tháng
        } else {
            const parts = label.split('-');
            return 'T' + parts[1] + '/' + parts[0]; // TTháng/Năm
        }
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: formattedLabels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: dataVals,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: viewType === 'day' ? 'Biểu đồ Doanh thu (14 ngày gần nhất)' : (viewType === 'week' ? 'Biểu đồ Doanh thu (12 tuần gần nhất)' : 'Biểu đồ Doanh thu (6 tháng gần nhất)')
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'M';
                            }
                            return value;
                        }
                    }
                }
            }
        }
    });

    function exportPDF() {
        const element = document.getElementById('report-section');
        
        // Cấu hình html2pdf
        const opt = {
            margin:       10,
            filename:     'BaoCaoDoanhThu_' + viewType + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2, 
                scrollY: 0,
                useCORS: true 
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        // UI Feedback
        const btn = document.getElementById('exportPdfBtn');
        const oldText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang xuất...';
        btn.disabled = true;

        // Lưu lại CSS cũ để sửa lỗi html2canvas bị cắt hình (do overflow, flex)
        const listEl = document.getElementById('data-list-ul');
        const oldMaxHeight = listEl.style.maxHeight;
        const oldOverflow = listEl.style.overflowY;
        
        // Tạm thời hiển thị toàn bộ list và ẩn nút xuất
        listEl.style.maxHeight = 'none';
        listEl.style.overflowY = 'visible';
        btn.style.display = 'none';

        // Thực hiện xuất PDF
        html2pdf().set(opt).from(element).save().then(() => {
            // Phục hồi lại CSS ban đầu
            listEl.style.maxHeight = oldMaxHeight;
            listEl.style.overflowY = oldOverflow;
            btn.style.display = 'inline-block';
            btn.innerHTML = oldText;
            btn.disabled = false;
        });
    }
</script>
</div>

<?php include 'includes/admin-footer.php'; ?>