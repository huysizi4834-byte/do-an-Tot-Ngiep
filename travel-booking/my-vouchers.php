<?php
session_start();
$page_title = "Kho Voucher Của Tôi";
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy danh sách voucher trong ví
$sql = "SELECT up.*, p.code, p.discount_type, p.discount_value, p.end_date, p.usage_limit, p.used_count 
        FROM user_promotions up 
        JOIN promotions p ON up.promotion_id = p.id 
        WHERE up.user_id = $user_id 
        ORDER BY up.status ASC, p.end_date ASC";
$res = mysqli_query($conn, $sql);
$vouchers = [];
while ($row = mysqli_fetch_assoc($res)) {
    $vouchers[] = $row;
}

include 'includes/header.php';
?>

<div class="container py-5" style="min-height: 600px;">
    <h2 class="fw-bold mb-4"><i class="fa-solid fa-ticket-simple text-danger"></i> Kho Voucher Của Tôi</h2>

    <div class="row">
        <?php if (count($vouchers) > 0): ?>
            <?php foreach ($vouchers as $v): ?>
                <?php 
                $is_expired = strtotime($v['end_date']) < strtotime('today');
                $is_used = $v['status'] == 'used';
                $is_disabled = $is_expired || $is_used;
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="voucher-card d-flex border rounded overflow-hidden shadow-sm position-relative" style="<?= $is_disabled ? 'opacity: 0.6; filter: grayscale(100%);' : '' ?>">
                        <div class="voucher-left bg-danger text-white d-flex flex-column justify-content-center align-items-center p-3" style="width: 35%; border-right: 2px dashed #fff;">
                            <?php if ($v['discount_type'] === 'percent'): ?>
                                <span class="fs-2 fw-bold"><?= floatval($v['discount_value']) ?>%</span>
                            <?php else: ?>
                                <span class="fs-4 fw-bold"><?= number_format($v['discount_value']) ?>đ</span>
                            <?php endif; ?>
                            <small class="text-uppercase text-center" style="font-size: 10px;">Giảm giá</small>
                        </div>
                        <div class="voucher-right bg-white p-3 d-flex flex-column justify-content-between" style="width: 65%;">
                            <div>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($v['code']) ?></h5>
                                <p class="text-muted small mb-0">HSD: <?= date('d/m/Y', strtotime($v['end_date'])) ?></p>
                            </div>
                            <div class="mt-3 text-end">
                                <?php if ($is_used): ?>
                                    <span class="badge bg-secondary">Đã sử dụng</span>
                                <?php elseif ($is_expired): ?>
                                    <span class="badge bg-danger">Đã hết hạn</span>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="copyCode('<?= $v['code'] ?>')">Copy Mã</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cut-circle top"></div>
                        <div class="cut-circle bottom"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-folder-open fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Ví của bạn chưa có voucher nào.</h5>
                <a href="voucher-center.php" class="btn btn-danger mt-3">Đi săn mã ngay!</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.cut-circle {
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: #f8fafc; /* match body bg */
    border-radius: 50%;
    left: 35%;
    transform: translateX(-50%);
    border-right: 1px solid #dee2e6;
}
.cut-circle.top {
    top: -10px;
    border-bottom: 1px solid #dee2e6;
}
.cut-circle.bottom {
    bottom: -10px;
    border-top: 1px solid #dee2e6;
}
</style>

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        alert('Đã copy mã: ' + code + '. Bạn có thể dán ở bước thanh toán!');
    }, function(err) {
        alert('Không thể copy mã, vui lòng thao tác thủ công.');
    });
}
</script>

<?php include 'includes/footer.php'; ?>
