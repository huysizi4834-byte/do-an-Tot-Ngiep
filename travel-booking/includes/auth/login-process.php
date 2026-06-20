<?php
session_start();

require '../db.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password_hash'])) {
    
    if ($user['status'] == 'banned') {
        // Tài khoản bị khóa
        echo "<script>alert('Tài khoản của bạn đã bị khóa! Vui lòng liên hệ Admin.'); window.location.href='../../login.php';</script>";
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: ../../admin/dashboard.php");
    } else {
        header("Location: ../../index.php");
    }
    exit;
} else {
    echo "<script>alert('Email hoặc mật khẩu không đúng!'); window.location.href='../../login.php';</script>";
    exit;
}