<?php
$page_title = "Quản lý Điểm Đến";
require '../includes/db.php';

// Xử lý XÓA điểm đến
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Check if there are tours using this destination
    $check_tours = mysqli_query($conn, "SELECT id FROM tours WHERE destination_id = $delete_id");
    if (mysqli_num_rows($check_tours) > 0) {
        $error = "Không thể xóa điểm đến này vì đang có tour sử dụng!";
    } else {
        mysqli_query($conn, "DELETE FROM destinations WHERE id = $delete_id");
        $success = "Xóa điểm đến thành công!";
    }
}

// Xử lý THÊM điểm đến mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    
    $image_url = '';
    // Xử lý upload ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = "assets/images/" . $file_name; 
        }
    }

    $sql = "INSERT INTO destinations (name, slug, description, image_url, created_at) 
            VALUES ('$name', '$slug', '$description', '$image_url', NOW())";
            
    if (mysqli_query($conn, $sql)) {
        $success = "Thêm điểm đến mới thành công!";
    } else {
        $error = "Có lỗi xảy ra: " . mysqli_error($conn);
    }
}

// Lấy danh sách điểm đến và đếm số lượng tour
$dest_sql = "SELECT d.*, COUNT(t.id) as tour_count 
             FROM destinations d 
             LEFT JOIN tours t ON d.id = t.destination_id 
             GROUP BY d.id 
             ORDER BY d.id DESC";
$dest_result = mysqli_query($conn, $dest_sql);

include 'includes/admin-header.php';
?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Thêm Điểm Đến Mới</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="destinations.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên điểm đến</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Thêm điểm đến</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Danh sách Điểm Đến</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên điểm đến</th>
                            <th>Số lượng Tour</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($dest_result) > 0): ?>
                            <?php while ($dest = mysqli_fetch_assoc($dest_result)): ?>
                                <tr>
                                    <td><?= $dest['id'] ?></td>
                                    <td>
                                        <?php if (!empty($dest['image_url'])): ?>
                                            <img src="../<?= htmlspecialchars($dest['image_url']) ?>" alt="Img" width="50" class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted">Không có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($dest['name']) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= $dest['tour_count'] ?> Tour</span></td>
                                    <td>
                                        <a href="destinations.php?delete_id=<?= $dest['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa điểm đến này?');" title="Xóa"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Chưa có điểm đến nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>