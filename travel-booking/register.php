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
    <title>Đăng ký - TheGioi Travel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="login-page">

        <div class="login-overlay">

            <div class="login-card register-card">

                <div class="text-center mb-4">

                    <h2 class="login-logo">
                        THEGIOI
                    </h2>

                    <p class="text-muted">
                        Tạo tài khoản mới
                    </p>

                </div>

                <form action="includes/auth/register-process.php" method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Họ và tên
                        </label>

                        <input type="text" name="full_name" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" name="email" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Số điện thoại
                        </label>

                        <input type="text" name="phone" class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Mật khẩu
                        </label>

                        <input type="password" name="password" class="form-control" required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Xác nhận mật khẩu
                        </label>

                        <input type="password" name="confirm_password" class="form-control" required>

                    </div>

                    <button type="submit" class="btn btn-primary w-100 login-btn">

                        Đăng ký

                    </button>

                </form>

                <hr>

                <div class="text-center">

                    Đã có tài khoản?

                    <a href="login.php">
                        Đăng nhập
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>