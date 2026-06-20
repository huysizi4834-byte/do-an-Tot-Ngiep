<?php
$page_title = "Chỉnh sửa Người Dùng";
require '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Truy cập bị từ chối.");
}

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}
$id = (int)$_GET['id'];

// Prevent editing oneself
if ($id == $_SESSION['user_id']) {
    die("Bạn không thể tự chỉnh sửa quyền của chính mình ở đây.");
}

// Lấy thông tin hiện tại
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user_info = mysqli_fetch_assoc($result);

if (!$user_info) {
    die("Không tìm thấy người dùng.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (!in_array($role, ['admin', 'user']) || !in_array($status, ['active', 'inactive', 'banned'])) {
        $error = "Dữ liệu không hợp lệ.";
    } else {
        $sql_update = "UPDATE users SET role = '$role', status = '$status' WHERE id = $id";
        
        if (mysqli_query($conn, $sql_update)) {
            $success = "Cập nhật tài khoản thành công!";
            $user_info['role'] = $role;
            $user_info['status'] = $status;
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Người dùng: <?= htmlspecialchars($user_info['email']) ?></h1>
    <a href="users.php" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ tên</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user_info['full_name']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user_info['email']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold">Vai trò (Role) <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" <?= $user_info['role'] == 'user' ? 'selected' : '' ?>>Khách hàng (User)</option>
                            <option value="admin" <?= $user_info['role'] == 'admin' ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?= $user_info['status'] == 'active' ? 'selected' : '' ?>>Hoạt động (Active)</option>
                            <option value="inactive" <?= $user_info['status'] == 'inactive' ? 'selected' : '' ?>>Chưa kích hoạt (Inactive)</option>
                            <option value="banned" <?= $user_info['status'] == 'banned' ? 'selected' : '' ?>>Bị khóa (Banned)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3"><i class="fa-solid fa-save me-2"></i> Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
