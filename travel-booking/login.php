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
    <title>Đăng nhập - TheGioi Travel</title>

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
                        Đăng nhập để tiếp tục hành trình của bạn
                    </p>

                </div>

                <?php if (isset($_SESSION['login_message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['login_message']; ?>
                        <?php unset($_SESSION['login_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['login_error']; ?>
                        <?php unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="includes/auth/login-process.php" method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" name="email" class="form-control" placeholder="Nhập email" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Mật khẩu
                        </label>

                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                            required>

                    </div>

                    <div class="d-flex justify-content-between mb-4">

                        <div class="form-check">

                            <input class="form-check-input" type="checkbox" id="remember">

                            <label class="form-check-label" for="remember">

                                Ghi nhớ đăng nhập

                            </label>

                        </div>

                        <a href="forgot-password.php">
                            Quên mật khẩu?
                        </a>

                    </div>

                    <button type="submit" class="btn btn-primary w-100 login-btn">

                        Đăng nhập

                    </button>

                </form>

                <hr>

                <div class="text-center">

                    Chưa có tài khoản?

                    <a href="register.php">
                        Đăng ký ngay
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>