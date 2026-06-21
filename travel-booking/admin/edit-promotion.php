<?php
$page_title = "Sửa Khuyến mại";
require '../includes/db.php';
include 'includes/admin-header.php';

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID.");
}

$id = intval($_GET['id']);
$error = '';
$success = '';

// Lấy thông tin hiện tại
$sql_get = "SELECT * FROM promotions WHERE id = $id";
$result_get = mysqli_query($conn, $sql_get);
if (mysqli_num_rows($result_get) === 0) {
    die("Khuyến mại không tồn tại.");
}
$promo = mysqli_fetch_assoc($result_get);

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
        // Kiểm tra trùng code (trừ chính nó)
        $check_sql = "SELECT id FROM promotions WHERE code = '$code' AND id != $id";
        $check_res = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check_res) > 0) {
            $error = "Mã khuyến mại này đã tồn tại!";
        } else {
            $sql_update = "UPDATE promotions SET 
                            code = '$code', 
                            discount_type = '$discount_type', 
                            discount_value = $discount_value, 
                            start_date = '$start_date', 
                            end_date = '$end_date', 
                            usage_limit = $usage_limit, 
                            status = '$status'
                           WHERE id = $id";
            
            if (mysqli_query($conn, $sql_update)) {
                $success = "Cập nhật mã khuyến mại thành công!";
                // Cập nhật lại data hiển thị
                $promo['code'] = $code;
                $promo['discount_type'] = $discount_type;
                $promo['discount_value'] = $discount_value;
                $promo['start_date'] = $start_date;
                $promo['end_date'] = $end_date;
                $promo['usage_limit'] = !empty($_POST['usage_limit']) ? intval($_POST['usage_limit']) : null;
                $promo['status'] = $status;
            } else {
                $error = "Lỗi khi cập nhật: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="card max-w-800 mx-auto" style="max-width: 800px;">
    <div class="card-header bg-white fw-bold">
        Sửa Khuyến mại #<?= $id ?>
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
                    <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($promo['code']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active" <?= $promo['status'] == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= $promo['status'] == 'inactive' ? 'selected' : '' ?>>Tạm dừng</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percent" <?= $promo['discount_type'] == 'percent' ? 'selected' : '' ?>>Phần trăm (%)</option>
                        <option value="amount" <?= $promo['discount_type'] == 'amount' ? 'selected' : '' ?>>Số tiền mặt (VNĐ)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" class="form-control" step="0.01" value="<?= floatval($promo['discount_value']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="<?= $promo['start_date'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control" value="<?= $promo['end_date'] ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Giới hạn số lần sử dụng (Bỏ trống nếu không giới hạn)</label>
                <input type="number" name="usage_limit" class="form-control" value="<?= $promo['usage_limit'] ?>">
                <div class="form-text">Đã sử dụng: <?= $promo['used_count'] ?> lần.</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="promotions.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhật mã khuyến mại</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
