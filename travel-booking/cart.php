<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <i class="fa-solid fa-cart-shopping text-muted mb-4" style="font-size: 80px;"></i>
            <h2 class="fw-bold mb-3">Giỏ hàng của bạn đang trống</h2>
            <p class="text-muted mb-4">Hãy tiếp tục khám phá các tour du lịch và dịch vụ hấp dẫn của chúng tôi.</p>
            <a href="index.php" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">Tiếp tục tìm kiếm</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
