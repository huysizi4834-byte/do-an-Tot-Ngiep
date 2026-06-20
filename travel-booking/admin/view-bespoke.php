<?php
$page_title = "Chi tiết Yêu cầu Bespoke";
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: bespoke.php");
    exit();
}

$id = (int)$_GET['id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $admin_note = mysqli_real_escape_string($conn, $_POST['admin_note']);
    
    $update_sql = "UPDATE bespoke_requests SET status = '$status', admin_note = '$admin_note' WHERE id = $id";
    if (mysqli_query($conn, $update_sql)) {
        $success = "Cập nhật yêu cầu thành công.";
    } else {
        $error = "Lỗi Cập nhật: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM bespoke_requests WHERE id = $id";
$result = mysqli_query($conn, $sql);
$req = mysqli_fetch_assoc($result);

if (!$req) {
    header("Location: bespoke.php");
    exit();
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Chi tiết Yêu cầu Bespoke #<?= $id ?></h2>
    <a href="bespoke.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">Thông tin Yêu cầu Tour</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Điểm đến mong muốn:</div>
                    <div class="col-sm-8 fw-bold text-primary fs-5"><?= htmlspecialchars($req['destination']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Ngày khởi hành:</div>
                    <div class="col-sm-8 fw-bold"><?= date('d/m/Y', strtotime($req['start_date'])) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Thời lượng:</div>
                    <div class="col-sm-8 fw-bold"><?= $req['duration'] ?> ngày</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Số lượng khách:</div>
                    <div class="col-sm-8 fw-bold"><?= $req['pax'] ?> người</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Ngân sách dự kiến:</div>
                    <div class="col-sm-8 fw-bold text-success"><?= htmlspecialchars($req['budget']) ?></div>
                </div>
                <hr>
                <div class="mb-2 text-muted">Yêu cầu đặc biệt:</div>
                <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-line;">
                    <?= htmlspecialchars($req['requirements']) ?: 'Không có ghi chú thêm.' ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">Thông tin Khách hàng</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-size: 20px;">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($req['name']) ?></h6>
                        <small class="text-muted">Gửi lúc: <?= date('H:i d/m/Y', strtotime($req['created_at'])) ?></small>
                    </div>
                </div>
                <div class="mb-2"><i class="bi bi-telephone text-muted me-2"></i> <?= htmlspecialchars($req['phone']) ?></div>
                <div class="mb-2"><i class="bi bi-envelope text-muted me-2"></i> <?= htmlspecialchars($req['email']) ?></div>
                <?php if ($req['user_id']): ?>
                    <div class="mt-3"><span class="badge bg-info text-white">Khách hàng thành viên (ID: <?= $req['user_id'] ?>)</span></div>
                <?php else: ?>
                    <div class="mt-3"><span class="badge bg-secondary">Khách vãng lai</span></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">Xử lý Yêu cầu</h5>
            </div>
            <div class="card-body p-4">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="new" <?= ($req['status'] == 'new') ? 'selected' : '' ?>>Yêu cầu mới</option>
                            <option value="processing" <?= ($req['status'] == 'processing') ? 'selected' : '' ?>>Đang xử lý / Đã liên hệ</option>
                            <option value="completed" <?= ($req['status'] == 'completed') ? 'selected' : '' ?>>Đã hoàn thành</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Ghi chú của Admin</label>
                        <textarea name="admin_note" class="form-control" rows="4" placeholder="Nhập tiến độ xử lý, ghi chú cá nhân..."><?= htmlspecialchars($req['admin_note'] ?? '') ?></textarea>
                        <small class="text-muted">Ghi chú này giúp đội ngũ theo dõi tiến trình làm việc với khách.</small>
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold w-100">Cập nhật Xử lý</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
