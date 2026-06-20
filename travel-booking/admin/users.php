<?php
$page_title = "Quản lý Người Dùng";
require '../includes/db.php';

// Xử lý thay đổi trạng thái user (khóa/mở khóa)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $action = $_GET['action'];

    // Ngăn khóa chính mình
    if ($user_id == $_SESSION['user_id'] ?? 0) {
        $error = "Bạn không thể khóa tài khoản của chính mình!";
    } else {
        if ($action == 'ban') {
            mysqli_query($conn, "UPDATE users SET status = 'banned' WHERE id = $user_id");
            $success = "Đã khóa tài khoản thành công!";
        } elseif ($action == 'unban') {
            mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $user_id");
            $success = "Đã mở khóa tài khoản thành công!";
        }
    }
}

// Lấy danh sách users (trừ admin)
$search = $_GET['search'] ?? '';
$search_query = "";
if ($search) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $search_query = " AND (full_name LIKE '%$search_safe%' OR email LIKE '%$search_safe%') ";
}

$sql = "SELECT * FROM users WHERE role = 'user' $search_query ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="GET" action="users.php" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email..."
                    value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
            <?php if ($search): ?>
                <div class="col-md-2">
                    <a href="users.php" class="btn btn-secondary w-100">Xóa Lọc</a>
                </div>
            <?php endif; ?>
        </form>

        <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đăng ký</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($u = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['full_name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['phone'] ?? 'Chưa cập nhật') ?></td>
                            <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <?php if ($u['status'] == 'active'): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Bị khóa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="user-detail.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-info text-white"
                                    title="Chi tiết"><i class="bi bi-eye"></i></a>
                                
                                <a href="edit-user.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning"
                                    title="Chỉnh sửa"><i class="bi bi-pencil"></i></a>

                                <?php if ($u['status'] == 'active'): ?>
                                    <a href="users.php?action=ban&id=<?= $u['id'] ?>" class="btn btn-sm btn-secondary"
                                        title="Khóa tài khoản" onclick="return confirm('Khóa tài khoản này?');"><i
                                            class="bi bi-lock"></i></a>
                                <?php else: ?>
                                    <a href="users.php?action=unban&id=<?= $u['id'] ?>" class="btn btn-sm btn-success"
                                        title="Mở khóa" onclick="return confirm('Mở khóa tài khoản này?');"><i
                                            class="bi bi-unlock"></i></a>
                                <?php endif; ?>

                                <a href="delete-user.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger"
                                    title="Xóa vĩnh viễn" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn người dùng này không?');"><i
                                        class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không tìm thấy người dùng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>