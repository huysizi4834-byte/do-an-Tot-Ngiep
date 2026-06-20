<?php

require __DIR__ . '/../db.php';

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {

    echo "
    <script>
        alert('Mật khẩu xác nhận không khớp');
        history.back();
    </script>";
    exit;
}

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM users WHERE email=?"
);

mysqli_stmt_bind_param(
    $check,
    "s",
    $email
);

mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result) > 0) {

    echo "
    <script>
        alert('Email đã tồn tại');
        history.back();
    </script>";
    exit;
}

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO users
    (
        full_name,
        email,
        phone,
        password_hash,
        role,
        status,
        created_at
    )
    VALUES
    (
        ?, ?, ?, ?,
        'user',
        'active',
        NOW()
    )"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $full_name,
    $email,
    $phone,
    $password_hash
);

if (mysqli_stmt_execute($stmt)) {

    echo "
    <script>
        alert('Đăng ký thành công');
        window.location='../../login.php';
    </script>";

} else {

    echo "
    <script>
        alert('Có lỗi xảy ra');
        history.back();
    </script>";
}