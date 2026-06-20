<?php
$page_title = "Thêm bài viết Cẩm nang";
require '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $excerpt = mysqli_real_escape_string($conn, $_POST['excerpt']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = '../assets/images/guides/' . $new_filename;
            
            if (!is_dir('../assets/images/guides')) {
                mkdir('../assets/images/guides', 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image = $new_filename;
            } else {
                $error = 'Lỗi upload ảnh.';
            }
        } else {
            $error = 'Định dạng ảnh không hợp lệ.';
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO guides (title, excerpt, content, image) VALUES ('$title', '$excerpt', '$content', '$image')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Thêm bài viết thành công!';
            // Clear form
            $_POST = array();
        } else {
            $error = 'Lỗi CSDL: ' . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Thêm bài viết mới</h2>
    <a href="guides.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" class="form-control" name="title" required value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Đoạn trích (Mô tả ngắn)</label>
                <textarea class="form-control" name="excerpt" rows="3"><?= isset($_POST['excerpt']) ? htmlspecialchars($_POST['excerpt']) : '' ?></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Ảnh bìa</label>
                <input type="file" class="form-control" name="image" accept="image/*">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung chi tiết</label>
                <textarea class="form-control richtext" name="content" rows="15" required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
                <small class="text-muted">Có thể sử dụng thẻ HTML cơ bản (như &lt;p&gt;, &lt;b&gt;, &lt;br&gt;) để định dạng nội dung.</small>
            </div>
            
            <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-save"></i> Lưu bài viết</button>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
