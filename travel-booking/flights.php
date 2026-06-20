<?php
require 'includes/db.php';

// Xử lý tìm kiếm
$departure = $_GET['departure'] ?? '';
$arrival = $_GET['arrival'] ?? '';
$date = $_GET['date'] ?? '';

// Passenger state
$adult = isset($_GET['adult']) ? max(1, (int)$_GET['adult']) : 1;
$child = isset($_GET['child']) ? max(0, (int)$_GET['child']) : 0;
$infant = isset($_GET['infant']) ? max(0, (int)$_GET['infant']) : 0;
$flight_class = $_GET['flight_class'] ?? 'Phổ thông';

$where = [];
if (!empty($departure)) {
    $where[] = "departure_city LIKE '%" . mysqli_real_escape_string($conn, $departure) . "%'";
}
if (!empty($arrival)) {
    $where[] = "arrival_city LIKE '%" . mysqli_real_escape_string($conn, $arrival) . "%'";
}
if (!empty($date)) {
    // Chuyển đổi định dạng ngày nếu cần, ở đây giả sử format YYYY-MM-DD
    $where[] = "DATE(departure_time) = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$where_clause = "";
if (count($where) > 0) {
    $where_clause = " WHERE " . implode(' AND ', $where);
}

$sql = "SELECT * FROM flights $where_clause ORDER BY departure_time ASC";
$result = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<div class="hero-banner"
    style="height: 300px; background: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2074&auto=format&fit=crop') center/cover; position: relative;">
    <div class="hero-overlay"
        style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;">
        <h1 class="text-white">Vé Máy Bay Giá Tốt</h1>
    </div>
</div>

<div class="container py-5">

    <!-- Thanh tìm kiếm vé máy bay -->
    <div class="card shadow mb-5 border-0 rounded-4" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="card-body p-4">
            <!-- Top Controls -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip_type" id="oneWay" value="one_way" checked>
                        <label class="form-check-label fw-bold" for="oneWay">Một chiều</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip_type" id="roundTrip" value="round_trip">
                        <label class="form-check-label fw-bold" for="roundTrip">Khứ hồi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip_type" id="multiCity" value="multi_city">
                        <label class="form-check-label fw-bold" for="multiCity">Nhiều thành phố</label>
                    </div>
                </div>
                <div class="d-flex gap-4 align-items-center">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="directFlight">
                        <label class="form-check-label text-muted" for="directFlight">Bay thẳng</label>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none text-dark fw-bold" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="paxDropdown"><i class="fa-solid fa-users me-2 text-primary"></i><span id="paxText"><?= $adult ?> Người lớn, <?= $child ?> Trẻ em, <?= $infant ?> Em bé</span> <i class="fa-solid fa-chevron-down ms-1 text-muted"></i></a>
                        <div class="dropdown-menu p-3 shadow border-0 rounded-3" style="width: 280px; z-index: 1050;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-bold">Người lớn</div>
                                    <small class="text-muted">&ge; 12 tuổi</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('adult', -1)">-</button>
                                    <span id="adultCount" class="fw-bold" style="width: 20px; text-align: center;"><?= $adult ?></span>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('adult', 1)">+</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="fw-bold">Trẻ em</div>
                                    <small class="text-muted">2 - 11 tuổi</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('child', -1)">-</button>
                                    <span id="childCount" class="fw-bold" style="width: 20px; text-align: center;"><?= $child ?></span>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('child', 1)">+</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">Em bé</div>
                                    <small class="text-muted">&lt; 2 tuổi</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('infant', -1)">-</button>
                                    <span id="infantCount" class="fw-bold" style="width: 20px; text-align: center;"><?= $infant ?></span>
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="updatePax('infant', 1)">+</button>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" onclick="document.getElementById('paxDropdown').click()">Xong</button>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none text-dark fw-bold" data-bs-toggle="dropdown"><i class="fa-solid fa-chair me-2 text-primary"></i><span id="classText"><?= htmlspecialchars($flight_class) ?></span> <i class="fa-solid fa-chevron-down ms-1 text-muted"></i></a>
                        <ul class="dropdown-menu shadow border-0 rounded-3">
                            <li><a class="dropdown-item fw-bold class-option" href="#" data-value="Phổ thông">Phổ thông</a></li>
                            <li><a class="dropdown-item fw-bold class-option" href="#" data-value="Phổ thông đặc biệt">Phổ thông đặc biệt</a></li>
                            <li><a class="dropdown-item fw-bold class-option" href="#" data-value="Thương gia">Thương gia</a></li>
                            <li><a class="dropdown-item fw-bold class-option" href="#" data-value="Hạng nhất">Hạng nhất</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Fields -->
            <form action="flights.php" method="GET">
                <input type="hidden" name="adult" id="hiddenAdult" value="<?= $adult ?>">
                <input type="hidden" name="child" id="hiddenChild" value="<?= $child ?>">
                <input type="hidden" name="infant" id="hiddenInfant" value="<?= $infant ?>">
                <input type="hidden" name="flight_class" id="hiddenClass" value="<?= htmlspecialchars($flight_class) ?>">
                
                <div class="row g-2 align-items-end position-relative">
                    <div class="col-md-3 position-relative">
                        <label class="form-label text-muted fw-bold mb-1" style="font-size: 13px;">Từ</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-plane-departure"></i></span>
                            <input type="text" id="departureInput" name="departure" class="form-control border-start-0 ps-0 fw-bold" placeholder="TP HCM (SGN)" value="<?= htmlspecialchars($departure) ?>" style="font-size: 16px;">
                        </div>
                        
                        <!-- Swap icon -->
                        <button type="button" id="swapBtn" class="btn btn-light rounded-circle shadow-sm border d-none d-md-flex align-items-center justify-content-center" style="position: absolute; right: -15px; bottom: 4px; width: 30px; height: 30px; padding: 0; z-index: 10;"><i class="fa-solid fa-right-left text-primary" style="font-size: 12px;"></i></button>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted fw-bold mb-1" style="font-size: 13px;">Đến</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-plane-arrival"></i></span>
                            <input type="text" id="arrivalInput" name="arrival" class="form-control border-start-0 ps-0 fw-bold" placeholder="Bangkok (BKK)" value="<?= htmlspecialchars($arrival) ?>" style="font-size: 16px;">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-muted fw-bold mb-1" style="font-size: 13px;">Ngày khởi hành</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar"></i></span>
                            <input type="date" name="date" class="form-control border-start-0 ps-0 fw-bold" value="<?= htmlspecialchars($date) ?>" style="font-size: 15px;">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label text-muted fw-bold mb-1" style="font-size: 13px;">Khứ hồi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-calendar-plus"></i></span>
                            <input type="date" id="returnDateInput" name="return_date" class="form-control border-start-0 ps-0 bg-light text-muted" placeholder="Chọn ngày về" disabled style="font-size: 15px;">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2" style="height: 38px; border-radius: 8px;">
                            Tìm chuyến bay
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="#" class="text-decoration-none text-primary fw-bold" style="font-size: 14px;"><i class="fa-solid fa-location-dot me-1"></i> Tìm ý tưởng chuyến bay thú vị ở đây</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Promo section -->
    <div class="mb-5">
        <h4 class="fw-bold mb-3">Đặt vé trên web, mở app dùng mã ngay!</h4>
        <div class="d-flex gap-2 mb-4">
            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm">Mã thanh toán</span>
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fs-6 fw-bold border border-primary">Mã TheGioi</span>
            <span class="badge bg-white text-muted px-3 py-2 rounded-pill fs-6 fw-bold border">Mã đối tác</span>
        </div>
        <div class="row g-3">
            <!-- Promo Card 1 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 rounded-3 position-relative overflow-hidden">
                    <div class="bg-danger text-white px-2 py-1 position-absolute" style="top: 10px; left: 0; border-top-right-radius: 5px; border-bottom-right-radius: 5px; font-size: 11px; font-weight: bold; z-index: 2;">Sắp hết mã</div>
                    <div class="card-body d-flex gap-3 align-items-center pt-4">
                        <img src="assets/images/promo/mb_logo.png" width="40" height="40" style="object-fit: contain; border-radius: 8px;">
                        <div>
                            <h6 class="fw-bold mb-1">Giảm 200K VNĐ</h6>
                            <small class="text-muted d-block" style="font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Tối thiểu giao dịch 3 triệu sử dụng thẻ tín dụng MB Bank...</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top border-light border-dashed d-flex justify-content-between align-items-center py-2">
                        <span class="text-secondary fw-bold promo-code-text" style="font-size: 13px;"><i class="fa-regular fa-file-lines me-1"></i> MBJCB200K</span>
                        <button class="btn btn-sm text-primary fw-bold px-3 rounded-pill copy-btn" style="background-color: #e0f2fe;">Copy</button>
                    </div>
                </div>
            </div>
            
            <!-- Promo Card 2 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 rounded-3 position-relative overflow-hidden">
                    <div class="bg-danger text-white px-2 py-1 position-absolute" style="top: 10px; left: 0; border-top-right-radius: 5px; border-bottom-right-radius: 5px; font-size: 11px; font-weight: bold; z-index: 2;">Sắp hết mã</div>
                    <div class="card-body d-flex gap-3 align-items-center pt-4">
                        <img src="assets/images/promo/vp_logo.png" width="40" height="40" style="object-fit: contain; border-radius: 8px;">
                        <div>
                            <h6 class="fw-bold mb-1">Giảm giá 200K VNĐ cho vé máy bay</h6>
                            <small class="text-muted d-block" style="font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Tối thiểu giao dịch 4 triệu đồng sử dụng Thẻ VPBank...</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top border-light border-dashed d-flex justify-content-between align-items-center py-2">
                        <span class="text-secondary fw-bold promo-code-text" style="font-size: 13px;"><i class="fa-regular fa-file-lines me-1"></i> VPFLY200</span>
                        <button class="btn btn-sm text-primary fw-bold px-3 rounded-pill copy-btn" style="background-color: #e0f2fe;">Copy</button>
                    </div>
                </div>
            </div>
            
            <!-- Promo Card 3 -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 rounded-3 position-relative overflow-hidden">
                    <div class="bg-danger text-white px-2 py-1 position-absolute" style="top: 10px; left: 0; border-top-right-radius: 5px; border-bottom-right-radius: 5px; font-size: 11px; font-weight: bold; z-index: 2;">Sắp hết mã</div>
                    <div class="card-body d-flex gap-3 align-items-center pt-4">
                        <img src="assets/images/promo/vp_logo.png" width="40" height="40" style="object-fit: contain; border-radius: 8px;">
                        <div>
                            <h6 class="fw-bold mb-1">Giảm giá 150K VNĐ cho khách sạn</h6>
                            <small class="text-muted d-block" style="font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">Tối thiểu giao dịch 2 triệu đồng sử dụng Thẻ VPBank...</small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top border-light border-dashed d-flex justify-content-between align-items-center py-2">
                        <span class="text-secondary fw-bold promo-code-text" style="font-size: 13px;"><i class="fa-regular fa-file-lines me-1"></i> VPSTAY150</span>
                        <button class="btn btn-sm text-primary fw-bold px-3 rounded-pill copy-btn" style="background-color: #e0f2fe;">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mb-4">
        <?= (!empty($departure) || !empty($arrival)) ? "Kết quả tìm kiếm chuyến bay" : "Các chuyến bay nổi bật" ?>
    </h3>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($flight = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm h-100 flight-card">
                        <div class="card-body p-4">
                            <div class="row align-items-center text-center text-md-start">

                                <!-- Hãng bay -->
                                <div class="col-md-3 mb-3 mb-md-0 d-flex flex-column align-items-center align-items-md-start">
                                    <img src="<?= htmlspecialchars($flight['thumbnail']) ?>"
                                        alt="<?= htmlspecialchars($flight['airline']) ?>" class="img-fluid mb-2"
                                        style="max-height: 40px; object-fit: contain;">
                                    <span class="fw-bold"><?= htmlspecialchars($flight['airline']) ?></span>
                                    <small class="text-muted"><?= htmlspecialchars($flight['flight_number']) ?></small>
                                </div>

                                <!-- Thời gian bay -->
                                <div class="col-md-6 mb-3 mb-md-0 d-flex justify-content-center align-items-center">
                                    <div class="text-center px-3">
                                        <h4 class="mb-0 fw-bold"><?= date('H:i', strtotime($flight['departure_time'])) ?></h4>
                                        <small class="text-muted"><?= htmlspecialchars($flight['departure_city']) ?></small>
                                    </div>

                                    <div class="text-center px-3 text-muted flex-grow-1">
                                        <small><?= date('d/m/Y', strtotime($flight['departure_time'])) ?></small>
                                        <div class="d-flex align-items-center justify-content-center my-1">
                                            <hr class="w-100 mx-2" style="border-top: 2px dashed #ccc;">
                                            <i class="fa-solid fa-plane text-primary"></i>
                                            <hr class="w-100 mx-2" style="border-top: 2px dashed #ccc;">
                                        </div>
                                        <small>Bay thẳng</small>
                                    </div>

                                    <div class="text-center px-3">
                                        <h4 class="mb-0 fw-bold"><?= date('H:i', strtotime($flight['arrival_time'])) ?></h4>
                                        <small class="text-muted"><?= htmlspecialchars($flight['arrival_city']) ?></small>
                                    </div>
                                </div>

                                <!-- Giá và Nút đặt -->
                                <div class="col-md-3 text-md-end">
                                    <h3 class="text-danger fw-bold mb-3"><?= formatPrice($flight['price']) ?></h3>
                                    <?php
                                        // Calculate total passengers selected
                                        $total_passengers = $adult + $child + $infant;
                                    ?>
                                    <a href="flight-booking.php?id=<?= $flight['id'] ?>&total_passengers=<?= $total_passengers ?>"
                                        class="btn btn-warning fw-bold px-4 rounded-pill">Chọn chuyến bay</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2086/2086884.png" alt="No flights" width="100"
                    class="mb-3 opacity-50">
                <h4 class="text-muted">Không tìm thấy chuyến bay nào phù hợp.</h4>
                <p class="text-muted">Vui lòng thử nghiệm lại với điểm đến hoặc ngày khác.</p>
                <a href="flights.php" class="btn btn-outline-primary mt-2">Xóa bộ lọc</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .flight-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .flight-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Trip Type Radio Buttons
    const oneWay = document.getElementById('oneWay');
    const roundTrip = document.getElementById('roundTrip');
    const returnDateInput = document.getElementById('returnDateInput');
    const returnDateIcon = returnDateInput.previousElementSibling;

    function toggleReturnDate() {
        if (roundTrip.checked) {
            returnDateInput.disabled = false;
            returnDateInput.classList.remove('bg-light', 'text-muted');
            returnDateInput.classList.add('bg-white');
            returnDateIcon.classList.remove('bg-light');
            returnDateIcon.classList.add('bg-white');
        } else {
            returnDateInput.disabled = true;
            returnDateInput.value = '';
            returnDateInput.classList.add('bg-light', 'text-muted');
            returnDateInput.classList.remove('bg-white');
            returnDateIcon.classList.add('bg-light');
            returnDateIcon.classList.remove('bg-white');
        }
    }

    oneWay.addEventListener('change', toggleReturnDate);
    roundTrip.addEventListener('change', toggleReturnDate);
    // document.getElementById('multiCity').addEventListener('change', toggleReturnDate);

    // 2. Swap Button
    const swapBtn = document.getElementById('swapBtn');
    const departureInput = document.getElementById('departureInput');
    const arrivalInput = document.getElementById('arrivalInput');

    swapBtn.addEventListener('click', function() {
        const temp = departureInput.value;
        departureInput.value = arrivalInput.value;
        arrivalInput.value = temp;
        
        // Add a small rotation animation
        this.style.transition = 'transform 0.3s ease';
        this.style.transform = 'rotate(180deg)';
        setTimeout(() => {
            this.style.transition = 'none';
            this.style.transform = 'rotate(0deg)';
        }, 300);
    });

    // 3. Class Dropdown
    const classOptions = document.querySelectorAll('.class-option');
    const classText = document.getElementById('classText');
    const hiddenClass = document.getElementById('hiddenClass');
    classOptions.forEach(opt => {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            const val = this.getAttribute('data-value');
            classText.textContent = val;
            hiddenClass.value = val;
        });
    });

    // 4. Promo Code Copy
    const copyBtns = document.querySelectorAll('.copy-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const promoText = this.previousElementSibling.textContent.trim();
            navigator.clipboard.writeText(promoText).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = 'Copied!';
                this.classList.replace('text-primary', 'text-success');
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.replace('text-success', 'text-primary');
                }, 2000);
            });
        });
    });
});

// Passenger Dropdown Logic (Global scope for onclick)
let pax = { adult: <?= $adult ?>, child: <?= $child ?>, infant: <?= $infant ?> };
function updatePax(type, change) {
    if (pax[type] + change >= (type === 'adult' ? 1 : 0)) {
        pax[type] += change;
        document.getElementById(type + 'Count').textContent = pax[type];
        document.getElementById('paxText').textContent = 
            `${pax.adult} Người lớn, ${pax.child} Trẻ em, ${pax.infant} Em bé`;
        
        // Update hidden inputs
        document.getElementById('hidden' + type.charAt(0).toUpperCase() + type.slice(1)).value = pax[type];
    }
}
</script>

<?php include 'includes/footer.php'; ?>