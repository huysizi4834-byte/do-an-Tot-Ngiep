<?php
$page_title = "Tour Trang Chủ (Nổi Bật)";
require '../includes/db.php';

// Xử lý XÓA khỏi trang chủ
if (isset($_GET['remove_id'])) {
    $remove_id = (int)$_GET['remove_id'];
    mysqli_query($conn, "UPDATE tours SET is_featured = 0 WHERE id = $remove_id");
    $success = "Đã gỡ tour khỏi trang chủ!";
}

// Xử lý THÊM vào trang chủ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tour_id'])) {
    $tour_id = (int)$_POST['tour_id'];
    mysqli_query($conn, "UPDATE tours SET is_featured = 1 WHERE id = $tour_id");
    $success = "Thêm tour ra trang chủ thành công!";
}

// Lấy danh sách các tour CÓ trên trang chủ
$sql = "SELECT t.*, d.name AS destination_name 
        FROM tours t 
        LEFT JOIN destinations d ON t.destination_id = d.id 
        WHERE t.is_featured = 1
        ORDER BY t.id DESC";
$result = mysqli_query($conn, $sql);

// Lấy danh sách các tour CHƯA có trên trang chủ (để đưa vào select box)
$available_tours_sql = "SELECT id, title FROM tours WHERE is_featured = 0 AND status = 'active' ORDER BY title ASC";
$available_tours_result = mysqli_query($conn, $available_tours_sql);

include 'includes/admin-header.php';
?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-primary">Thêm Tour hiển thị Trang Chủ</h5>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>

                <form action="featured-tours.php" method="POST">
                    <div class="mb-3">
                        <label for="tour_id" class="form-label">Chọn Tour (Đang hoạt động)</label>
                        <select class="form-select" id="tour_id" name="tour_id" required>
                            <option value="">-- Chọn một tour --</option>
                            <?php while($at = mysqli_fetch_assoc($available_tours_result)): ?>
                                <option value="<?= $at['id'] ?>"><?= htmlspecialchars($at['title']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-circle"></i> Đưa ra trang chủ</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-primary">Danh sách Tour trên Trang Chủ</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên Tour</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($tour = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $tour['id'] ?></td>
                                        <td>
                                            <?php if (!empty($tour['thumbnail'])): ?>
                                                <img src="<?= htmlspecialchars($tour['thumbnail']) ?>" alt="Img" width="60" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">Không có</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($tour['title']) ?></div>
                                            <small class="text-muted"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($tour['destination_name'] ?? 'Không rõ') ?></small>
                                        </td>
                                        <td class="text-danger fw-bold"><?= number_format($tour['price']) ?> ₫</td>
                                        <td>
                                            <a href="featured-tours.php?remove_id=<?= $tour['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn gỡ tour này khỏi trang chủ? (Không xóa dữ liệu gốc)');" title="Gỡ khỏi trang chủ">
                                                <i class="bi bi-dash-circle"></i> Gỡ bỏ
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Chưa có tour nào được đặt ra trang chủ.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
