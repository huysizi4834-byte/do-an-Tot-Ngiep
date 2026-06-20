<?php
$page_title = "Thêm Chuyến Bay Mới";
require '../includes/db.php';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $airline = mysqli_real_escape_string($conn, $_POST['airline']);
    $flight_number = mysqli_real_escape_string($conn, $_POST['flight_number']);
    $departure_city = mysqli_real_escape_string($conn, $_POST['departure_city']);
    $arrival_city = mysqli_real_escape_string($conn, $_POST['arrival_city']);
    $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
    $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
    $price = (float) $_POST['price'];
    $thumbnail = '';
    
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $target_dir = "../uploads/flights/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES["thumbnail"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
            $thumbnail = 'uploads/flights/' . $file_name;
        }
    }

    if (empty($airline) || empty($flight_number) || empty($departure_city) || empty($arrival_city) || empty($departure_time) || empty($arrival_time) || $price <= 0) {
        $error = "Vui lòng nhập đầy đủ thông tin và giá hợp lệ.";
    } else {
        $sql = "INSERT INTO flights (airline, flight_number, departure_city, arrival_city, departure_time, arrival_time, price, thumbnail) 
                VALUES ('$airline', '$flight_number', '$departure_city', '$arrival_city', '$departure_time', '$arrival_time', $price, '$thumbnail')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Thêm chuyến bay thành công!";
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Chuyến Bay Mới</h1>
    <a href="flights.php" class="btn btn-secondary">
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

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="airline" class="form-label fw-bold">Hãng bay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="airline" name="airline" placeholder="VD: Vietnam Airlines" required>
                        </div>
                        <div class="col-md-6">
                            <label for="flight_number" class="form-label fw-bold">Số hiệu chuyến bay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="flight_number" name="flight_number" placeholder="VD: VN123" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_city" class="form-label fw-bold">Thành phố đi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="departure_city" name="departure_city" placeholder="VD: Hà Nội" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_city" class="form-label fw-bold">Thành phố đến <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="arrival_city" name="arrival_city" placeholder="VD: TP. Hồ Chí Minh" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_time" class="form-label fw-bold">Giờ cất cánh <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_time" class="form-label fw-bold">Giờ hạ cánh <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold">Giá vé (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" placeholder="VD: 2500000" required>
                        </div>
                        <div class="col-md-6">
                            <label for="thumbnail" class="form-label fw-bold">Logo hãng bay</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3"><i class="fa-solid fa-save me-2"></i> Lưu chuyến bay</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
