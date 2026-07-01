<?php
require 'includes/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['descriptor'])) {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu khuôn mặt.']);
    exit;
}

// Convert descriptor array back to JSON string to save in DB
$descriptor_json = json_encode($data['descriptor']);
$descriptor_safe = mysqli_real_escape_string($conn, $descriptor_json);

$face_image_path = null;
if (isset($data['image']) && !empty($data['image'])) {
    $image_parts = explode(";base64,", $data['image']);
    if (count($image_parts) == 2) {
        $image_base64 = base64_decode($image_parts[1]);
        
        $dir = 'uploads/faces/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        // delete old file if it exists? We can just overwrite or use unique name. 
        // Unique name is better to avoid caching.
        $filename = 'user_' . $user_id . '_' . time() . '.jpg';
        $file_path = $dir . $filename;
        if (file_put_contents($file_path, $image_base64)) {
            $face_image_path = $file_path;
        }
    }
}

if ($face_image_path) {
    $face_image_safe = mysqli_real_escape_string($conn, $face_image_path);
    $sql = "UPDATE users SET face_descriptor = '$descriptor_safe', face_image = '$face_image_safe' WHERE id = $user_id";
} else {
    $sql = "UPDATE users SET face_descriptor = '$descriptor_safe' WHERE id = $user_id";
}

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Lưu Face ID thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi DB: ' . mysqli_error($conn)]);
}
exit;
