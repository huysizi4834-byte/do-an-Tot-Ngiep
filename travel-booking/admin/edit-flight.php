<?php
$page_title = "Chỉnh sửa Chuyến Bay";
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: flights.php");
    exit;
}
$id = (int)$_GET['id'];

// Lấy thông tin hiện tại
$sql = "SELECT * FROM flights WHERE id = $id";
$result = mysqli_query($conn, $sql);
$flight = mysqli_fetch_assoc($result);

if (!$flight) {
    die("Không tìm thấy chuyến bay.");
}

// Format datetime strings for input[type="datetime-local"]
$dep_time = date('Y-m-d\TH:i', strtotime($flight['departure_time']));
$arr_time = date('Y-m-d\TH:i', strtotime($flight['arrival_time']));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $airline = mysqli_real_escape_string($conn, $_POST['airline']);
    $flight_number = mysqli_real_escape_string($conn, $_POST['flight_number']);
    $departure_city = mysqli_real_escape_string($conn, $_POST['departure_city']);
    $arrival_city = mysqli_real_escape_string($conn, $_POST['arrival_city']);
    $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
    $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
    $price = (float) $_POST['price'];

    // Handle thumbnail upload
    $thumbnail = $flight['thumbnail']; // Giữ ảnh cũ theo mặc định
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
        $error = "Vui lòng nhập đầy đủ thông tin hợp lệ.";
    } else {
        $sql_update = "UPDATE flights SET 
                airline = '$airline', 
                flight_number = '$flight_number', 
                departure_city = '$departure_city', 
                arrival_city = '$arrival_city', 
                departure_time = '$departure_time', 
                arrival_time = '$arrival_time', 
                price = $price, 
                thumbnail = '$thumbnail' 
                WHERE id = $id";
        
        if (mysqli_query($conn, $sql_update)) {
            $success = "Cập nhật chuyến bay thành công!";
            // Update displayed values
            $flight['airline'] = $airline;
            $flight['flight_number'] = $flight_number;
            $flight['departure_city'] = $departure_city;
            $flight['arrival_city'] = $arrival_city;
            $flight['price'] = $price;
            $flight['thumbnail'] = $thumbnail;
            $dep_time = $departure_time;
            $arr_time = $arrival_time;
        } else {
            $error = "Lỗi: " . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Chuyến Bay: <?= htmlspecialchars($flight['flight_number']) ?></h1>
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
                            <input type="text" class="form-control" id="airline" name="airline" value="<?= htmlspecialchars($flight['airline']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="flight_number" class="form-label fw-bold">Số hiệu chuyến bay <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="flight_number" name="flight_number" value="<?= htmlspecialchars($flight['flight_number']) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_city" class="form-label fw-bold">Thành phố đi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="departure_city" name="departure_city" value="<?= htmlspecialchars($flight['departure_city']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_city" class="form-label fw-bold">Thành phố đến <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="arrival_city" name="arrival_city" value="<?= htmlspecialchars($flight['arrival_city']) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_time" class="form-label fw-bold">Giờ cất cánh <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" value="<?= $dep_time ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_time" class="form-label fw-bold">Giờ hạ cánh <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" value="<?= $arr_time ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold">Giá vé (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" value="<?= $flight['price'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="thumbnail" class="form-label fw-bold">Logo hãng bay</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                            <?php if (!empty($flight['thumbnail'])): ?>
                                <div class="mt-2">
                                    <img src="../<?= htmlspecialchars($flight['thumbnail']) ?>" alt="Logo" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3"><i class="fa-solid fa-save me-2"></i> Cập nhật chuyến bay</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
