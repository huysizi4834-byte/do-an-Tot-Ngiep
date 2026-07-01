<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - TheGioi Travel</title>

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
                        Vui lòng nhập email của bạn để lấy lại mật khẩu
                    </p>

                </div>

                <?php if (isset($_SESSION['reset_message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['reset_message']; ?>
                        <?php unset($_SESSION['reset_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['reset_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['reset_error']; ?>
                        <?php unset($_SESSION['reset_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="includes/auth/forgot-process.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email đã đăng ký" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 login-btn mb-3">
                        Gửi yêu cầu
                    </button>

                    <div class="text-center">
                        <a href="login.php">Quay lại trang đăng nhập</a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
