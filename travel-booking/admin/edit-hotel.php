<?php
$page_title = "Chỉnh sửa Khách Sạn";
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: hotels.php");
    exit;
}
$id = (int)$_GET['id'];

// Lấy thông tin hiện tại
$sql = "SELECT * FROM hotels WHERE id = $id";
$result = mysqli_query($conn, $sql);
$hotel = mysqli_fetch_assoc($result);

if (!$hotel) {
    die("Không tìm thấy khách sạn.");
}

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
        $sql_update = "UPDATE hotels SET 
                name = '$name', 
                city = '$city', 
                address = '$address', 
                star_rating = $star_rating, 
                price_per_night = $price_per_night, 
                thumbnail = '$thumbnail', 
                description = '$description' 
                WHERE id = $id";
        
        if (mysqli_query($conn, $sql_update)) {
            $success = "Cập nhật khách sạn thành công!";
            // Cập nhật lại biến $hotel để hiển thị
            $hotel['name'] = $name;
            $hotel['city'] = $city;
            $hotel['address'] = $address;
            $hotel['star_rating'] = $star_rating;
            $hotel['price_per_night'] = $price_per_night;
            $hotel['thumbnail'] = $thumbnail;
            $hotel['description'] = $description;
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Khách Sạn: <?= htmlspecialchars($hotel['name']) ?></h1>
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
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($hotel['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label fw-bold">Thành phố <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($hotel['city']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($hotel['address']) ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="star_rating" class="form-label fw-bold">Hạng sao (1-5) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="star_rating" name="star_rating" min="1" max="5" value="<?= $hotel['star_rating'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="price_per_night" class="form-label fw-bold">Giá mỗi đêm (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night" min="0" step="1000" value="<?= $hotel['price_per_night'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="thumbnail" class="form-label fw-bold">URL Hình ảnh</label>
                            <input type="text" class="form-control" id="thumbnail" name="thumbnail" value="<?= htmlspecialchars($hotel['thumbnail']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Mô tả</label>
                        <textarea class="form-control richtext" id="description" name="description" rows="4"><?= htmlspecialchars($hotel['description']) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3"><i class="fa-solid fa-save me-2"></i> Cập nhật khách sạn</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
