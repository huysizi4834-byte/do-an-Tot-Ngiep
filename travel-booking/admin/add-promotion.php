<?php
$page_title = "Thêm Khuyến mại mới";
require '../includes/db.php';
include 'includes/admin-header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = mysqli_real_escape_string($conn, trim($_POST['code']));
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $usage_limit = !empty($_POST['usage_limit']) ? intval($_POST['usage_limit']) : 'NULL';
    $status = $_POST['status'];

    if (empty($code) || empty($discount_value) || empty($start_date) || empty($end_date)) {
        $error = "Vui lòng nhập đầy đủ thông tin bắt buộc.";
    } else {
        // Kiểm tra trùng code
        $check_sql = "SELECT id FROM promotions WHERE code = '$code'";
        $check_res = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check_res) > 0) {
            $error = "Mã khuyến mại này đã tồn tại!";
        } else {
            $sql = "INSERT INTO promotions (code, discount_type, discount_value, start_date, end_date, usage_limit, status) 
                    VALUES ('$code', '$discount_type', $discount_value, '$start_date', '$end_date', $usage_limit, '$status')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Thêm mã khuyến mại thành công!";
            } else {
                $error = "Lỗi khi thêm: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="card max-w-800 mx-auto" style="max-width: 800px;">
    <div class="card-header bg-white fw-bold">
        Thêm Khuyến mại mới
    </div>
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Mã Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" placeholder="Ví dụ: SUMMER2026" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm dừng</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percent">Phần trăm (%)</option>
                        <option value="amount">Số tiền mặt (VNĐ)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" class="form-control" step="0.01" placeholder="Nhập giá trị..." required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Giới hạn số lần sử dụng (Bỏ trống nếu không giới hạn)</label>
                <input type="number" name="usage_limit" class="form-control" placeholder="Ví dụ: 100">
            </div>

            <div class="d-flex justify-content-between">
                <a href="promotions.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Lưu mã khuyến mại</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
