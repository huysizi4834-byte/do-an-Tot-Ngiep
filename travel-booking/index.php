<?php
require_once 'includes/common.php';
include 'includes/header.php';

// Fetch destinations
$dest_sql = "SELECT * FROM destinations ORDER BY id DESC LIMIT 4";
$dest_result = mysqli_query($conn, $dest_sql);

// Fetch featured tours
$hot_tours_sql = "SELECT t.*, d.name AS destination_name 
                  FROM tours t 
                  LEFT JOIN destinations d ON t.destination_id = d.id 
                  WHERE t.status = 'active' AND t.is_featured = 1 
                  ORDER BY t.id DESC LIMIT 12";
$hot_tours_result = mysqli_query($conn, $hot_tours_sql);
?><!-- HERO -->

<section class="hero-banner">

    <div class="hero-overlay">

        <div class="container">

            <div class="hero-center">

                <h1>
                    KHÁM PHÁ THẾ GIỚI
                </h1>

                <p>
                    Hơn 10.000 chương trình du lịch trong nước và quốc tế
                </p>

            </div>

        </div>

    </div>

</section>

<!-- SEARCH -->

<div class="container">
    <div class="search-wrapper-new">
        <div class="search-tabs">
            <label class="search-tab-radio">
                <input type="radio" name="tour_type" value="domestic" checked>
                <span class="radio-custom"></span>
                Trong nước
            </label>
            <label class="search-tab-radio">
                <input type="radio" name="tour_type" value="international">
                <span class="radio-custom"></span>
                Nước ngoài
            </label>
        </div>

        <form action="tours.php" method="GET" class="search-form-flex">
            <div class="search-input-group">
                <i class="fa-solid fa-location-dot"></i>
                <div class="input-content">
                    <label>Điểm khởi hành</label>
                    <input type="text" name="departure" placeholder="Tất cả">
                </div>
                <i class="fa-solid fa-circle-xmark clear-icon"></i>
            </div>

            <div class="search-divider"></div>

            <div class="search-input-group">
                <i class="fa-solid fa-location-dot"></i>
                <div class="input-content">
                    <label>Điểm đến</label>
                    <input type="text" name="destination" placeholder="Địa điểm bất kỳ...">
                </div>
            </div>

            <div class="search-divider"></div>

            <div class="search-input-group">
                <i class="fa-regular fa-calendar"></i>
                <div class="input-content">
                    <label>Ngày đi</label>
                    <input type="text" name="date" placeholder="13/06/2026">
                </div>
            </div>

            <button type="submit" class="btn btn-primary search-submit-btn">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
            </button>
        </form>

        <div class="search-tags">
            <span class="tags-label">Tìm kiếm nổi bật:</span>
            <a href="#" class="search-tag"><i class="fa-regular fa-star"></i> TOUR XUYÊN VIỆT</a>
            <a href="#" class="search-tag"><i class="fa-regular fa-star"></i> WORLD CUP 2026</a>
            <a href="#" class="search-tag"><i class="fa-regular fa-star"></i> TOUR CAO CẤP</a>
            <a href="#" class="search-tag"><i class="fa-regular fa-star"></i> TOUR CARAVAN</a>
            <a href="#" class="search-tag"><i class="fa-regular fa-star"></i> TỰ VẤN DU HỌC</a>
        </div>
    </div>
</div>

<!-- ĐIỂM ĐẾN -->
<section class="container py-5">
    <h2 class="text-center mb-4">
        Điểm đến nổi bật
    </h2>
    <div class="row justify-content-center">
        <?php if (isset($dest_result) && mysqli_num_rows($dest_result) > 0): ?>
            <?php while ($dest = mysqli_fetch_assoc($dest_result)): ?>
                <div class="col-md-3">
                    <a href="tours.php?destination=<?= urlencode($dest['name']) ?>" class="text-decoration-none text-dark">
                        <div class="tour-card">
                            <img src="<?= htmlspecialchars($dest['image_url']) ?>" alt="<?= htmlspecialchars($dest['name']) ?>" onerror="this.src='https://picsum.photos/600/400?random=<?= $dest['id'] ?>'">
                            <div class="tour-info text-center">
                                <h5><?= htmlspecialchars($dest['name']) ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có điểm đến nổi bật nào.</p>
        <?php endif; ?>
    </div>
</section>

<!-- TOUR HOT -->
<section class="container py-5">
    <h2 class="mb-4">
        Tour bán chạy / Nổi bật
    </h2>
    <div class="row">
        <?php if (isset($hot_tours_result) && mysqli_num_rows($hot_tours_result) > 0): ?>
            <?php while ($tour = mysqli_fetch_assoc($hot_tours_result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="tour-card">
                        <img src="<?= htmlspecialchars($tour['thumbnail'] ?? '') ?>" onerror="this.src='https://picsum.photos/600/400?random=<?= $tour['id'] ?>'" alt="<?= htmlspecialchars($tour['title']) ?>">
                        <div class="tour-info">
                            <span class="tour-badge">
                                HOT
                            </span>
                            <h5>
                                <?= htmlspecialchars($tour['title']) ?>
                            </h5>
                            <p>
                                <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['destination_name'] ?? 'Đang cập nhật') ?>
                            </p>
                            <div class="tour-price">
                                <?= formatPrice($tour['price']) ?>
                            </div>
                            <a href="tour-detail.php?id=<?= $tour['id'] ?>" class="btn btn-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Chưa có tour nổi bật nào.</p>
        <?php endif; ?>
    </div>
</section>

<!-- LÝ DO CHỌN -->

<section class="container py-5">

    <h2 class="text-center mb-5">

        Vì sao chọn THEGIOI

    </h2>

    <div class="row text-center">

        <div class="col-md-4">

            <h3>10.000+</h3>

            <p>Chương trình du lịch</p>

        </div>

        <div class="col-md-4">

            <h3>100.000+</h3>

            <p>Khách hàng hài lòng</p>

        </div>

        <div class="col-md-4">

            <h3>24/7</h3>

            <p>Hỗ trợ khách hàng</p>

        </div>

    </div>

</section>

<!-- ĐÁNH GIÁ -->

<section class="container py-5">

    <h2 class="mb-4">
        Khách hàng nói gì?
    </h2>

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">Tour rất tuyệt vời, hướng dẫn viên nhiệt tình.</p>
                <strong>Nguyễn Văn A</strong>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">Dịch vụ chuyên nghiệp, giá hợp lý, chỗ ở rất sạch sẽ và đẳng cấp.</p>
                <strong>Trần Thị B</strong>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">Gia đình tôi đã có một kỳ nghỉ thật đáng nhớ. Sẽ tiếp tục ủng hộ THEGIOI Tour!</p>
                <strong>Lê Văn C</strong>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">Thức ăn trong tour rất ngon, lịch trình sắp xếp hợp lý không bị mệt.</p>
                <strong>Phạm Thu D</strong>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">HDV vui tính, chăm sóc khách hàng vô cùng chu đáo từ lúc đi đến lúc về.</p>
                <strong>Hoàng Tuấn E</strong>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="profile-card">
                ⭐⭐⭐⭐⭐
                <p class="mt-3">Trải nghiệm du thuyền ngắm hoàng hôn quá xuất sắc. Đáng đồng tiền bát gạo!</p>
                <strong>Vũ Hữu F</strong>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>