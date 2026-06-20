<?php
$page_title = "Chỉnh sửa Cẩm nang";
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: guides.php");
    exit();
}

$id = (int)$_GET['id'];
$error = '';
$success = '';

// Fetch current data
$res = mysqli_query($conn, "SELECT * FROM guides WHERE id = $id");
$guide = mysqli_fetch_assoc($res);

if (!$guide) {
    header("Location: guides.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $excerpt = mysqli_real_escape_string($conn, $_POST['excerpt']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = $guide['image']; // Keep old image by default

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = '../assets/images/guides/' . $new_filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image
                if (!empty($guide['image']) && file_exists('../assets/images/guides/' . $guide['image'])) {
                    unlink('../assets/images/guides/' . $guide['image']);
                }
                $image = $new_filename;
            } else {
                $error = 'Lỗi upload ảnh.';
            }
        } else {
            $error = 'Định dạng ảnh không hợp lệ.';
        }
    }

    if (empty($error)) {
        $sql = "UPDATE guides SET title = '$title', excerpt = '$excerpt', content = '$content', image = '$image' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            $success = 'Cập nhật bài viết thành công!';
            // Refresh data
            $guide['title'] = $_POST['title'];
            $guide['excerpt'] = $_POST['excerpt'];
            $guide['content'] = $_POST['content'];
            $guide['image'] = $image;
        } else {
            $error = 'Lỗi CSDL: ' . mysqli_error($conn);
        }
    }
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Chỉnh sửa bài viết</h2>
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
                <input type="text" class="form-control" name="title" required value="<?= htmlspecialchars($guide['title']) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Đoạn trích (Mô tả ngắn)</label>
                <textarea class="form-control" name="excerpt" rows="3"><?= htmlspecialchars($guide['excerpt']) ?></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Ảnh bìa hiện tại</label><br>
                <?php if (!empty($guide['image'])): ?>
                    <img src="../assets/images/guides/<?= htmlspecialchars($guide['image']) ?>" alt="Current Cover" style="width: 200px; border-radius: 8px; margin-bottom: 10px;">
                <?php else: ?>
                    <p class="text-muted">Chưa có ảnh bìa.</p>
                <?php endif; ?>
                <input type="file" class="form-control" name="image" accept="image/*">
                <small class="text-muted">Chỉ chọn file mới nếu bạn muốn thay đổi ảnh bìa hiện tại.</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung chi tiết</label>
                <textarea class="form-control richtext" name="content" rows="15" required><?= htmlspecialchars($guide['content']) ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-save"></i> Cập nhật bài viết</button>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
