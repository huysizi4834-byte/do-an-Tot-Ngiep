<?php
$page_title = "Quản lý ảnh Cẩm nang";
require '../includes/db.php';

if (!isset($_GET['guide_id'])) {
    header("Location: guides.php");
    exit();
}

$guide_id = (int)$_GET['guide_id'];

// Check guide exists
$guide_res = mysqli_query($conn, "SELECT title FROM guides WHERE id = $guide_id");
if (mysqli_num_rows($guide_res) == 0) {
    header("Location: guides.php");
    exit();
}
$guide_row = mysqli_fetch_assoc($guide_res);
$guide_title = $guide_row['title'];

$error = '';
$success = '';

// Handle upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $upload_path = '../assets/images/guides/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $uploaded_count = 0;
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] == 0) {
            $filename = $_FILES['images']['name'][$key];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (in_array($ext, $allowed)) {
                $new_filename = uniqid() . '_' . $key . '.' . $ext;
                if (move_uploaded_file($tmp_name, $upload_path . $new_filename)) {
                    mysqli_query($conn, "INSERT INTO guide_images (guide_id, image) VALUES ($guide_id, '$new_filename')");
                    $uploaded_count++;
                }
            }
        }
    }
    
    if ($uploaded_count > 0) {
        $success = "Đã tải lên $uploaded_count ảnh thành công.";
    } else {
        $error = "Không có ảnh nào được tải lên hoặc định dạng không hợp lệ.";
    }
}

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $img_res = mysqli_query($conn, "SELECT image FROM guide_images WHERE id = $delete_id AND guide_id = $guide_id");
    if ($img_row = mysqli_fetch_assoc($img_res)) {
        $file_path = '../assets/images/guides/' . $img_row['image'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        mysqli_query($conn, "DELETE FROM guide_images WHERE id = $delete_id");
        header("Location: guide-images.php?guide_id=$guide_id");
        exit();
    }
}

// Get images
$images_sql = "SELECT * FROM guide_images WHERE guide_id = $guide_id ORDER BY id DESC";
$images_res = mysqli_query($conn, $images_sql);

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0 fw-bold">Quản lý Ảnh phụ</h2>
        <p class="text-muted mb-0">Bài viết: <b><?= htmlspecialchars($guide_title) ?></b></p>
    </div>
    <a href="guides.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-cloud-upload"></i> Tải ảnh lên</h5>
        <form action="" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
            <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
            <button type="submit" class="btn btn-primary fw-bold text-nowrap"><i class="bi bi-upload"></i> Tải lên</button>
        </form>
        <small class="text-muted d-block mt-2">Bạn có thể chọn nhiều file ảnh cùng lúc.</small>
    </div>
</div>

<div class="row g-4">
    <?php if (mysqli_num_rows($images_res) > 0): ?>
        <?php while ($img = mysqli_fetch_assoc($images_res)): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative">
                    <?php $imgSrc = (strpos($img['image'], 'http') === 0) ? htmlspecialchars($img['image']) : "../assets/images/guides/" . htmlspecialchars($img['image']); ?>
                    <img src="<?= $imgSrc ?>" alt="Guide Image" class="w-100 h-100 object-fit-cover" style="min-height: 200px;">
                    <a href="guide-images.php?guide_id=<?= $guide_id ?>&delete_id=<?= $img['id'] ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle" onclick="return confirm('Xóa ảnh này?');" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Xóa ảnh">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="text-center py-5 text-muted border rounded-4 bg-light">
                <i class="bi bi-images fs-1 mb-2"></i>
                <p class="mb-0">Chưa có ảnh phụ nào cho bài viết này.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/admin-footer.php'; ?>
