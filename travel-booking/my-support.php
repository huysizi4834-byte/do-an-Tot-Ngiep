<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$page_title = "Lịch sử Hỗ trợ";
require 'includes/db.php';

$user_id = (int)$_SESSION['user_id'];
$sql = "SELECT * FROM contacts WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary mb-0"><i class="fa-solid fa-headset me-2"></i> Lịch sử Hỗ trợ</h2>
                <a href="support.php" class="btn btn-outline-primary fw-bold rounded-pill"><i class="fa-solid fa-plus me-1"></i> Gửi yêu cầu mới</a>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($row['subject']) ?></h5>
                            <?php if ($row['status'] == 'new'): ?>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Đang chờ xử lý</span>
                            <?php elseif ($row['status'] == 'read'): ?>
                                <span class="badge bg-info text-white px-3 py-2 rounded-pill">Đang được xem xét</span>
                            <?php else: ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill">Đã phản hồi</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3"><i class="fa-regular fa-clock me-1"></i> Gửi lúc: <?= date('H:i d/m/Y', strtotime($row['created_at'])) ?></p>
                            <div class="bg-light p-3 rounded-3 mb-3 text-secondary" style="white-space: pre-line;">
                                <?= htmlspecialchars($row['message']) ?>
                            </div>
                            
                            <?php if (!empty($row['admin_reply'])): ?>
                                <div class="mt-4 ms-md-4">
                                    <h6 class="fw-bold text-primary mb-2"><i class="fa-solid fa-reply me-2"></i> Phản hồi từ THEGIOI Travel:</h6>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-dark border border-primary border-opacity-25" style="white-space: pre-line;">
                                        <?= htmlspecialchars($row['admin_reply']) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <i class="fa-solid fa-envelope-open-text text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                        <h5 class="text-muted mb-3">Bạn chưa có yêu cầu hỗ trợ nào.</h5>
                        <p class="text-secondary mb-4">Nếu bạn cần tư vấn hay hỗ trợ, hãy gửi tin nhắn cho chúng tôi nhé.</p>
                        <a href="support.php" class="btn btn-primary fw-bold px-4 rounded-pill">Liên hệ ngay</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
