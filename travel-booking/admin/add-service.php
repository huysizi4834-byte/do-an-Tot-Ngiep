<?php
$page_title = "Thêm Dịch Vụ Mới";
require '../includes/db.php';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float) $_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_url = '';
    
    // Xử lý upload ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_name = uniqid('service_') . '.' . $ext;
            $upload_path = '../assets/images/services/';
            
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_name)) {
                $image_url = 'assets/images/services/' . $new_name;
            } else {
                $error = "Lỗi khi tải ảnh lên.";
            }
        } else {
            $error = "Định dạng ảnh không hợp lệ.";
        }
    }

    if (!isset($error)) {
        if (empty($name) || $price <= 0) {
            $error = "Vui lòng nhập đầy đủ tên và giá hợp lệ.";
        } else {
            $sql = "INSERT INTO additional_services (name, price, description, image_url) 
                    VALUES ('$name', $price, '$description', '$image_url')";
        
            if (mysqli_query($conn, $sql)) {
                $success = "Thêm dịch vụ thành công!";
            } else {
                $error = "Lỗi: " . mysqli_error($conn);
            }
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Dịch Vụ Mới</h1>
    <a href="services.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên dịch vụ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label fw-bold">Giá dịch vụ (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="1000" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Tải lên Hình ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Định dạng hỗ trợ: JPG, PNG, WEBP. Kích thước tối đa 2MB.</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea class="form-control richtext" id="description" name="description" rows="5"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Lưu dịch vụ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
