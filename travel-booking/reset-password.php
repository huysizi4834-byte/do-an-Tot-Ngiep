<?php
session_start();
require 'includes/db.php';

$valid_token = false;
$token = '';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, trim($_GET['token']));
    
    // Kiểm tra token có hợp lệ và chưa hết hạn
    $query = "SELECT id FROM users WHERE reset_token = '$token' AND reset_expires > NOW()";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $valid_token = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - TheGioi Travel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="login-page">

        <div class="login-overlay">

            <div class="login-card">

                <div class="text-center mb-4">

                    <h2 class="login-logo">
                        THEGIOI
                    </h2>

                    <p class="text-muted">
                        Đặt lại mật khẩu mới
                    </p>

                </div>

                <?php if (isset($_SESSION['reset_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['reset_error']; ?>
                        <?php unset($_SESSION['reset_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if ($valid_token): ?>
                    <form action="includes/auth/reset-process.php" method="POST">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới" required minlength="6">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu" required minlength="6">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 login-btn mb-3">
                            Cập nhật mật khẩu
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger">
                        Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.
                    </div>
                    <div class="text-center">
                        <a href="forgot-password.php" class="btn btn-outline-primary mt-3">Gửi lại yêu cầu</a>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</body>

</html>
