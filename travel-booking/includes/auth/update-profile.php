<?php
session_start();
require '../db.php';

$user_id = $_SESSION['user_id'];
$full_name = trim($_POST['full_name']);
$phone = trim($_POST['phone']);

// Xử lý avatar
$avatar_path = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = '../../assets/uploads/avatars/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_exts)) {
        $new_filename = 'avatar_' . $user_id . '_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
            $avatar_path = 'assets/uploads/avatars/' . $new_filename;
        }
    }
}

if ($avatar_path) {
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name=?, phone=?, avatar=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $full_name, $phone, $avatar_path, $user_id);
} else {
    $stmt = mysqli_prepare($conn, "UPDATE users SET full_name=?, phone=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $full_name, $phone, $user_id);
}

mysqli_stmt_execute($stmt);

// Cập nhật lại session
$_SESSION['full_name'] = $full_name;

header("Location: ../../profile.php");
exit;