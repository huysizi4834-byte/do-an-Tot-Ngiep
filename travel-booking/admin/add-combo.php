<?php
$page_title = "Thêm Combo Mới";
require '../includes/db.php';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float) $_POST['price'];
    $original_price = !empty($_POST['original_price']) ? (float) $_POST['original_price'] : "NULL";
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $highlights = mysqli_real_escape_string($conn, $_POST['highlights'] ?? '');
    $price_details = mysqli_real_escape_string($conn, $_POST['price_details'] ?? '');
    $hotel_system = mysqli_real_escape_string($conn, $_POST['hotel_system'] ?? '');
    $policy = mysqli_real_escape_string($conn, $_POST['policy'] ?? '');

    $image = '';
    // Xử lý upload ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        // Tạo thư mục nếu chưa có
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Lưu đường dẫn tương đối để hiển thị ở frontend
            $image = "assets/images/" . $file_name;
        }
    }

    $sql = "INSERT INTO combos (name, price, original_price, duration, status, description, highlights, price_details, hotel_system, policy, image, created_at) 
            VALUES ('$name', $price, $original_price, '$duration', '$status', '$description', '$highlights', '$price_details', '$hotel_system', '$policy', '$image', NOW())";

    if (mysqli_query($conn, $sql)) {
        $success = "Thêm combo mới thành công!";
    } else {
        $error = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

include 'includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="add-combo.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Tên Combo</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="duration" class="form-label">Thời gian (VD: 3 Ngày 2 Đêm)</label>
                    <input type="text" class="form-control" id="duration" name="duration" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="original_price" class="form-label">Giá gốc (VNĐ) - Tuỳ chọn</label>
                    <input type="number" class="form-control" id="original_price" name="original_price" min="0">
                </div>
                <div class="col-md-4">
                    <label for="price" class="form-label">Giá khuyến mãi/bán (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" required min="0">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm ngưng</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả chung (Tuỳ chọn)</label>
                <textarea class="form-control richtext" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="highlights" class="form-label">Điểm nhấn hành trình</label>
                <textarea class="form-control richtext" id="highlights" name="highlights" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="price_details" class="form-label">Chi tiết giá (Bao gồm / Không bao gồm)</label>
                <textarea class="form-control richtext" id="price_details" name="price_details" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="hotel_system" class="form-label">Hệ thống khách sạn</label>
                <textarea class="form-control richtext" id="hotel_system" name="hotel_system" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="policy" class="form-label">Chính sách & Lưu ý</label>
                <textarea class="form-control richtext" id="policy" name="policy" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh đại diện</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <a href="combos.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-success">Lưu Combo</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
