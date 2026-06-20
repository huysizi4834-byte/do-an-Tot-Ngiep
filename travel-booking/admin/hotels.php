<?php
$page_title = "Quản lý Khách Sạn";
require '../includes/db.php';
include 'includes/admin-header.php';

// Lấy danh sách khách sạn
$sql = "SELECT * FROM hotels ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Danh sách Khách sạn</h1>
    <a href="add-hotel.php" class="btn btn-primary"><i
            class="fa-solid fa-plus me-2"></i>Thêm khách sạn mới</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Khách sạn</th>
                        <th>Vị trí</th>
                        <th>Hạng sao</th>
                        <th>Giá mỗi đêm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($h = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $h['id'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars($h['thumbnail']) ?>" width="50" height="50"
                                        class="me-3 rounded" style="object-fit: cover;">
                                    <div>
                                        <span class="fw-bold"><?= htmlspecialchars($h['name']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fa-solid fa-location-dot text-danger me-1"></i>
                                    <?= htmlspecialchars($h['city']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($h['address']) ?></small>
                            </td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?= $i <= $h['star_rating'] ? 'text-warning' : 'text-muted' ?>"
                                        style="font-size: 0.8rem;"></i>
                                <?php endfor; ?>
                            </td>
                            <td class="text-danger fw-bold"><?= number_format($h['price_per_night']) ?> ₫</td>
                            <td>
                                <a href="edit-hotel.php?id=<?= $h['id'] ?>" class="btn btn-sm btn-info text-white"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href="delete-hotel.php?id=<?= $h['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khách sạn này?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>