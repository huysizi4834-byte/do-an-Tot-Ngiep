<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = mysqli_real_escape_string($conn, trim($_POST['token']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($token)) {
        header("Location: ../../login.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['reset_error'] = "Mật khẩu xác nhận không khớp.";
        header("Location: ../../reset-password.php?token=$token");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['reset_error'] = "Mật khẩu phải có ít nhất 6 ký tự.";
        header("Location: ../../reset-password.php?token=$token");
        exit;
    }

    // Kiểm tra token có hợp lệ không
    $query = "SELECT id FROM users WHERE reset_token = '$token' AND reset_expires > NOW()";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Cập nhật mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password_hash = '$hashed_password', reset_token = NULL, reset_expires = NULL WHERE reset_token = '$token'";
        
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['login_message'] = "Đặt lại mật khẩu thành công! Bạn có thể đăng nhập ngay bây giờ.";
            header("Location: ../../login.php");
            exit;
        } else {
            $_SESSION['reset_error'] = "Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại.";
            header("Location: ../../reset-password.php?token=$token");
            exit;
        }
    } else {
        $_SESSION['reset_error'] = "Liên kết đã hết hạn hoặc không hợp lệ.";
        header("Location: ../../reset-password.php?token=$token");
        exit;
    }
}
