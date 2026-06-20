<?php
$page_title = "Thêm Khách Sạn Mới";
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $star_rating = (int)$_POST['star_rating'];
    $price_per_night = (float)$_POST['price_per_night'];
    $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (empty($name) || empty($city) || empty($address) || $star_rating < 1 || $star_rating > 5 || $price_per_night <= 0) {
        $error = "Vui lòng nhập đầy đủ thông tin hợp lệ.";
    } else {
        $sql = "INSERT INTO hotels (name, city, address, star_rating, price_per_night, thumbnail, description) 
                VALUES ('$name', '$city', '$address', $star_rating, $price_per_night, '$thumbnail', '$description')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Thêm khách sạn thành công!";
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Khách Sạn Mới</h1>
    <a href="hotels.php" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Tên khách sạn <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label fw-bold">Thành phố <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="star_rating" class="form-label fw-bold">Hạng sao (1-5) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="star_rating" name="star_rating" min="1" max="5" required>
                        </div>
                        <div class="col-md-4">
                            <label for="price_per_night" class="form-label fw-bold">Giá mỗi đêm (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night" min="0" step="1000" required>
                        </div>
                        <div class="col-md-4">
                            <label for="thumbnail" class="form-label fw-bold">URL Hình ảnh</label>
                            <input type="text" class="form-control" id="thumbnail" name="thumbnail" placeholder="VD: assets/images/hotel.jpg">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea class="form-control richtext" id="description" name="description" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3"><i class="fa-solid fa-save me-2"></i> Lưu khách sạn</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
