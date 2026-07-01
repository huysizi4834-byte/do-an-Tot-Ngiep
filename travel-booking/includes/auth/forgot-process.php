<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    // Kiểm tra email tồn tại
    $check_query = "SELECT id FROM users WHERE email = '$email'";
    $check_res = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_res) > 0) {
        $token = bin2hex(random_bytes(32));

        $update_query = "UPDATE users SET reset_token = '$token', reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = '$email'";
        if (mysqli_query($conn, $update_query)) {
            // Hiển thị trực tiếp link để test (do không có hệ thống mail)
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 3) . "/reset-password.php?token=" . $token;
            
            // Xử lý lại đường dẫn một chút cho chắc chắn đúng thư mục gốc
            // Nếu PHP_SELF là /travel-booking/includes/auth/forgot-process.php
            // dirname(PHP_SELF, 3) = /travel-booking
            
            // Cách đơn giản hơn, trả về link tương đối:
            $reset_link = "reset-password.php?token=" . $token;

            $_SESSION['reset_message'] = "Yêu cầu khôi phục thành công. <br> <a href='../$reset_link'><b>Bấm vào đây để đặt lại mật khẩu</b></a> (Link test dành cho môi trường local).";
        } else {
            $_SESSION['reset_error'] = "Đã xảy ra lỗi khi tạo yêu cầu. Vui lòng thử lại.";
        }
    } else {
        $_SESSION['reset_error'] = "Không tìm thấy tài khoản với email này.";
    }

    header("Location: ../../forgot-password.php");
    exit;
}
