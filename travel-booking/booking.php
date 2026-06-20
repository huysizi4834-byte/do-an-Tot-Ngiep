<?php
require 'includes/db.php';

$tour_id = isset($_GET['tour_id']) ? (int) $_GET['tour_id'] : 1;

// Lấy thông tin tour để hiển thị
$sql = "SELECT * FROM tours WHERE id = $tour_id";
$result = mysqli_query($conn, $sql);
$tour = mysqli_fetch_assoc($result);

if (!$tour) {
    die("Tour không tồn tại");
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đặt Tour: <?= htmlspecialchars($tour['title'] ?? 'Tour Du Lịch') ?></h4>
                </div>
                <div class="card-body p-4">
                    <form action="includes/booking-process.php" method="POST">
                        <input type="hidden" name="tour_id" value="<?= $tour_id ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ngày khởi hành</label>
                            <input type="date" name="departure_date" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Số lượng người</label>
                            <input type="number" name="total_people" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-4 p-3 bg-light rounded border-top pt-3">
                            <span class="fw-bold">Tổng tiền:</span>
                            <span class="fs-4 fw-bold text-danger" id="total-price" data-unit-price="<?= $tour['price'] ?>">
                                <?= formatPrice($tour['price']) ?>
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Hình thức thanh toán</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_type" id="pay_full" value="full" checked>
                                <label class="form-check-label fw-bold" for="pay_full">Thanh toán toàn bộ 100%</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_type" id="pay_deposit" value="deposit">
                                <label class="form-check-label fw-bold" for="pay_deposit">Đặt cọc trước 50%</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="tour-detail.php?id=<?= $tour_id ?>" class="btn btn-outline-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                                Xác nhận Đặt tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const peopleInput = document.querySelector('input[name="total_people"]');
    const totalPriceEl = document.getElementById('total-price');
    const unitPrice = parseFloat(totalPriceEl.getAttribute('data-unit-price')) || 0;

    const currencyFormat = "<?= $_SESSION['currency'] ?? 'VND' ?>";
    const exchangeRate = <?= isset($_SESSION['currency']) ? 
        ($_SESSION['currency'] == 'USD' ? 25000 : 
        ($_SESSION['currency'] == 'EUR' ? 27000 : 
        ($_SESSION['currency'] == 'JPY' ? 170 : 1))) : 1 ?>;

    function updateTotal() {
        let people = parseInt(peopleInput.value, 10);
        if (isNaN(people) || people < 1) people = 1;
        
        let rawTotalVND = people * unitPrice;
        let convertedTotal = rawTotalVND / exchangeRate;
        
        let formattedTotal = '';
        if(currencyFormat === 'VND') {
            formattedTotal = new Intl.NumberFormat('vi-VN').format(convertedTotal) + ' ₫';
        } else if(currencyFormat === 'USD') {
            formattedTotal = '$' + new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedTotal);
        } else if(currencyFormat === 'EUR') {
            formattedTotal = '€' + new Intl.NumberFormat('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(convertedTotal);
        } else if(currencyFormat === 'JPY') {
            formattedTotal = '¥' + new Intl.NumberFormat('ja-JP').format(convertedTotal);
        }
        
        totalPriceEl.textContent = formattedTotal;
    }

    peopleInput.addEventListener('input', updateTotal);
    updateTotal();
});
</script>

<?php include 'includes/footer.php'; ?>