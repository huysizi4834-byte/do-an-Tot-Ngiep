<?php
$page_title = "Quản lý Chuyến Bay";
require '../includes/db.php';
include 'includes/admin-header.php';

// Lấy danh sách chuyến bay
$sql = "SELECT * FROM flights ORDER BY departure_time DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Danh sách Chuyến bay</h1>
    <a href="add-flight.php" class="btn btn-primary"><i
            class="fa-solid fa-plus me-2"></i>Thêm chuyến bay mới</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Hãng bay</th>
                        <th>Hành trình</th>
                        <th>Giờ cất cánh</th>
                        <th>Giờ hạ cánh</th>
                        <th>Giá vé</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($f = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $f['id'] ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($f['thumbnail']) ?>" width="30" class="me-2">
                                <span class="fw-bold"><?= htmlspecialchars($f['airline']) ?></span> <br>
                                <small class="text-muted"><?= htmlspecialchars($f['flight_number']) ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($f['departure_city']) ?> <i class="fa-solid fa-arrow-right mx-1"></i>
                                <?= htmlspecialchars($f['arrival_city']) ?>
                            </td>
                            <td><?= date('H:i d/m/Y', strtotime($f['departure_time'])) ?></td>
                            <td><?= date('H:i d/m/Y', strtotime($f['arrival_time'])) ?></td>
                            <td class="text-danger fw-bold"><?= number_format($f['price']) ?> ₫</td>
                            <td>
                                <a href="edit-flight.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-info text-white"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href="delete-flight.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa chuyến bay này không? Thao tác này không thể hoàn tác!');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>