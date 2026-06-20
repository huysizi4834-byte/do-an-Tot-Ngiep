<?php

session_start();

require '../db.php';

$user_id = $_SESSION['user_id'];

$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT password_hash
     FROM users
     WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

if (
    !password_verify(
        $old_password,
        $user['password_hash']
    )
) {

    die("Mật khẩu cũ không đúng");
}

$new_hash = password_hash(
    $new_password,
    PASSWORD_DEFAULT
);

$stmt = mysqli_prepare(
    $conn,
    "UPDATE users
     SET password_hash=?
     WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $new_hash,
    $user_id
);

mysqli_stmt_execute($stmt);

header("Location: ../../profile.php");
exit;