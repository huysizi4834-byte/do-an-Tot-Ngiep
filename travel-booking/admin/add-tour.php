<?php
$page_title = "Thêm Tour Mới";
require '../includes/db.php';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $destination_id = (int) $_POST['destination_id'];
    $price = (float) $_POST['price'];
    $duration_days = (int) $_POST['duration_days'];
    $duration_nights = (int) $_POST['duration_nights'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    $thumbnail = '';
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
            $thumbnail = "assets/images/" . $file_name;
        }
    }

    $sql = "INSERT INTO tours (title, slug, destination_id, price, duration_days, duration_nights, status, description, thumbnail, created_at) 
            VALUES ('$title', '$slug', $destination_id, $price, $duration_days, $duration_nights, '$status', '$description', '$thumbnail', NOW())";

    if (mysqli_query($conn, $sql)) {
        $success = "Thêm tour mới thành công!";
    } else {
        $error = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

// Lấy danh sách điểm đến cho dropdown
$dest_result = mysqli_query($conn, "SELECT * FROM destinations ORDER BY name ASC");

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

        <form action="add-tour.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Tên Tour</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-md-6">
                    <label for="destination_id" class="form-label">Điểm đến</label>
                    <select class="form-select" id="destination_id" name="destination_id" required>
                        <option value="">-- Chọn điểm đến --</option>
                        <?php while ($dest = mysqli_fetch_assoc($dest_result)): ?>
                            <option value="<?= $dest['id'] ?>"><?= htmlspecialchars($dest['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="price" class="form-label">Giá (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" required min="0">
                </div>
                <div class="col-md-3">
                    <label for="duration_days" class="form-label">Số ngày</label>
                    <input type="number" class="form-control" id="duration_days" name="duration_days" required min="1">
                </div>
                <div class="col-md-3">
                    <label for="duration_nights" class="form-label">Số đêm</label>
                    <input type="number" class="form-control" id="duration_nights" name="duration_nights" required
                        min="0">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm ngưng</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả Tour</label>
                <textarea class="form-control richtext" id="description" name="description" rows="5"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh đại diện</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <a href="tours.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-success">Lưu Tour</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>