<?php
$page_title = "Quản lý Thư viện ảnh Tour";
require '../includes/db.php';

if (!isset($_GET['tour_id'])) {
    header("Location: tours.php");
    exit;
}

$tour_id = (int)$_GET['tour_id'];

// Lấy thông tin tour
$tour_query = mysqli_query($conn, "SELECT title FROM tours WHERE id = $tour_id");
$tour_data = mysqli_fetch_assoc($tour_query);
if (!$tour_data) {
    header("Location: tours.php");
    exit;
}

// Xử lý XÓA ảnh
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Lấy url ảnh để xóa file vật lý
    $img_q = mysqli_query($conn, "SELECT image_url FROM tour_images WHERE id = $delete_id AND tour_id = $tour_id");
    if ($img_row = mysqli_fetch_assoc($img_q)) {
        $file_path = "../" . $img_row['image_url'];
        if (file_exists($file_path) && !empty($img_row['image_url'])) {
            unlink($file_path);
        }
        mysqli_query($conn, "DELETE FROM tour_images WHERE id = $delete_id");
        $success = "Xóa ảnh thành công!";
    }
}

// Xử lý THÊM ảnh mới (Multiple)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $uploaded_count = 0;
    $target_dir = "../assets/images/gallery/";
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_count = count($_FILES['images']['name']);
    
    for ($i = 0; $i < $file_count; $i++) {
        if ($_FILES['images']['error'][$i] == 0) {
            $file_name = time() . '_' . rand(1000, 9999) . '_' . basename($_FILES["images"]["name"][$i]);
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
                $image_url = "assets/images/gallery/" . $file_name; 
                mysqli_query($conn, "INSERT INTO tour_images (tour_id, image_url) VALUES ($tour_id, '$image_url')");
                $uploaded_count++;
            }
        }
    }
    
    if ($uploaded_count > 0) {
        $success = "Tải lên thành công $uploaded_count ảnh!";
    } else {
        $error = "Không có ảnh nào được tải lên hoặc có lỗi xảy ra.";
    }
}

// Lấy danh sách ảnh của tour
$sql = "SELECT * FROM tour_images WHERE tour_id = $tour_id ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thư viện ảnh: <span class="text-primary"><?= htmlspecialchars($tour_data['title']) ?></span></h1>
    <a href="tours.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-primary">Tải ảnh lên</h5>
            </div>
            <div class="card-body">
                <form action="tour-images.php?tour_id=<?= $tour_id ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="images" class="form-label">Chọn hình ảnh (Có thể chọn nhiều)</label>
                        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-upload"></i> Tải lên</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-primary">Hình ảnh đã tải lên</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($img = mysqli_fetch_assoc($result)): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="position-relative">
                                    <img src="../<?= htmlspecialchars($img['image_url']) ?>" alt="Gallery Image" class="img-fluid rounded border w-100" style="height: 150px; object-fit: cover;">
                                    <a href="tour-images.php?tour_id=<?= $tour_id ?>&delete_id=<?= $img['id'] ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="return confirm('Bạn có chắc muốn xóa ảnh này?');" title="Xóa ảnh">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">Chưa có hình ảnh nào trong thư viện của tour này.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
