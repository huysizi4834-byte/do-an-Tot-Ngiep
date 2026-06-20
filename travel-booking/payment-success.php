<?php
require 'includes/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['code'])) {
    die("Mã đơn hàng không hợp lệ.");
}

$code = mysqli_real_escape_string($conn, $_GET['code']);
include 'includes/header.php';
?>

<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle"
                        style="width: 100px; height: 100px;">
                        <i class="fa-solid fa-check fa-4x"></i>
                    </div>
                </div>

                <?php
                $prefix = substr($code, 0, 2);
                $type_text = "Đơn hàng";
                if ($prefix === 'HT')
                    $type_text = "Đơn đặt phòng";
                elseif ($prefix === 'FL')
                    $type_text = "Đơn vé máy bay";
                elseif ($prefix === 'TR')
                    $type_text = "Đơn đặt tour";
                elseif ($prefix === 'SV')
                    $type_text = "Đơn đặt dịch vụ";
                elseif ($prefix === 'CB')
                    $type_text = "Đơn đặt combo";
                ?>
                <h2 class="fw-bold text-success mb-3">Thanh Toán Thành Công!</h2>
                <p class="text-muted fs-5 mb-4">Cảm ơn bạn đã tin tưởng dịch vụ của THEGIOI Travel & Tour.
                    <?= $type_text ?> <strong>#<?= htmlspecialchars($code) ?></strong> đã được thanh toán và xác nhận.
                </p>

                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="invoice.php?code=<?= htmlspecialchars($code) ?>" target="_blank"
                        class="btn btn-outline-primary btn-lg px-4 rounded-pill">
                        <i class="fa-solid fa-print me-2"></i> Xem & In Hóa Đơn
                    </a>
                    <a href="my-bookings.php" class="btn btn-primary btn-lg px-4 rounded-pill">
                        <i class="fa-solid fa-suitcase-rolling me-2"></i> Xem chuyến đi của tôi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    // Bắn pháo hoa chúc mừng
    var duration = 3 * 1000;
    var animationEnd = Date.now() + duration;
    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    var interval = setInterval(function () {
        var timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        var particleCount = 50 * (timeLeft / duration);
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
        }));
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
        }));
    }, 250);
</script>

<?php include 'includes/footer.php'; ?>