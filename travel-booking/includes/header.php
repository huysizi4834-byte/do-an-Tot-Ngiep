<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/functions.php';

// Default values
$current_currency = $_SESSION['currency'] ?? 'VND';
$current_location = $_SESSION['location'] ?? 'VN';

$locations = [
    'VN' => 'TP. Hồ Chí Minh',
    'US' => 'Hoa Kỳ (Mỹ)',
    'EU' => 'Châu Âu',
    'JP' => 'Nhật Bản'
];

$currencies = [
    'VND' => '🇻🇳 VND',
    'USD' => '🇺🇸 USD',
    'EUR' => '🇪🇺 EUR',
    'JPY' => '🇯🇵 JPY'
];
?>
<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>THEGIOI Travel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <header class="main-header">

        <div class="header-container">

            <!-- LOGO -->

            <a href="index.php" class="logo-area">

                <h1 class="logo-title">
                    THEGIOI
                </h1>

                <div class="logo-sub">
                    Travel & Tour
                </div>

            </a>

            <!-- SEARCH -->

            <form class="search-box" action="tours.php" method="GET">

                <i class="fa-solid fa-magnifying-glass" onclick="const input = this.nextElementSibling; if(document.activeElement === input || input.value) { this.closest('form').submit(); } else { input.focus(); }" style="cursor: pointer; pointer-events: auto;" title="Tìm kiếm"></i>

                <input type="text" name="search" placeholder="Tìm kiếm...">

            </form>

            <!-- MENU -->

            <nav class="header-menu">

                <a href="tours.php">
                    Tour trọn gói
                </a>

                <a href="flights.php">
                    Vé máy bay
                </a>

                <a href="hotels.php">
                    Khách sạn
                </a>

                <a href="combos.php">
                    Combo du lịch
                </a>

                <a href="services.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'text-primary fw-bold' : '' ?>">
                    Dịch vụ cộng thêm
                </a>

                <a href="voucher-center.php" class="text-danger fw-bold <?= (basename($_SERVER['PHP_SELF']) == 'voucher-center.php') ? 'active' : '' ?>">
                    <i class="fa-solid fa-gift me-1"></i> Săn Voucher
                </a>

            </nav>

            <!-- RIGHT -->

            <div class="header-right">

                <div class="dropdown">
                    <div class="currency dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                        <?= $currencies[$current_currency] ?? '🇻🇳 VND' ?>
                    </div>
                    <ul class="dropdown-menu">
                        <?php foreach($currencies as $currency_code => $label): ?>
                            <li><a class="dropdown-item currency-select" href="#" data-currency="<?= $currency_code ?>"><?= $label ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="dropdown">
                    <div class="location dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= $locations[$current_location] ?? 'TP. Hồ Chí Minh' ?>
                    </div>
                    <ul class="dropdown-menu">
                        <?php foreach($locations as $loc_code => $name): ?>
                            <li><a class="dropdown-item location-select" href="#" data-location="<?= $loc_code ?>"><i class="fa-solid fa-location-dot me-2 text-muted"></i><?= $name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <div class="dropdown">

                        <a href="#" class="login-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                            style="text-decoration: none; color: inherit; display: inline-flex; align-items: center; gap: 8px;">

                            <i class="fa-solid fa-circle-user"></i>

                            <?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Tài khoản' ?>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

                                <li><a class="dropdown-item" href="admin/dashboard.php"><i class="fa-solid fa-gauge me-2"></i>
                                        Admin Panel</a></li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                            <?php endif; ?>

                            <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user me-2"></i> Hồ sơ</a>
                            </li>

                            <li><a class="dropdown-item" href="my-bookings.php"><i
                                        class="fa-solid fa-calendar-check me-2"></i> Tour của tôi</a></li>

                            <li><a class="dropdown-item" href="my-bespoke.php"><i
                                        class="fa-solid fa-star me-2"></i> Tour thiết kế riêng</a></li>

                            <li><a class="dropdown-item" href="my-vouchers.php"><i
                                        class="fa-solid fa-ticket-simple me-2"></i> Kho Voucher</a></li>

                            <li><a class="dropdown-item" href="my-support.php"><i
                                        class="fa-solid fa-headset me-2"></i> Lịch sử Hỗ trợ</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li><a class="dropdown-item text-danger" href="includes/auth/logout.php"><i
                                        class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất</a></li>

                        </ul>

                    </div>

                <?php else: ?>

                    <a href="login.php" class="login-btn">

                        <i class="fa-solid fa-circle-user"></i>

                        Đăng nhập

                    </a>

                <?php endif; ?>

                <a href="cart.php" class="text-dark" style="text-decoration: none;">
                    <i class="fa-solid fa-cart-shopping header-icon"></i>
                </a>

                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="text-dark dropdown-toggle" style="text-decoration: none;">
                        <i class="fa-solid fa-bars header-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="background-color: #003b73; border: none; border-radius: 8px; padding: 10px 0; min-width: 220px;">
                        <li class="d-lg-none"><a class="dropdown-item text-white py-2 custom-menu-item" href="tours.php" style="font-size: 16px;">Tour trọn gói</a></li>
                        <li class="d-lg-none"><a class="dropdown-item text-white py-2 custom-menu-item" href="flights.php" style="font-size: 16px;">Vé máy bay</a></li>
                        <li class="d-lg-none"><a class="dropdown-item text-white py-2 custom-menu-item" href="hotels.php" style="font-size: 16px;">Khách sạn</a></li>
                        <li class="d-lg-none"><a class="dropdown-item text-white py-2 custom-menu-item" href="combos.php" style="font-size: 16px;">Combo du lịch</a></li>
                        <li class="d-lg-none"><a class="dropdown-item text-white py-2 custom-menu-item" href="services.php" style="font-size: 16px;">Dịch vụ cộng thêm</a></li>
                        <li class="d-lg-none"><a class="dropdown-item text-warning fw-bold py-2 custom-menu-item" href="voucher-center.php" style="font-size: 16px;"><i class="fa-solid fa-gift me-1"></i> Săn Voucher</a></li>
                        <li class="d-lg-none"><hr class="dropdown-divider bg-light opacity-25"></li>
                        <li><a class="dropdown-item text-white py-2 custom-menu-item" href="guide.php" style="font-size: 16px;">Cẩm nang du lịch</a></li>
                        <li><a class="dropdown-item text-white py-2 custom-menu-item" href="bespoke.php" style="font-size: 16px;">Bespoke</a></li>
                        <li><a class="dropdown-item text-white py-2 custom-menu-item" href="about.php" style="font-size: 16px;">Giới thiệu</a></li>
                        <li><a class="dropdown-item text-white py-2 custom-menu-item" href="faq.php" style="font-size: 16px;">Hỏi đáp</a></li>
                        <li><a class="dropdown-item text-white py-2 custom-menu-item" href="support.php" style="font-size: 16px;">Hỗ trợ</a></li>
                    </ul>
                </div>

            </div>

        </div>

    </header>

    <style>
    .custom-menu-item:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
    }
    /* Hide caret for the hamburger and location/currency to keep it clean if desired, but we only hide for hamburger here */
    .header-right .dropdown-toggle:empty::after {
        display: none;
    }
    .header-right a.dropdown-toggle > .fa-bars + ::after {
        display: none;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle currency change
        document.querySelectorAll('.currency-select').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const currency = this.getAttribute('data-currency');
                updatePreferences({currency: currency});
            });
        });

        // Handle location change
        document.querySelectorAll('.location-select').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const location = this.getAttribute('data-location');
                updatePreferences({location: location});
            });
        });

        function updatePreferences(data) {
            const formData = new URLSearchParams();
            for (const key in data) {
                formData.append(key, data[key]);
            }

            fetch('set_preferences.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString()
            })
            .then(response => response.json())
            .then(result => {
                if(result.success) {
                    window.location.reload(); // Tải lại trang để cập nhật giá
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
    </script>