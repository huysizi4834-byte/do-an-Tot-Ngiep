<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: dashboard.php");
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? AND role='admin' LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['status'] == 'banned') {
            $error = "Tài khoản của bạn đã bị khóa!";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $error = "Email hoặc mật khẩu không đúng, hoặc bạn không có quyền Admin!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - TheGioi Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="text-center mb-4">
            <h2>Admin Panel</h2>
            <p class="text-muted">Đăng nhập để quản trị hệ thống</p>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Admin</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@thegioi.vn" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="admin123" required>
                    </div>
                    <div class="mb-3 form-check">   
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="../index.php" class="text-decoration-none">&larr; Quay lại trang chủ</a>
        </div>
    </div>
</body>

</html>