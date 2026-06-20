<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/db.php';

// Xử lý tìm kiếm
$city = $_GET['city'] ?? '';
$price_max = $_GET['price_max'] ?? '';
$current_location = $_SESSION['location'] ?? 'VN';

$where = [];
if (!empty($city)) {
    $where[] = "city LIKE '%" . mysqli_real_escape_string($conn, $city) . "%'";
}
if (!empty($price_max)) {
    $where[] = "price_per_night <= " . (int) $price_max;
}

// Nếu không tìm kiếm cụ thể, lọc khách sạn theo địa điểm đang chọn
if (empty($city)) {
    if ($current_location === 'VN') {
        $where[] = "(city LIKE '%Hồ Chí Minh%' OR city LIKE '%Hà Nội%' OR city LIKE '%Đà Nẵng%' OR city LIKE '%Phú Quốc%' OR city LIKE '%Nha Trang%')";
    } elseif ($current_location === 'US') {
        $where[] = "(city LIKE '%New York%' OR city LIKE '%Los Angeles%')";
    } elseif ($current_location === 'EU') {
        $where[] = "(city LIKE '%Paris%' OR city LIKE '%London%')";
    } elseif ($current_location === 'JP') {
        $where[] = "(city LIKE '%Tokyo%' OR city LIKE '%Kyoto%')";
    }
}

$where_clause = "";
if (count($where) > 0) {
    $where_clause = " WHERE " . implode(' AND ', $where);
}

$sql = "SELECT * FROM hotels $where_clause ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<div class="hero-banner"
    style="height: 300px; background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2000&auto=format&fit=crop') center/cover; position: relative;">
    <div class="hero-overlay"
        style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;">
        <h1 class="text-white fw-bold">Khách sạn Cao cấp</h1>
    </div>
</div>

<div class="container py-5">

    <!-- Thanh tìm kiếm khách sạn -->
    <div class="card shadow-sm mb-5 border-0" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="card-body p-4">
            <form action="hotels.php" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label text-muted"><i class="fa-solid fa-location-dot me-2"></i>Thành phố / Điểm
                        đến</label>
                    <input type="text" name="city" class="form-control" placeholder="Hà Nội, Đà Nẵng, Phú Quốc..."
                        value="<?= htmlspecialchars($city) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted"><i class="fa-solid fa-money-bill-wave me-2"></i>Mức giá tối đa
                        (VNĐ)</label>
                    <select name="price_max" class="form-select">
                        <option value="">-- Tất cả mức giá --</option>
                        <option value="1000000" <?= $price_max == '1000000' ? 'selected' : '' ?>>Dưới 1.000.000 ₫</option>
                        <option value="2000000" <?= $price_max == '2000000' ? 'selected' : '' ?>>Dưới 2.000.000 ₫</option>
                        <option value="5000000" <?= $price_max == '5000000' ? 'selected' : '' ?>>Dưới 5.000.000 ₫</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Tìm khách sạn</button>
                </div>
            </form>
        </div>
    </div>

    <h3 class="mb-4">
        <?php
        if (!empty($city)) {
            echo "Khách sạn tại " . htmlspecialchars($city);
        } else {
            $location_names = [
                'VN' => 'Việt Nam',
                'US' => 'Hoa Kỳ',
                'EU' => 'Châu Âu',
                'JP' => 'Nhật Bản'
            ];
            $loc_name = $location_names[$current_location] ?? 'Việt Nam';
            echo "Khách sạn nổi bật tại " . $loc_name;
        }
        ?>
    </h3>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($hotel = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 hotel-card">
                        <img src="<?= htmlspecialchars($hotel['thumbnail']) ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($hotel['name']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?= $i <= $hotel['star_rating'] ? 'text-warning' : 'text-muted' ?>"
                                        style="font-size: 0.8rem;"></i>
                                <?php endfor; ?>
                            </div>
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($hotel['name']) ?></h5>
                            <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i>
                                <?= htmlspecialchars($hotel['city']) ?></p>
                            <div class="mt-auto border-top pt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-danger fw-bold fs-5"><?= formatPrice($hotel['price_per_night']) ?></span><br>
                                    <small class="text-muted">/ đêm</small>
                                </div>
                                <a href="hotel-booking.php?id=<?= $hotel['id'] ?>"
                                    class="btn btn-outline-primary btn-sm rounded-pill px-3">Đặt phòng</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2861/2861314.png" alt="No hotels" width="100"
                    class="mb-3 opacity-50">
                <h4 class="text-muted">Không tìm thấy khách sạn nào phù hợp.</h4>
                <a href="hotels.php" class="btn btn-outline-primary mt-2">Xóa bộ lọc</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .hotel-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .hotel-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }
</style>

<?php include 'includes/footer.php'; ?>