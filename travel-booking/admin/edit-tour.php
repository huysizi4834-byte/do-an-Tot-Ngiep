<?php
$page_title = "Chỉnh sửa Tour";
require '../includes/db.php';

if (!isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: tours.php");
    exit;
}

$tour_id = isset($_GET['id']) ? (int) $_GET['id'] : (int) $_POST['id'];

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

    // Xử lý upload ảnh nếu có
    $update_image_sql = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $thumbnail = "assets/images/" . $file_name;
            $update_image_sql = ", thumbnail = '$thumbnail'";
        }
    }

    $sql = "UPDATE tours SET 
            title = '$title', 
            slug = '$slug', 
            destination_id = $destination_id, 
            price = $price, 
            duration_days = $duration_days, 
            duration_nights = $duration_nights, 
            status = '$status', 
            description = '$description' 
            $update_image_sql
            WHERE id = $tour_id";

    if (mysqli_query($conn, $sql)) {
        $success = "Cập nhật tour thành công!";
    } else {
        $error = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

// Lấy thông tin tour hiện tại
$tour_query = mysqli_query($conn, "SELECT * FROM tours WHERE id = $tour_id");
$tour = mysqli_fetch_assoc($tour_query);

if (!$tour) {
    echo "Tour không tồn tại!";
    exit;
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

        <form action="edit-tour.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden input for tour ID -->
            <input type="hidden" name="id" value="<?= $tour['id'] ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Tên Tour</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="<?= htmlspecialchars($tour['title']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="destination_id" class="form-label">Điểm đến</label>
                    <select class="form-select" id="destination_id" name="destination_id" required>
                        <option value="">-- Chọn điểm đến --</option>
                        <?php while ($dest = mysqli_fetch_assoc($dest_result)): ?>
                            <option value="<?= $dest['id'] ?>" <?= ($dest['id'] == $tour['destination_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dest['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="price" class="form-label">Giá (VNĐ)</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $tour['price'] ?>"
                        required min="0">
                </div>
                <div class="col-md-3">
                    <label for="duration_days" class="form-label">Số ngày</label>
                    <input type="number" class="form-control" id="duration_days" name="duration_days"
                        value="<?= $tour['duration_days'] ?>" required min="1">
                </div>
                <div class="col-md-3">
                    <label for="duration_nights" class="form-label">Số đêm</label>
                    <input type="number" class="form-control" id="duration_nights" name="duration_nights"
                        value="<?= $tour['duration_nights'] ?>" required min="0">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= ($tour['status'] == 'active') ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= ($tour['status'] == 'inactive') ? 'selected' : '' ?>>Tạm ngưng
                        </option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả Tour</label>
                <textarea class="form-control richtext" id="description" name="description"
                    rows="5"><?= htmlspecialchars($tour['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh đại diện (để trống nếu không đổi)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if (!empty($tour['thumbnail'])): ?>
                    <div class="mt-2">
                        <img src="../<?= htmlspecialchars($tour['thumbnail']) ?>" alt="Current Image" width="150"
                            class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between">
                <a href="tours.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhật Tour</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>