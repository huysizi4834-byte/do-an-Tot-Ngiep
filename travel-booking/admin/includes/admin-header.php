<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TheGioi Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: #fff;
            background-color: #495057;
        }

        .main-content {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3 text-center border-bottom border-secondary">
                    <h4>Admin Panel</h4>
                </div>
                <nav class="nav flex-column mt-3">
                    <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>"
                        href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <a class="nav-link text-warning fw-bold <?= ($current_page == 'face-checkin.php') ? 'active' : '' ?>"
                        href="face-checkin.php"><i class="bi bi-camera-video me-2"></i> Face Check-in</a>
                    <a class="nav-link <?= (in_array($current_page, ['tours.php', 'add-tour.php', 'edit-tour.php'])) ? 'active' : '' ?>"
                        href="tours.php"><i class="bi bi-geo-alt me-2"></i> Quản lý Tours</a>
                    <a class="nav-link ms-3 <?= ($current_page == 'featured-tours.php') ? 'active' : '' ?>"
                        href="featured-tours.php"><i class="bi bi-star me-2"></i> Tour nổi bật (Trang chủ)</a>
                    <a class="nav-link ms-3 <?= ($current_page == 'destinations.php') ? 'active' : '' ?>"
                        href="destinations.php"><i class="bi bi-map me-2"></i> Điểm đến (Trang chủ)</a>
                    <a class="nav-link <?= (in_array($current_page, ['bookings.php', 'booking-detail.php'])) ? 'active' : '' ?>"
                        href="bookings.php"><i class="bi bi-calendar-check me-2"></i> Đặt tour</a>
                    <a class="nav-link <?= ($current_page == 'hotels.php') ? 'active' : '' ?>" href="hotels.php"><i class="bi bi-building me-2"></i> Khách sạn</a>
                    <a class="nav-link <?= (in_array($current_page, ['hotel-bookings.php', 'hotel-booking-detail.php'])) ? 'active' : '' ?>" href="hotel-bookings.php"><i class="bi bi-calendar-event me-2"></i> Đặt khách sạn</a>
                    <a class="nav-link <?= (in_array($current_page, ['flights.php', 'add-flight.php', 'edit-flight.php'])) ? 'active' : '' ?>" href="flights.php"><i class="bi bi-airplane me-2"></i> Quản lý Máy bay</a>
                    <a class="nav-link <?= (in_array($current_page, ['flight-bookings.php', 'flight-booking-detail.php'])) ? 'active' : '' ?>" href="flight-bookings.php"><i class="bi bi-ticket-detailed me-2"></i> Đặt vé máy bay</a>
                    <a class="nav-link <?= (in_array($current_page, ['combos.php', 'add-combo.php', 'edit-combo.php'])) ? 'active' : '' ?>"
                        href="combos.php"><i class="bi bi-collection me-2"></i> Quản lý Combos</a>
                    <a class="nav-link <?= (in_array($current_page, ['combo-bookings.php', 'combo-booking-detail.php'])) ? 'active' : '' ?>"
                        href="combo-bookings.php"><i class="bi bi-calendar2-check me-2"></i> Đặt Combos</a>
                    <a class="nav-link <?= (in_array($current_page, ['services.php', 'add-service.php', 'edit-service.php'])) ? 'active' : '' ?>"
                        href="services.php"><i class="bi bi-box-seam me-2"></i> Quản lý Dịch vụ</a>
                    <a class="nav-link <?= (in_array($current_page, ['promotions.php', 'add-promotion.php', 'edit-promotion.php'])) ? 'active' : '' ?>"
                        href="promotions.php"><i class="bi bi-tag me-2"></i> Quản lý Khuyến mại</a>
                    <a class="nav-link <?= (in_array($current_page, ['contacts.php', 'view-contact.php'])) ? 'active' : '' ?>"
                        href="contacts.php"><i class="bi bi-envelope me-2"></i> Quản lý Liên hệ</a>
                    <a class="nav-link <?= (in_array($current_page, ['guides.php', 'add-guide.php', 'edit-guide.php', 'guide-images.php'])) ? 'active' : '' ?>"
                        href="guides.php"><i class="bi bi-journal-text me-2"></i> Quản lý Cẩm nang</a>
                    <a class="nav-link <?= (in_array($current_page, ['bespoke.php', 'view-bespoke.php'])) ? 'active' : '' ?>"
                        href="bespoke.php"><i class="bi bi-star me-2"></i> Yêu cầu Bespoke</a>
                    <a class="nav-link <?= (in_array($current_page, ['service-bookings.php', 'service-booking-detail.php'])) ? 'active' : '' ?>"
                        href="service-bookings.php"><i class="bi bi-cart-check me-2"></i> Đặt Dịch vụ</a>
                    <a class="nav-link <?= (in_array($current_page, ['users.php', 'user-detail.php'])) ? 'active' : '' ?>"
                        href="users.php"><i class="bi bi-people me-2"></i> Người dùng</a>
                    <a class="nav-link <?= ($current_page == 'reviews.php') ? 'active' : '' ?>" href="reviews.php"><i
                            class="bi bi-star me-2"></i> Đánh giá</a>
                    <a class="nav-link text-danger mt-5" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>
                        Đăng xuất</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Topbar -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h2><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h2>
                    <div>
                        <span class="me-3">Xin chào, Admin</span>
                    </div>
                </div>