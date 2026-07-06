-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 06, 2026 lúc 02:34 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `travel_booking_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `additional_services`
--

CREATE TABLE `additional_services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `additional_services`
--

INSERT INTO `additional_services` (`id`, `name`, `description`, `price`, `image_url`, `created_at`) VALUES
(5, 'eSIM for Singapore by Frewie', 'Bạn sẽ trải nghiệm\r\nStay connected wherever your travels take you with this eSIM data plan\r\nEnjoy your trip while staying in touch with your loved ones across the globe\r\nTry the instant activation by scanning a QR code and you\'re ready to use your device\r\nGet your eSIM and experience a seamless journey wherever you go!', 50000000.00, 'assets/images/services/service_6a33577496915.webp', '2026-06-18 02:23:01'),
(6, 'Thuê Xe Ô Tô Tự Lái (4 chỗ)', 'Trải nghiệm du lịch tự do và thoải mái với dịch vụ thuê xe ô tô 4 chỗ đời mới. Thủ tục nhanh gọn, giao xe tận nơi tại sân bay hoặc khách sạn.', 800000.00, 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(7, 'Vé Tham Quan Vinpearl Safari', 'Vé tham quan công viên chăm sóc và bảo tồn động vật bán hoang dã lớn nhất Việt Nam. Trải nghiệm \"nhốt người thả thú\" độc đáo.', 650000.00, 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(8, 'Gói Massage & Spa Tại Khách Sạn', 'Thư giãn hoàn toàn sau một ngày dài khám phá với gói massage toàn thân 60 phút do các kỹ thuật viên chuyên nghiệp thực hiện ngay tại spa của khách sạn.', 500000.00, 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(9, 'Đón/Tiễn Sân Bay Bằng Xe VIP', 'Dịch vụ xe đưa đón sân bay cao cấp với tài xế riêng, bảng tên đón khách. Cung cấp nước suối và khăn lạnh miễn phí. Chuyến đi êm ái, đúng giờ.', 350000.00, 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(10, 'Vé Cáp Treo Vượt Biển', '<p>Thưởng ngoạn khung cảnh thi&ecirc;n nhi&ecirc;n h&ugrave;ng vĩ từ tr&ecirc;n cao với v&eacute; c&aacute;p treo khứ hồi. Bao gồm cả quyền truy cập v&agrave;o c&aacute;c khu vui chơi giải tr&iacute; tr&ecirc;n đảo.</p>\r\n', 550000.00, 'assets/images/services/service_6a36050009a55.png', '2026-06-20 03:09:01'),
(11, 'Bữa Tối Lãng Mạn Trên Bãi Biển', 'Set up bàn ăn lãng mạn dành cho 2 người ngay trên bãi biển với nến, hoa hồng và thực đơn hải sản cao cấp. Kỷ niệm không thể nào quên.', 1500000.00, 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(12, 'Hướng Dẫn Viên Du Lịch Riêng', 'Thuê hướng dẫn viên bản địa am hiểu sâu sắc về văn hóa, lịch sử và ẩm thực địa phương đồng hành cùng bạn suốt cả ngày dài.', 1000000.00, 'https://images.unsplash.com/photo-1506869640319-fe1a24fd76dc?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(13, 'Vé Tàu Cao Tốc Đi Các Đảo', '<p>V&eacute; t&agrave;u cao tốc khứ hồi đến c&aacute;c h&ograve;n đảo l&acirc;n cận tuyệt đẹp. T&agrave;u chạy &ecirc;m, an to&agrave;n, c&oacute; điều h&ograve;a v&agrave; &aacute;o phao đầy đủ.</p>\r\n', 300000.00, 'assets/images/services/service_6a3604c4cd931.jpg', '2026-06-20 03:09:01'),
(14, 'Thuê Thợ Chụp Ảnh Kỷ Niệm', 'Lưu giữ mọi khoảnh khắc đẹp nhất trong chuyến đi với dịch vụ thuê nhiếp ảnh gia chuyên nghiệp đi cùng (gói chụp 4 tiếng, trả toàn bộ file gốc và 20 ảnh edit).', 1200000.00, 'https://images.unsplash.com/photo-1516961642265-531546e84af2?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01'),
(15, 'Gói Trang Trí Phòng Trăng Mật', 'Trang trí phòng tân hôn ngọt ngào với thiên nga gấp bằng khăn tay, cánh hoa hồng rải giường, rượu vang và trái cây tươi đón chào.', 700000.00, 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=800', '2026-06-20 03:09:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bespoke_requests`
--

CREATE TABLE `bespoke_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `pax` int(11) NOT NULL,
  `budget` varchar(255) NOT NULL,
  `requirements` text DEFAULT NULL,
  `status` enum('new','processing','completed') DEFAULT 'new',
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bespoke_requests`
--

INSERT INTO `bespoke_requests` (`id`, `user_id`, `name`, `phone`, `email`, `destination`, `start_date`, `duration`, `pax`, `budget`, `requirements`, `status`, `admin_note`, `created_at`) VALUES
(2, NULL, 'nguyên huy', '098765432', 'huynt5454@gmail.com', 'THÀNH PHỐ HÀ NỘI ', '2026-06-19', 10, 15, 'Dưới 50 triệu', 'CÓ NGƯỜI GIÀ CNGOJ TRẺ NHỎ', 'completed', 'tôi sẽ ửi bản kế hoạch trong thời gian sớm nhất', '2026-06-18 02:01:26'),
(3, NULL, '123', '09876543', 'huynt544@gmail.com', 'THÀNH PHỐ HÀ NỘI ', '2026-06-19', 2, 2, '100 - 200 triệu', '', 'completed', '', '2026-06-18 02:07:15'),
(4, 6, 'ad2', '098636463', 'huy123@gmail.com', 'THÀNH PHỐ HÀ NỘI ', '2026-06-05', 6, 4, '50 - 100 triệu', '', 'completed', 'ok ban', '2026-06-18 02:11:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `tour_id` bigint(20) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `total_people` int(11) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `payment_type` enum('full','deposit') DEFAULT 'full',
  `amount_paid` decimal(15,2) DEFAULT 0.00,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `booking_status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cccd` varchar(20) DEFAULT NULL,
  `representative_name` varchar(100) DEFAULT NULL,
  `payment_face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `tour_id`, `booking_code`, `departure_date`, `total_people`, `total_amount`, `payment_type`, `amount_paid`, `payment_status`, `booking_status`, `created_at`, `cccd`, `representative_name`, `payment_face_image`) VALUES
(8, 5, 2, 'TR35BA87', '2026-06-20', 5, 200000000.00, 'full', 200000000.00, 'paid', 'completed', '2026-06-18 02:53:39', NULL, NULL, NULL),
(9, 5, 2, 'TRD54967', '2026-06-13', 1, 40000000.00, 'full', 40000000.00, 'paid', 'completed', '2026-06-18 02:55:09', NULL, NULL, NULL),
(10, 5, 2, 'TR38D16F', '2026-06-21', 5, 200000000.00, 'full', 200000000.00, 'paid', 'completed', '2026-06-18 03:03:47', NULL, NULL, NULL),
(12, 5, 2, 'TR5E5D1D', '2026-06-19', 6, 240000000.00, 'deposit', 120000000.00, 'paid', 'completed', '2026-06-18 03:19:01', '098765423', 'nguyễn van á', 'uploads/payments/pay_face_TR5E5D1D_1781752795.jpg'),
(13, 5, 20, 'TR73F3C4', '2026-06-28', 5, 375000000.00, 'full', 375000000.00, 'paid', 'pending', '2026-06-21 02:56:07', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_passengers`
--

CREATE TABLE `booking_passengers` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `passport_no` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `combos`
--

CREATE TABLE `combos` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `price_details` text DEFAULT NULL,
  `hotel_system` text DEFAULT NULL,
  `policy` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `combos`
--

INSERT INTO `combos` (`id`, `name`, `description`, `highlights`, `price_details`, `hotel_system`, `policy`, `price`, `original_price`, `duration`, `image`, `status`, `created_at`) VALUES
(1, 'COMBO VÉ MÁY BAY & PHÒNG NHA TỪ SÀI GÒN', '<p>COMBO V&Eacute; M&Aacute;Y BAY &ndash; PH&Ograve;NG KH&Aacute;CH SẠN QUY NHƠN TỪ S&Agrave;I G&Ograve;N</p>\r\n', '<p>COMBO V&Eacute; M&Aacute;Y BAY &ndash; PH&Ograve;NG KH&Aacute;CH SẠN QUY NHƠN TỪ S&Agrave;I G&Ograve;N với h&agrave;nh tr&igrave;nh 3 ng&agrave;y 2 đ&ecirc;m hoặc 4 ng&agrave;y 3 đ&ecirc;m . Gi&aacute; bao gồm chi ph&iacute; v&eacute; m&aacute;y bay&nbsp;<a href=\"https://www.bambooairways.com/vn-vi/\">Bamboo airways</a>&nbsp;hoặc Vietnamairlines v&agrave; kh&aacute;ch sạn nhưng chỉ bằng gi&aacute; chưa bằng gi&aacute; v&eacute; m&aacute;y bay khi mua v&eacute; lẻ</p>\r\n', '<ul>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 3*** ng&agrave;y trong tuần :3.690.000 VNĐ</li>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 3*** ng&agrave;y cuối tuần : 5.290.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 3*** ng&agrave;y trong tuần :3.990.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 3**** ng&agrave;y cuối tuần :5.490.000 VNĐ</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 4**** ng&agrave;y trong tuần :3.890.000 VNĐ</li>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 4**** ng&agrave;y cuối tuần :5.490.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 4**** ng&agrave;y trong tuần :4.390.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 4**** ng&agrave;y cuối tuần :5.990.000 VNĐ</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 5***** ng&agrave;y trong tuần :4.590.000 VNĐ</li>\r\n	<li>Combo 3N2Đ Kh&aacute;ch sạn 4***** ng&agrave;y cuối tuần : 6.290.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 4***** ng&agrave;y trong tuần:5.390.000 VNĐ</li>\r\n	<li>Combo 4N3Đ Kh&aacute;ch sạn 4***** ng&agrave;y cuối tuần : 7.190.000 VNĐ</li>\r\n</ul>\r\n', '<h3><strong>KH&Aacute;CH SẠN 3 SAO&nbsp;</strong>COMBO COMBO V&Eacute; M&Aacute;Y BAY &ndash; PH&Ograve;NG KH&Aacute;CH SẠN QUY NHƠN TỪ S&Agrave;I G&Ograve;N</h3>\r\n\r\n<ul>\r\n	<li><strong>HO&Agrave;NG YẾN CANARY QUY NHƠN &ndash;&nbsp;</strong>Hạng ph&ograve;ng: Deluxe DBL/TWIN</li>\r\n	<li><strong>HẢI &Acirc;U BI&Ecirc;N CƯƠNG &ndash;&nbsp;</strong>Hạng ph&ograve;ng Superior</li>\r\n</ul>\r\n\r\n<h3><strong>KH&Aacute;CH SẠN 4 SAO COMBO V&Eacute; M&Aacute;Y BAY &ndash; PH&Ograve;NG KH&Aacute;CH SẠN QUY NHƠN TỪ S&Agrave;I G&Ograve;N</strong></h3>\r\n\r\n<ul>\r\n	<li><strong>HO&Agrave;NG YẾN 1 &ndash; 4 SAO-&nbsp;</strong>Hạng ph&ograve;ng: Deluxe DBL/ TWIN</li>\r\n	<li><strong>MƯỜNG THANH QUY NHƠN &ndash;&nbsp;</strong>Hạng ph&ograve;ng: Deluxe DBL/ TWIN</li>\r\n	<li><strong>ANYA HOTEL QUY NHƠN-&nbsp;</strong>Hạng ph&ograve;ng: Deluxe City View DBL/TWIN</li>\r\n</ul>\r\n\r\n<h3><strong>KH&Aacute;CH SẠN 5 SAO COMBO V&Eacute; M&Aacute;Y BAY &ndash; PH&Ograve;NG KH&Aacute;CH SẠN QUY NHƠN TỪ S&Agrave;I G&Ograve;N&nbsp;</strong></h3>\r\n\r\n<ul>\r\n	<li><strong>ALTARA SERVICED RESIDENCES QUY NHON &ndash;&nbsp;</strong>Căn hộ 1 ph&ograve;ng ngủ (2 giường Hollywood Twin/ DBL twin gh&eacute;p giường)</li>\r\n</ul>\r\n', '<ul>\r\n	<li>Do c&aacute;c chuyến bay phụ thuộc v&agrave;o c&aacute;c h&atilde;ng H&agrave;ng Kh&ocirc;ng n&ecirc;n trong một số trường hợp giờ bay c&oacute; thể thay đổi m&agrave; kh&ocirc;ng được b&aacute;o trước. T&ugrave;y v&agrave;o t&igrave;nh h&igrave;nh thực tế, thứ tự c&aacute;c điểm tham quan trong chương tr&igrave;nh c&oacute; thể thay đổi nhưng vẫn đảm bảo đầy đủ c&aacute;c điểm tham quan như l&uacute;c đầu.</li>\r\n	<li><strong>Vietworld Travel&nbsp;</strong>&nbsp;sẽ kh&ocirc;ng chịu tr&aacute;ch nhiệm ho&agrave;n trả ph&iacute; combo khi\r\n	<ul>\r\n		<li>Xảy ra thi&ecirc;n tai: b&atilde;o lụt, hạn h&aacute;n, động đất.</li>\r\n		<li>Sự cố về an ninh: khủng bố, biểu t&igrave;nh.</li>\r\n		<li>Sự cố về h&agrave;ng kh&ocirc;ng: trục trặc kỹ thuật, an ninh, dời, hủy, ho&atilde;n chuyến bay.</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n', 36000000.00, 43200000.00, '5 ngày 4 đêm', 'assets/images/1781750137_Nha-Trang-scaled.jpg', 'active', '2026-06-18 02:35:37'),
(2, 'Combo Phú Quốc 3N2Đ: Vé máy bay + Vinpearl Resort', '<p>Trải nghiệm thi&ecirc;n đường nghỉ dưỡng Ph&uacute; Quốc với v&eacute; m&aacute;y bay khứ hồi v&agrave; ph&ograve;ng nghỉ đẳng cấp.</p>\r\n', '<p>Vinoasis Ph&uacute; Quốc được v&iacute; như ốc đảo thu nhỏ tr&ecirc;n đảo ngọc. VinOasis l&agrave; quần thể nghỉ dưỡng đẳng cấp, sang trọng ti&ecirc;u chuẩn quốc tế bao gồm 1,378 ph&ograve;ng nghỉ tiện nghi, với thế giới ẩm thực quốc tế phong ph&uacute;, nhiều khu vui chơi độc đ&aacute;o, c&aacute;c dịch vụ tiện &iacute;ch v&agrave; giải tr&iacute; s&ocirc;i động mang đến một h&agrave;nh tr&igrave;nh trải nghiệm bất tận cho c&aacute;c gia đ&igrave;nh v&agrave; c&aacute;c nh&oacute;m du kh&aacute;ch.<br />\r\nVinoasis Ph&uacute; Quốc c&aacute;ch khu vui chơi Vinwonders Ph&uacute; Quốc tầm 2km, Vinpearl Safari tầm 4 km, Grandworld khoảng 1km, c&aacute;ch thị trấn Dương Đ&ocirc;ng khoảng 20,4km v&agrave; c&aacute;ch s&acirc;n bay Ph&uacute; Quốc khoảng 34,2km.<br />\r\nĐ&acirc;y l&agrave; khu Resort đặc biệt được Vinpearl ưu &aacute;i c&oacute; c&ocirc;ng vi&ecirc;n nước ri&ecirc;ng trong khu&ocirc;n vi&ecirc;n.</p>\r\n', '', '', '', 4500000.00, 6500000.00, '3 Ngày 2 Đêm', 'assets/images/1781923398_6a334dac41d9b_1.jpg', 'active', '2026-06-20 02:06:02'),
(3, 'Combo Đà Lạt 4N3Đ: Vé máy bay + Khách sạn 4*', 'Tận hưởng không khí se lạnh Đà Lạt, lưu trú tại trung tâm và vé tham quan các điểm nổi tiếng.', NULL, NULL, NULL, NULL, 3200000.00, 4000000.00, '4 Ngày 3 Đêm', 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?q=80&w=2000&auto=format&fit=crop', 'active', '2026-06-20 02:06:02'),
(4, 'Combo Siêu Tiết Kiệm Nha Trang 3N2Đ', '<p>Nghỉ dưỡng 3 ng&agrave;y 2 đ&ecirc;m tại resort 5 sao bờ biển Nha Trang, bao gồm ăn s&aacute;ng buffet.</p>\r\n\r\n<p>\\r\\n</p>\r\n', '<ul>\r\n	<li>Di chuyển linh hoạt</li>\r\n	<li>&nbsp;</li>\r\n	<li>Lưu tr&uacute; tiện nghi</li>\r\n	<li>&nbsp;</li>\r\n	<li>Trải nghiệm vịnh đảo</li>\r\n	<li>&nbsp;</li>\r\n	<li>Kh&aacute;m ph&aacute; văn h&oacute;a</li>\r\n	<li>&nbsp;</li>\r\n	<li>B&igrave;nh minh tr&ecirc;n SUP</li>\r\n	<li>&nbsp;</li>\r\n	<li>Chi ph&iacute; tối ưu</li>\r\n	<li>&nbsp;</li>\r\n</ul>\r\n', '<p><strong>Dịch vụ bao gồm</strong></p>\r\n\r\n<ul>\r\n	<li>Kh&aacute;ch sạn 3 sao view biển 02 đ&ecirc;m</li>\r\n	<li>01 Tour t&ugrave;y chọn bao gồm: City tour, Tour 03 đảo VIP , Tour Đồng cừu &ndash; Ninh Thuận</li>\r\n	<li>01 chai nước suối</li>\r\n	<li>V&eacute; buffet BBQ Hải Sản &ndash; Thoải m&aacute;i bia tươi</li>\r\n	<li><strong>Tặng</strong>&nbsp;Tour ch&egrave;o Sup ngắm b&igrave;nh minh</li>\r\n	<li>HDV hỗ trợ trong suốt chuyến đi</li>\r\n	<li>Bảo hiểm du lịch.</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Dịch vụ kh&ocirc;ng bao gồm</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li>Thuế GTGT (VAT) theo quy định hiện h&agrave;nh</li>\r\n	<li>Tiền tip cho hướng dẫn vi&ecirc;n v&agrave; t&agrave;i xế (kh&ocirc;ng bắt buộc)</li>\r\n	<li>Chi ph&iacute; c&aacute; nh&acirc;n, thức uống v&agrave; c&aacute;c dịch vụ vui chơi ph&aacute;t sinh ngo&agrave;i chương tr&igrave;nh</li>\r\n	<li>Gi&aacute; v&eacute; kh&ocirc;ng &aacute;p dụng cho c&aacute;c dịp Lễ Tết v&agrave; c&aacute;c dịp kh&aacute;c</li>\r\n</ul>\r\n', '', '<ul>\r\n	<li>\r\n	<p>Đ&acirc;y l&agrave;&nbsp;<strong>chương tr&igrave;nh tour gh&eacute;p</strong>, Qu&yacute; kh&aacute;ch vui l&ograve;ng kh&ocirc;ng tự &yacute; t&aacute;ch đo&agrave;n khi chưa c&oacute; sự đồng &yacute; của hướng dẫn vi&ecirc;n</p>\r\n	</li>\r\n	<li>\r\n	<p>Tu&acirc;n thủ thời gian tập trung theo hướng dẫn để đảm bảo lịch tr&igrave;nh chung v&agrave; quyền lợi của c&aacute;c th&agrave;nh vi&ecirc;n trong đo&agrave;n</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>QU&Yacute; KH&Aacute;CH N&Ecirc;N CHUẨN BỊ:</strong></p>\r\n\r\n	<ul>\r\n		<li>\r\n		<p>Gi&agrave;y thể thao hoặc d&eacute;p đế thấp, chống trơn trượt để thuận tiện di chuyển</p>\r\n		</li>\r\n		<li>\r\n		<p>M&aacute;y ảnh hoặc điện thoại để lưu lại những khoảnh khắc đẹp trong chuyến đi</p>\r\n		</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n', 2900000.00, 5800000.00, '3 Ngày 2 Đêm', 'assets/images/1781923632_combo-sieu-tiet-kiem-nha-trang-3n2d-du-lich-day-travel-05-400x227.webp', 'active', '2026-06-20 02:06:02'),
(5, 'Combo Sapa 2N1Đ: Xe Cabin Đôi + Khách sạn TT', '<h3>Sapa m&ugrave;a n&agrave;o cũng c&oacute; những vẻ đẹp ri&ecirc;ng, mỗi thời tiết kh&aacute;c nhau lại cho ta những bức tranh kh&aacute;c nhau về c&aacute;i nơi đồi n&uacute;i tưởng chừng như hoang sơ nhưng lại đầy hữu t&igrave;nh. Nếu bạn đang muốn kh&aacute;m ph&aacute; Sapa một c&aacute;ch trọn vẹn nhất,&nbsp;bạn n&ecirc;n lựa chọn combo Sapa 2N1Đ: Xe + Kh&aacute;ch Sạn.&nbsp;Xe kh&aacute;ch sẽ đưa bạn từ H&agrave; Nội đến Thị Trấn Sapa. Tại đ&acirc;y, bạn c&oacute; thể lựa chọn thu&ecirc; xe m&aacute;y hoặc đi taxi đến những địa danh nổi tiếng&nbsp;như: Nh&agrave; Thờ Đ&aacute;, Moana, Bản C&aacute;t C&aacute;t, Th&aacute;c Bạc, Fansipan, Đ&egrave;o &Ocirc; Quy Hồ, C&acirc;y C&ocirc; Đơn...</h3>\r\n', '<ul>\r\n	<li>Wifi</li>\r\n	<li>WC kh&eacute;p k&iacute;n</li>\r\n	<li>Tivi</li>\r\n	<li>Ph&ograve;ng kh&ocirc;ng h&uacute;t thuốc</li>\r\n	<li>Điều h&ograve;a</li>\r\n	<li>Thang m&aacute;y</li>\r\n	<li>M&aacute;y sấy t&oacute;c</li>\r\n	<li>Xe giường nằm cao cấp</li>\r\n	<li>Kh&aacute;ch sạn</li>\r\n</ul>\r\n', '<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp;&nbsp;Xe giường nằm khứ hồi H&agrave; Nội - Sapa - H&agrave; Nội</p>\r\n\r\n<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp; Xe trung chuyển đ&oacute;n, trả tận nơi tại kh&aacute;ch sạn Trung T&acirc;m Thị Trấn Sapa.</p>\r\n\r\n<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp;&nbsp;Nghỉ 01 đ&ecirc;m tại ph&ograve;ng ti&ecirc;u chuẩn (01 giường đ&ocirc;i) kh&aacute;ch sạn t&ugrave;y chọn địa điểm tại:&nbsp;Trung T&acirc;m Thị Trấn Sapa, Bản Tả Van, Bản C&aacute;t C&aacute;t...</p>\r\n\r\n<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp;&nbsp;Tr&agrave;, c&agrave; ph&ecirc;, nước uống trong ph&ograve;ng miễn ph&iacute;.</p>\r\n\r\n<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp;&nbsp;Miễn ph&iacute; nhận ph&ograve;ng sớm (Phụ thuộc v&agrave;o t&igrave;nh trạng ph&ograve;ng trống của kh&aacute;ch sạn).</p>\r\n\r\n<p><img alt=\"\" src=\"https://saodieu.vn/travel/media/Bai%20-%20viet/heart.png\" style=\"height:12px; width:12px\" />&nbsp;&nbsp;Hỗ trợ tư vấn lịch tr&igrave;nh chi tiết.</p>\r\n', '', '<p><strong>Quy định dịch vụ</strong></p>\r\n\r\n<ul>\r\n	<li>Xe giường nằm khứ hồi H&agrave; Nội - Sapa - H&agrave; Nội</li>\r\n	<li>Xe trung chuyển đ&oacute;n, trả tận nơi tại kh&aacute;ch sạn Trung T&acirc;m Thị Trấn Sapa.</li>\r\n	<li>Nghỉ 01 đ&ecirc;m tại ph&ograve;ng ti&ecirc;u chuẩn (01 giường đ&ocirc;i) kh&aacute;ch sạn t&ugrave;y chọn địa điểm tại:&nbsp;Trung T&acirc;m Thị Trấn Sapa, Bản Tả Van, Bản C&aacute;t C&aacute;t...</li>\r\n	<li>Tr&agrave;, c&agrave; ph&ecirc;, nước uống trong ph&ograve;ng miễn ph&iacute;.</li>\r\n	<li>Miễn ph&iacute; nhận ph&ograve;ng sớm (Phụ thuộc v&agrave;o t&igrave;nh trạng ph&ograve;ng trống của kh&aacute;ch sạn).</li>\r\n	<li>Hỗ trợ tư vấn lịch tr&igrave;nh chi tiết.</li>\r\n</ul>\r\n', 1250000.00, 1500000.00, '2 Ngày 1 Đêm', 'assets/images/1781924208_0.jpg', 'active', '2026-06-20 02:06:02'),
(6, 'Combo Bangkok - Pattaya 5N4Đ (Flash Sale)', '<p>Kh&aacute;m ph&aacute; Th&aacute;i Lan trọn vẹn với v&eacute; khứ hồi, kh&aacute;ch sạn 4* v&agrave; v&eacute; show Simon Cabaret.</p>\r\n', '<ul>\r\n	<li>Tham quan đảo Coral, tắm biển v&agrave; trải nghiệm c&aacute;c hoạt động dưới nước.</li>\r\n	<li>Gh&eacute; thăm C&ocirc;ng vi&ecirc;n khủng long Nong Nooch.</li>\r\n	<li>Chi&ecirc;m b&aacute;i Phật Bốn mặt v&agrave; mua sắm tại c&aacute;c trung t&acirc;m thương mại lớn.</li>\r\n	<li>Du ngoạn s&ocirc;ng Chaophraya v&agrave; viếng ch&ugrave;a Phật v&agrave;ng, ch&ugrave;a Thuyền.</li>\r\n	<li>Buffet tại BaiYoke Sky 86 tầng.</li>\r\n	<li>Thưởng thức c&agrave; ph&ecirc; v&agrave; b&aacute;nh phủ v&agrave;ng.</li>\r\n	<li>Trải nghiệm massage Th&aacute;i cổ truyền.</li>\r\n</ul>\r\n\r\n<p><em>Tour TP.HCM - Th&aacute;i Lan 5N4Đ đang c&oacute; gi&aacute; khuyến m&atilde;i hot. Li&ecirc;n hệ Vietnam Booking qua hotline&nbsp;<a href=\"tel:02873036167\">028 7303 6167</a>&nbsp;để đặt tour ngay h&ocirc;m nay!</em></p>\r\n', '<h3><u><strong>GI&Aacute; TOUR BAO GỒM</strong></u></h3>\r\n\r\n<ul>\r\n	<li>C&aacute;c chi ph&iacute; c&aacute; nh&acirc;n kh&aacute;c ngo&agrave;i chương tr&igrave;nh (giặt ủi, điện thoại, thức uống trong minibar&hellip;).</li>\r\n	<li>V&eacute; m&aacute;y bay h&agrave;ng kh&ocirc;ng khứ hồi theo đo&agrave;n (SGN &ndash; BKK &ndash; SGN).</li>\r\n	<li>Thuế phi trường hai nước, ph&iacute; an ninh, ph&iacute; xăng dầu (Thuế 147$ &aacute;p dụng theo thời điểm xuất v&eacute;).</li>\r\n	<li>H&agrave;nh l&yacute; k&yacute; gửi 20kg &amp; 07kg x&aacute;ch tay.</li>\r\n	<li>Kh&aacute;ch sạn 3 - 4 sao ti&ecirc;u chuẩn tại Th&aacute;i Lan.</li>\r\n	<li>C&aacute;c bữa ăn theo chương tr&igrave;nh tour: 04 bữa ăn s&aacute;ng buffet kh&aacute;ch sạn + 06 bữa ăn ch&iacute;nh.</li>\r\n	<li>Xe đưa đ&oacute;n theo chương tr&igrave;nh tham quan.</li>\r\n	<li>Trưởng đo&agrave;n Việt Nam v&agrave; hướng dẫn vi&ecirc;n Th&aacute;i Lan suốt tuyến.</li>\r\n	<li>Tặng n&oacute;n du lịch.</li>\r\n	<li>Bảo hiểm du lịch nước ngo&agrave;i (mức bồi thường tai nạn cao nhất về người l&agrave; 10.000 USD/kh&aacute;ch).</li>\r\n</ul>\r\n\r\n<h3><u><strong>GI&Aacute; TOUR KH&Ocirc;NG BAO GỒM</strong></u></h3>\r\n\r\n<ul>\r\n	<li>Hộ chiếu phải c&ograve;n hạn tr&ecirc;n 06 th&aacute;ng (phải c&ograve;n nguy&ecirc;n vẹn, kh&ocirc;ng chỉnh sửa).</li>\r\n	<li>H&agrave;nh l&yacute; qu&aacute; cước quy định (theo quy định l&agrave; 20kg (k&yacute; gửi) + 7kg (x&aacute;ch tay)/kh&aacute;ch).</li>\r\n	<li>Xe đưa đ&oacute;n s&acirc;n bay T&acirc;n Sơn Nhất v&agrave; c&aacute;c show diễn về đ&ecirc;m tại Th&aacute;i Lan.</li>\r\n	<li>C&aacute;c chi ph&iacute; c&aacute; nh&acirc;n (ph&iacute; điện thoại, giặt ủi, ăn uống ngo&agrave;i chương tr&igrave;nh, ph&iacute; khu&acirc;n v&aacute;c h&agrave;nh l&yacute;,&hellip;).</li>\r\n	<li>Tiền tip hướng dẫn vi&ecirc;n v&agrave; t&agrave;i xế địa phương:&nbsp;25 USD/ tour (Tỷ gi&aacute; theo thời điểm).</li>\r\n	<li>Ph&iacute; visa nhập cảnh Việt Nam (VK + NN) 1 th&aacute;ng 1 lần:&nbsp;65 USD/kh&aacute;ch (Tỷ gi&aacute; theo thời điểm).</li>\r\n	<li>Ph&ograve;ng đơn phụ thu (khi c&oacute; nhu cầu ở 1 kh&aacute;ch/ph&ograve;ng):&nbsp;90 USD/kh&aacute;ch (Tỷ gi&aacute; theo thời điểm).</li>\r\n	<li>Visa Th&aacute;i Lan (d&agrave;nh cho kh&aacute;ch TQ, HK v.v..):&nbsp;2.200 Baht/kh&aacute;ch (Tỷ gi&aacute; theo thời điểm).</li>\r\n	<li>Chi ph&iacute; ph&aacute;t sinh nếu chuyến bay bị huỷ trong trường hợp bất khả kh&aacute;ng: thi&ecirc;n tai, thời tiết, đ&igrave;nh c&ocirc;ng, dịch bệnh truyền nhiễm.</li>\r\n</ul>\r\n', '', '<ul>\r\n	<li>Hủy tour ngay sau khi đăng k&yacute;: mất 100% tiền cọc.</li>\r\n	<li>Hủy tour từ trước 30 ng&agrave;y : ph&iacute; phạt 50% tổng gi&aacute; trị đăng k&yacute; tour.&nbsp;</li>\r\n	<li>Hủy tour từ trước 20 ng&agrave;y &ndash; 30 ng&agrave;y : ph&iacute; phạt 80% tổng gi&aacute; trị đăng k&yacute; tour.&nbsp;</li>\r\n	<li>VIETNAM BOOKING kh&ocirc;ng giải quyết c&aacute;c trường hợp hủy tour 05 ng&agrave;y khởi h&agrave;nh, ph&iacute; phạt 100% gi&aacute; tour.</li>\r\n</ul>\r\n', 6900000.00, 9900000.00, '5 Ngày 4 Đêm', 'assets/images/1781924820_tour-thai-lan-5n4d-bangkok-pattaya-8.jpg', 'active', '2026-06-20 02:06:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `combo_bookings`
--

CREATE TABLE `combo_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `combo_id` int(11) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `travel_date` date NOT NULL,
  `total_people` int(11) DEFAULT 1,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_type` enum('full','deposit') DEFAULT 'full',
  `amount_paid` decimal(15,2) DEFAULT 0.00,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cccd` varchar(20) DEFAULT NULL,
  `representative_name` varchar(100) DEFAULT NULL,
  `payment_face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `combo_bookings`
--

INSERT INTO `combo_bookings` (`id`, `user_id`, `combo_id`, `booking_code`, `travel_date`, `total_people`, `status`, `total_price`, `payment_type`, `amount_paid`, `payment_status`, `created_at`, `cccd`, `representative_name`, `payment_face_image`) VALUES
(1, 5, 1, 'CBEECB3E', '2026-06-19', 3, 'confirmed', 99999999.99, 'deposit', 54000000.00, 'paid', '2026-06-18 02:36:30', NULL, NULL, NULL),
(2, 5, 1, 'CB54E696', '2026-06-21', 1, 'confirmed', 36000000.00, 'full', 36000000.00, 'paid', '2026-06-19 01:52:21', NULL, NULL, 'uploads/payments/pay_face_CB54E696_1781834002.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','resolved') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `phone`, `email`, `subject`, `message`, `status`, `created_at`, `admin_reply`, `user_id`) VALUES
(1, 'Admin System', '098765434', 'admin@thegioi.vn', 'Ve May Bay', 'tôi muốn 1 vé máy bay ko  mất tiền ', 'resolved', '2026-06-18 01:20:01', 'bạn muốn đi đâu', NULL),
(2, 'huy12', '09843454', 'huy1223@gmail.com', 'Tu Van Tour', 'tôi cần tư ván \r\n', 'resolved', '2026-06-18 01:27:03', 'ok', 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `slug`, `description`, `image_url`, `created_at`) VALUES
(1, 'Trong nước', 'trong-nuoc', 'Các tour du lịch trong nước Việt Nam', NULL, '2026-06-16 04:32:22'),
(2, 'Ngoài nước', 'ngoai-nuoc', 'Các tour du lịch quốc tế', NULL, '2026-06-16 04:32:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) NOT NULL,
  `airline` varchar(100) NOT NULL,
  `flight_number` varchar(50) NOT NULL,
  `departure_city` varchar(100) NOT NULL,
  `arrival_city` varchar(100) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `flights`
--

INSERT INTO `flights` (`id`, `airline`, `flight_number`, `departure_city`, `arrival_city`, `departure_time`, `arrival_time`, `price`, `thumbnail`, `created_at`) VALUES
(6, 'VietJetAir', 'Airbus A321 • Eco', 'Buôn ma thuột ', 'HÀ NỘI ', '2026-06-18 12:32:00', '2026-06-18 14:32:00', 4900000.00, 'uploads/flights/1781753638_VietJetAir.webp', '2026-06-18 03:33:58'),
(7, 'Vietnam Airlines', 'VN234', 'Hà Nội', 'Nha Trang', '2026-06-24 09:30:00', '2026-06-24 11:20:00', 2100000.00, 'uploads/flights/1781925858_tải xuống (4).png', '2026-06-20 03:15:06'),
(8, 'Vietjet Air', 'VJ789', 'Hải Phòng', 'TP. Hồ Chí Minh', '2026-06-22 13:00:00', '2026-06-22 15:10:00', 1500000.00, 'uploads/flights/1781925810_VietJetAir.webp', '2026-06-20 03:15:06'),
(9, 'Bamboo Airways', 'QH111', 'Đà Nẵng', 'Phú Quốc', '2026-06-26 10:45:00', '2026-06-26 12:30:00', 2800000.00, 'uploads/flights/1781925721_tải xuống (3).png', '2026-06-20 03:15:06'),
(10, 'Vietnam Airlines', 'VN555', 'Hà Nội', 'Đà Lạt', '2026-06-23 07:15:00', '2026-06-23 09:05:00', 2400000.00, 'uploads/flights/1781925795_tải xuống (4).png', '2026-06-20 03:15:06'),
(11, 'Vietravel Airlines', 'VU101', 'TP. Hồ Chí Minh', 'Quy Nhơn', '2026-06-25 14:00:00', '2026-06-25 15:15:00', 1100000.00, 'uploads/flights/1781925887_tải xuống (4).png', '2026-06-20 03:15:06'),
(12, 'Singapore Airlines', 'SQ175', 'Hà Nội', 'Singapore', '2026-06-27 12:35:00', '2026-06-27 17:15:00', 5500000.00, 'uploads/flights/1781925656_tải xuống (2).png', '2026-06-20 03:15:06'),
(13, 'All Nippon Airways (ANA)', 'NH832', 'TP. Hồ Chí Minh', 'Tokyo (Narita)', '2026-06-30 23:05:00', '2026-07-01 06:45:00', 12500000.00, 'uploads/flights/1781925493_tải xuống (1).png', '2026-06-20 03:15:06'),
(14, 'Emirates', 'EK393', 'TP. Hồ Chí Minh', 'Dubai', '2026-07-05 23:55:00', '2026-07-06 04:00:00', 18000000.00, 'uploads/flights/1781925455_tải xuống.png', '2026-06-20 03:15:06'),
(15, 'Air France', 'AF253', 'TP. Hồ Chí Minh', 'Paris (CDG)', '2026-07-10 08:35:00', '2026-07-10 16:30:00', 25000000.00, 'uploads/flights/1781925407_1605156711228.jpg', '2026-06-20 03:15:06'),
(16, 'Korean Air', 'KE462', 'Đà Nẵng', 'Seoul (Incheon)', '2026-06-28 22:50:00', '2026-06-29 05:20:00', 8500000.00, 'uploads/flights/1781925606_Korean_Air_2025_(vertical).svg', '2026-06-20 03:15:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flight_bookings`
--

CREATE TABLE `flight_bookings` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `flight_id` bigint(20) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `total_passengers` int(11) DEFAULT 1,
  `total_amount` decimal(15,2) NOT NULL,
  `passenger_details` text DEFAULT NULL,
  `payment_type` enum('full','deposit') DEFAULT 'full',
  `amount_paid` decimal(15,2) DEFAULT 0.00,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `booking_status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `check_in_status` enum('pending','checked_in') NOT NULL DEFAULT 'pending',
  `cccd` varchar(20) DEFAULT NULL,
  `representative_name` varchar(100) DEFAULT NULL,
  `payment_face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `flight_bookings`
--

INSERT INTO `flight_bookings` (`id`, `user_id`, `flight_id`, `booking_code`, `total_passengers`, `total_amount`, `passenger_details`, `payment_type`, `amount_paid`, `payment_status`, `booking_status`, `created_at`, `check_in_status`, `cccd`, `representative_name`, `payment_face_image`) VALUES
(20, 7, 6, 'FL607B35', 5, 24500000.00, '[\\\"nguyễn van a\\\",\\\"nguyen can a\\\",\\\"nguyen can ă\\\",\\\"nguyen can a\\\",\\\"nguyen can ă\\\"]', '', 12250000.00, 'paid', 'confirmed', '2026-06-18 03:35:02', 'pending', NULL, NULL, 'uploads/payments/pay_face_FL607B35_1781753728.jpg'),
(21, 5, 6, 'FL9DED63', 1, 4900000.00, '[\\\"nguyễn van a\\\"]', '', 2450000.00, 'paid', 'confirmed', '2026-06-18 03:36:41', 'pending', NULL, NULL, 'uploads/payments/pay_face_FL9DED63_1781753824.jpg'),
(22, 5, 8, 'FLA6BBE3', 1, 1500000.00, '[\\\"nguyễn van b \\\"]', '', 1500000.00, 'paid', 'pending', '2026-06-20 03:25:30', 'pending', NULL, NULL, 'uploads/payments/pay_face_FLA6BBE3_1781925974.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guides`
--

CREATE TABLE `guides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `guides`
--

INSERT INTO `guides` (`id`, `title`, `excerpt`, `content`, `image`, `created_at`) VALUES
(2, 'Cẩm nang du lịch Quy Nhơn', 'Thành phố biển của tỉnh Bình Định, thuộc khu vực duyên hải Nam Trung Bộ, cách Hà Nội 1.065 km, cách TP HCM 650 km. Quy Nhơn nép mình giữa một bên biển một bên núi với những bờ biển dài uốn cong thơ mộng, bờ cát vàng mịn và làn nước trong xanh đẹp mê hồn.', 'Quy Nhơn mùa nào đẹp\r\nMùa mưa chỉ kéo dài 2-3 tháng cuối năm, thời gian còn lại trong năm tiết trời khô ráo, đặc biệt khoảng thời gian tháng 3-9. Mùa hè từ tháng 5 đến 9 nắng nhưng không oi bức, khó chịu, không bị ảnh hưởng mưa bão nên thích hợp để du khách tham gia các hoạt động vui chơi, giải trí cả trên bờ lẫn dưới biển.\r\n\r\nDi chuyển\r\nHiện nay các hãng bay tại Việt Nam như Vietnam Airlines, Vietjet Air và Bamboo Airways đều khai thác tuyến Hà Nội và TP HCM đến Quy Nhơn, giá vé khứ hồi từ khoảng 1.500.000 - 4.000.000 đồng một người, tùy thời điểm.\r\n\r\n\r\nCung đường bộ đi tới Kỳ Co. Ảnh: Khánh Trần.\r\nTừ sân bay Phù Cát về trung tâm TP Quy Nhơn có xe buýt với giá 50.000 đồng một người, phù hợp khách đi lẻ, hoặc taxi giá 200.000 - 250.000 đồng một chuyến. Ngoài máy bay du khách vẫn có thể đi ôtô khách hoặc tàu hỏa từ các tỉnh lân cận.\r\n\r\nDi chuyển trong thành phố, du khách thuê xe máy 100.000 - 150.000 đồng một ngày hoặc thuê taxi, ôtô để tới những điểm xa hơn. Nếu chỉ đi lại trong các phố trung tâm nhưng nhóm đông 8-15 người có thể chọn xe điện với giá 25.000 đồng một km và 250.000 đồng cho 60 phút.\r\n\r\nKhách sạn, homestay\r\nDu khách đi theo nhóm bạn hoặc một mình muốn tìm chỗ ở với giá rẻ có thể chọn các homestay, hostel hoặc khách sạn 2-3 sao từ 150.000 - 400.000 đồng một đêm. Cần yên tĩnh và tiện nghi bạn hãy tìm các khách sạn đường Tây Sơn, An Dương Vương, Hàn Mặc Tử... Còn nếu muốn ở gần biển thì tìm tới các con đường như Nguyễn Huệ, Xuân Diệu quanh tượng đài Nguyễn Tất Thành hay ở Bãi Xép, Kỳ Co, Eo Gió...\r\n\r\n82818747-2565205560416758-2610-2652-8170\r\nresort-quynhon-7716-1593164111.jpg\r\nsalah-hotel-3343-1593059854.jpg\r\n89693132-147906940024370-82059-7593-2244\r\nhomestay-quy-nhon-4588-1592910738.jpg\r\nMột số địa chỉ được du khách yêu thích và có vị trí thuận tiện để di chuyển là: Life\'s a beach, Mira Bãi Xép, Quy Nhơn Balahouse, La beach house Nhơn Lý, khách sạn Salah, Seagate bungalow, Quê Hương, Sea view Quy Nhơn...\r\n\r\nĐể tận hưởng các dịch vụ sang trọng và nhiều tiện nghi hơn như bể bơi, bãi biển riêng, spa, gym hay phòng view biển, du khách hãy cân nhắc đến các khu nghỉ dưỡng như Crown Retreat, Avani Quy Nhơn, FLC Quy Nhơn, Casa Marina, Aurora... Mùa hè này, giá phòng tại resort, khách sạn 4- 5 sao từ 1.500.000 đến 5.000.000 đồng một đêm.\r\n\r\nĂn uống\r\nĐặc sản\r\n\r\nCó rất nhiều đặc sản mà du khách nào đặt chân tới đây cũng thưởng thức như bánh canh chả cá, bánh xèo tôm nhảy, bánh hỏi cháo lòng, nem nướng, nem cuốn, bánh mì lagu, bánh canh, bánh khọt tôm mực... Ngoài ra, ở Quy Nhơn những ngày hè du khách không thể bỏ qua các loại hải sản tươi ngon như ốc, sò, nghêu, hàu, tôm hùm, ghẹ, cá bóp, cua huỳnh đế...\r\n\r\n\r\nChỉ cần dạo một vòng thành phố biển du khách cũng tìm thấy rất nhiều quán ăn ngon, giá cả phải chăng:\r\n\r\nPhố ốc Ngọc Hân Công Chúa\r\nPhố ẩm thực Ngô Văn Sở\r\nBánh mì lagu, 132 Ngô Mây\r\nBánh khọt, 19 Hàn Thuyên\r\nBánh bèo bà Xê, đường Nguyễn Tất Thành nối dài\r\nBún cá bà Thu, 157 Nguyễn Huệ\r\nNem nướng cô Tuyết, Hải Thượng Lãn Ông\r\nQuán cơm gà Quê Hương, đường Lê Hồng Phong\r\nCơm Mậu, 179a Phan Bội Châu\r\nCơm Bếp Nhà 1989, 159 Phan Bội Châu\r\nQuán Thảo Nguyên - hải sản Bãi Xép\r\nNhà tàu hải sản Hoa Hoa, ngay cảng Quy Nhơn\r\nXem thêm: 4 khu phố hút khách về đêm ở Quy Nhơn\r\nQuán cà phê, trà sữa, bar\r\n\r\nLà thành phố du lịch mới phát triển độ 5-6 năm gần đây nên các quán cà phê, trà sữa, trà chanh chưa thực sự nở rộ, nhưng cũng có một số địa chỉ được cả du khách và dân địa phương yêu thích. Các địa chỉ cà phê giới trẻ lựa chọn là Adiuvat, Mango Tree, Kho book & cafe, Marina, Green cafe, Surf bar....\r\n\r\nĐồ uống được nhiều người đánh giá ngon và rẻ hơn nhiều thành phố du lịch khác. Chỉ từ 20.000 đến 50.000 đồng bạn đã được tận hưởng những tách cà phê thơm hay ly trà sữa, sinh tố ngon trong không gian thoáng đãng.\r\n\r\n\r\nChơi đâu\r\n\r\nDu khách ở Hòn Khô. Ảnh: thy.dang\r\nNhơn Hải - Hòn Khô\r\n\r\nTừ trung tâm thành phố, đi qua cầu Thị Nại, tới bán đảo Phương Mai rẽ phải là hướng tới làng chài Nhơn Hải. Hòn Khô và làng chài Nhơn Hải là điểm đến hấp dẫn nhờ vào cảnh đẹp hoang sơ và con người thật thà, chất phác. Từ làng chài du khách đón cano hoặc tàu ra Hòn Khô chỉ khoảng 10 phút với chi phí khứ hồi từ 100.000 đồng một người. Hòn Khô là điểm nên đi tour trong ngày hoặc một buổi. Trên Hòn Khô chưa có nhiều dịch vụ du lịch nhưng hiện có cây cầu gỗ xây ven đảo rất hút khách tới chụp hình. Tour Hòn Khô trong ngày có giá chỉ từ 220.000 đồng một người.\r\n\r\nKỳ Co - Eo Gió\r\n\r\nVới biển xanh cát trắng nắng vàng, Kỳ Co thuộc xã Nhơn Lý cách trung tâm 25 km được nhiều người ví như Maldives Việt Nam. Du khách có thể đi bằng cano từ Eo Gió hoặc đi đường bộ tới Kỳ Co rồi đón tour cano tới Eo Gió hoặc các bãi lặn ngắm san hô. Vé tham quan Kỳ Co là 100.000 đồng một người và vé xe trung chuyển chặng cuối 40.000 đồng một người. Ngoài các hoạt động tắm, lặn du khách có thể thuê chòi thư giãn bên bờ biển, chơi moto nước, dù kéo, cắm lều trại hoặc nghỉ tại khách sạn ngay trong khu du lịch. Bãi Kỳ Co một mặt giáp biển, ba mặt giáp núi đồi, sóng êm và nước xanh, lý tưởng cho một chuyến nghỉ hè ngắn ngày.\r\n\r\n\r\nDu khách tham quan những con đường đi bộ uốn lượn theo sườn núi ở Eo Gió giữa tháng 6/2020. Ảnh: Khánh Trần\r\nCách Kỳ Co không xa là Eo Gió, nơi có con đường đi bộ ôm theo sườn núi và view biển đẹp ngoạn mục. Vé tham quan Eo Gió 25.000 đồng một người, sau khi tham quan con đường bộ du khách dư thời gian nên ghé qua Tịnh xá Ngọc Hòa, Linh Phong Sơn Tự... Tour một ngày đi cano, lặn ngắm san hô, ăn trưa hải sản ở Kỳ Co - Eo Gió có giá từ 700.000 đồng một người.\r\n\r\nKhu du lịch Cửa Biển\r\n\r\nTừ trung tâm chỉ cần đi qua cầu Thị Nại rẽ phải ngay là tới khu du lịch. Đây là công viên giải trí có khuôn viên rộng cả trên bờ lẫn dưới nước với nhiều hoạt động ngoài trời hấp dẫn như zipline, leo núi nhân tạo, bắn cung, đạp xe, chèo kayak, công viên nước phao nổi... Với vé người lớn 300.000 đồng, trẻ em 200.000 đồng, du khách được chơi hết các trò không giới hạn thời gian. Hoặc với mỗi trò chơi du khách mua vé riêng 50.000 đồng một người. Khu du lịch còn xây dựng các góc \"sống ảo\", cắm lều, đốt lửa trại, làm tiệc nướng ngay sát bờ biển. Giờ mở cửa từ 7h 30 - 18h30 hàng ngày. Nếu du khách nghỉ qua đêm tại các bungalow của khu du lịch sẽ được tham gia các trò chơi mà không mất thêm phí.\r\n\r\nKhu dã ngoại Trung Lương\r\n\r\n\r\nKhu ngủ lều, cắm trại ở Trung Lương. Ảnh: Lan Anh.\r\nThuộc thôn Trung Lương, xã Cát Tiến, huyện Phù Cát, khu dã ngoại này là một trong những điểm đến yêu thích nhất của giới trẻ. Bên trong khu dã ngoại gồm nhiều khu vực như cắm trại, ngủ nhà lều, bãi tắm và chơi các trò dưới biển, nhà hàng, quán cà phê, cổng trời check-in... Được chăm chút trồng thêm cây cảnh và hoa kết hợp vị trí và phong cảnh đẹp vốn có của các núi đá, bãi biển xung quanh, khu dã ngoại rất hợp để du lịch theo nhóm bạn bè hoặc gia đình. Giờ mở cửa từ 8h - 20h hàng ngày. Vé vào cổng 40.000 đồng/ người, lưu ý khi vào du khách không đem theo đồ ăn thức uống bên ngoài. Giá thuê lều ngủ qua đêm khoảng 300.000 đồng hai người.\r\n\r\nTrung tâm khám phá khoa học (ExploraScience)\r\n\r\nCách thành phố 5 km về phía nam, trung tâm nằm ở số 10, Đại lộ Khoa học, phường Ghềnh Ráng. Từ 1/1/2023, vé vào cửa là 40.000 đồng một người với khu thiếu nhi. Vé tham gia hoạt động trải nghiệm về thiên văn học tại Trạm quan sát thiên văn phổ thông ban đêm (từ 18h đến 22h) là 150.000 đồng một người. Có một số trường hợp đặc biệt được giảm giá, du khách nên liên hệ trước với Trung tâm.\r\n\r\nExporaScience Quy Nhơn là tổ hợp không gian khoa học dành cho các đối tượng học sinh, sinh viên. Trung tâm có nhiều hoạt động và các phòng khám phá, vui chơi chủ đề vũ trụ, vật lý, hóa học... Hiện nơi đây đang mở cửa miễn phí cho khách tham quan nhưng cần liên hệ trước và tổ chức đi theo đoàn.\r\n\r\nDSCF7020-JPG-2341-1593164116.jpg\r\nẢnh: Khánh Trần\r\nDSCF7082-JPG-7129-1593164116.jpg\r\nẢnh: Khánh Trần\r\nDSCF7040-JPG-6152-1593164117.jpg\r\nẢnh: Khánh Trần\r\nDSCF7052-JPG-5019-1593164117.jpg\r\nẢnh: Khánh Trần\r\nDSCF7035-JPG-3652-1593164118.jpg\r\nẢnh: Khánh Trần\r\nGhềnh Ráng Tiên Sa\r\n\r\nCách trung tâm thành phố khoảng 3 km về phía đông nam, Ghềnh Ráng Tiên Sa là cụm điểm du lịch gồm quần thể bãi đá Ghềnh Ráng, bãi Tiên Sa, bãi tắm Hoàng Hậu, khu mộ Hàn Mặc Tử, nhà thờ Ghềnh Ráng. Từ đỉnh Ghềnh Ráng du khách có thể phóng tầm mắt nhìn ngắm thành phố Quy Nhơn và bãi biển Vầng Trăng Khuyết. Khu du lịch này hiện mở cửa tham quan miễn phí.\r\n\r\nCác tháp Chăm\r\n\r\n\r\nBình Định có nhiều di tích Chăm Pa, đặc biệt là các cụm tháp cổ có từ thế kỷ 13 - 14. Khi du lịch gần thành phố Quy Nhơn du khách nên ghé tháp Đôi, và tháp Bánh Ít. Nếu đi xa hơn du khách có thể tham quan thêm tháp Cánh Tiên, tháp Dương Long. Vé tham quan các tháp Chăm là 10.000 - 20.000 đồng một người.\r\n\r\nTiểu chủng viện Làng Sông\r\nNhà thờ Làng Sông, hay Tiểu chủng viện Làng Sông, nằm ở thôn Quảng Vân, xã Phước Thuận, huyện Tuy Phước. Du khách đi dọc theo Quốc lộ 19 mới sẽ tới điểm này nhanh hơn và kết hợp tuyến tham quan chùa võ Long Phước, chùa Thiên Hưng và tháp Bánh Ít.\r\n\r\nBao quanh nhà thờ và tu viện là cánh đồng lúa bát ngát trải rộng. Bước qua cổng là lối vào với hai hàng cây sao cổ thụ tỏa bóng xanh mát. Nếu liên hệ trước, du khách còn được vào tham quan bên trong nhà thờ, khu vực lưu giữ các bản ghi chép, tư liệu về nhà in đầu tiên in sách chữ Quốc ngữ. Nhà thờ mở cửa từ 7h - 11h30 và 14h - 17h30 hàng ngày.\r\n\r\n\r\nKhuôn viên xanh mát của Tiểu chủng viện Làng Sông. Ảnh: Khánh Trần.\r\nNhững ngôi chùa nổi tiếng\r\n\r\nChùa Long Phước là cái nôi của võ thuật cổ truyền Việt Nam, nằm ở thôn Tân Thuận, xã Phước Thuận, huyện Tuy Phước. Quanh chùa là những cánh đồng xanh mướt thơm mùi lúa mới, trong chùa là những vườn hoa, cây cảnh bonsai cùng nhiều kiến trúc cổ. Chùa là điểm hẹn của những người yêu võ, các câu lạc bộ võ thuật đến để luyện tập, thi đấu.\r\n\r\n\r\nTượng Phật ngồi ở chùa Ông Núi. Ảnh: Khánh Trần.\r\nChùa Ông Núi với bức tượng Phật ngồi lớn nhất Đông Nam Á là điểm du lịch mới. Chùa còn có tên Linh Phong Sơn Tự, tọa lạc trên đỉnh Chóp Vung, huyện Phù Cát, cách trung tâm gần 30 km. Du khách nên tới chùa vào sáng sớm hoặc chiều muộn để tránh nắng và có thể ngắm toàn cảnh bờ biển dưới chân núi. Ngoài tượng Phật ngồi khổng lồ, du khách nên vãn cảnh chùa cổ nơi có các kiến trúc cổng tam quan, bửu tháp, chánh điện được xây dựng và trang trí rất tinh xảo, đẹp mắt.\r\n\r\nChùa Thiên Hưng là một trong các chùa nổi tiếng nhất Bình Định, thuộc phường Nhơn Hưng, thị xã An Nhơn, cách trung tâm khoảng 20 km. Khuôn viên chùa có tháp chuông 12 tầng, các gian nhà mái ngói cong như cung đình xưa, hồ nước lớn và rất nhiều cây xanh. Bước vào sân chùa du khách sẽ cảm giác như lạc tới một phim trường cổ trang công phu.\r\n\r\nLàng chài Bãi Xép\r\n\r\n\r\nTừ trung tâm thành phố theo quốc lộ 1D khoảng 13 km, du khách đến với làng chài Bãi Xép nằm trong vùng biển Quy Hòa. Ở đây có đủ loại hình lưu trú từ bình dân như homestay, nhà nghỉ tới resort cao cấp. Bãi Xép có nhiều rặng đá tự nhiên nổi lên trên mặt nước, bờ cát vàng mịn màng thu hút nhiều bạn trẻ chụp hình. Tới Bãi Xép tham quan, du khách ngoài tận hưởng vẻ đẹp hoang sơ và không gian thanh bình còn được khám phá đời sống dân chài lưới.\r\n\r\nLàng chài Nhơn Lý\r\n\r\nAnh-10-Nhon-Ly-1684814395.jpg\r\n\r\nXã Nhơn Lý nằm ở bán đảo Phương Mai, cách trung tâm TP Quy Nhơn khoảng 20 km về phía đông bắc, bãi biển đẹp, hoang sơ với 10.000 người dân ở bốn thôn: Lý Hưng, Lý Lương, Lý Chánh, Lý Hòa. Người dân trong xã chủ yếu sống bằng những nghề liên quan đến biển như đánh bắt, chế biển hải sản. Đây là một xã bán đảo vẫn còn lưu giữ nhiều di tích của văn hóa Champa, lễ hội Cầu ngư được tổ chức hằng năm, nơi còn lưu giữ 6 sắc phong của các triều đại Vua. Từ đầu năm 2023, Nhơn Lý trở nên sống động hơn, thu hút nhiều người đến nhờ những bức bích họa nhiều màu sắc. Những bức tranh bích họa ở làng chài cổ Nhơn Lý mang nhiều chủ đề từ hoa lá, cây cỏ, chim chóc cho đến những hình ảnh gắn liền với cuộc sống của người dân làng biển như lưới cá, thuyền buồm, cá mập, cá heo, rùa biển.\r\n\r\nCách di chuyển: Từ thành phố Quy Nhơn, du khách qua cầu Thị Nại, tới bán đảo Phương Mai rồi tiếp tục đi theo quốc lộ 19B để tới xã đảo Nhơn Lý.\r\n\r\nCù Lao Xanh\r\n\r\nCòn gọi là đảo Vân Phi, Cù Lao Xanh nằm gần vịnh Xuân Đài, thuộc xã Nhơn Châu. Du khách có thể tham quan hải đăng và giếng Suối Tiên, tắm biển, xem rùa đẻ trứng, tối đến ngủ lều hoặc homestay trên đảo hay theo thuyền đi câu mực đêm với ngư dân... Để tới Cù Lao Xanh bạn đón xe tới cảng Hàm Tử, chọn tour đi bằng cano ra đảo, hoặc tự túc đi bằng thuyền gỗ. Nếu đi cano khứ hồi giá không kèm tour là 350.000 đồng, giá tour một ngày ở Cù Lao Xanh là 700.000 đồng một người.\r\n\r\n> Xem thêm: Cẩm nang du lịch Cù Lao Xanh\r\n\r\nCẩm nang du lịch Kỳ Co\r\n\r\nGợi ý lịch trình 4 ngày 3 đêm\r\n\r\nNgày 1: Sân bay Phù Cát - Tháp Đôi - Làng chài Nhơn Hải - Hòn Khô\r\n\r\nNgày 2: Tour Kỳ Co - Eo Gió - Phố ẩm thực - Chợ đêm\r\n\r\nNgày 3: Ghềnh Ráng Tiên Sa - Trung tâm Khám phá Khoa học - Làng chài Bãi Xép\r\n\r\nNgày 4: Khu du lịch Cửa Biển - Tiểu chủng viện Làng Sông - Tháp Bánh Ít - Sân bay Phù Cát\r\n\r\nHoặc\r\n\r\nNgày 1: Sân bay Phù Cát - Tháp Đôi - Ghềnh Ráng Tiên Sa - Làng chài Bãi Xép\r\n\r\nNgày 2: Cầu Thị Nại - Tour cano Eo Gió - Kỳ Co - Chợ đêm\r\n\r\nNgày 3: Bến Hàm Tử - Tour một ngày Cù Lao Xanh - Phố ẩm thực\r\n\r\nNgày 4: Chùa Ông Núi - Khu dã ngoại Trung Lương - sân bay Phù Cát', '6a334d4d2b636.webp', '2026-06-18 01:42:31'),
(3, 'Bí kíp du lịch Phú Quốc 3 Ngày 2 Đêm tự túc siêu tiết kiệm', 'Phú Quốc luôn là điểm đến hấp dẫn với biển xanh, cát trắng và nắng vàng. Bài viết này sẽ hướng dẫn bạn cách đi Phú Quốc với chi phí cực rẻ.', '<p>Phú Quốc không chỉ nổi tiếng với những bãi biển tuyệt đẹp như Bãi Sao, Bãi Khem mà còn thu hút du khách bởi ẩm thực phong phú và các khu vui chơi giải trí hàng đầu như VinWonders, Safari.</p>\n        <p><strong>1. Thời điểm lý tưởng:</strong> Thời tiết đẹp nhất để đi Phú Quốc là từ tháng 11 đến tháng 4 năm sau. Lúc này biển êm, ít mưa và có nắng đẹp.</p>\n        <p><strong>2. Di chuyển:</strong> Nếu bạn ở TP.HCM, vé máy bay khứ hồi thường dao động từ 1.000.000đ - 1.500.000đ. Đặt vé sớm 1 tháng để có giá tốt nhất.</p>\n        <p><strong>3. Chỗ ở:</strong> Để tiết kiệm, bạn có thể chọn các homestay ở khu vực trung tâm thị trấn Dương Đông với giá từ 300.000đ/đêm. Nếu thích nghỉ dưỡng, khu vực Bãi Trường có nhiều Resort cao cấp.</p>\n        <p><strong>4. Ăn uống:</strong> Đừng bỏ qua chợ đêm Phú Quốc với vô vàn món hải sản tươi sống: Nhum nướng mỡ hành, gỏi cá trích, mực trứng nướng...</p>', 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=800', '2026-06-20 04:18:34'),
(4, 'Lịch trình khám phá Đà Lạt 4 mùa hoa nở rực rỡ', 'Đà Lạt mùa nào cũng đẹp, mỗi mùa mang một vẻ đẹp riêng. Cùng khám phá Đà Lạt qua lăng kính 4 mùa trong năm nhé.', '<p>Đà Lạt được mệnh danh là thành phố ngàn hoa, nơi bạn có thể cảm nhận được vẻ đẹp lãng mạn và bình yên đến lạ kỳ.</p>\n        <p><strong>Mùa Xuân (Tháng 1 - 3):</strong> Mùa rực rỡ nhất với sắc hồng của hoa Mai Anh Đào nở rộ khắp các con phố. Đây cũng là lúc thời tiết ấm áp, ít mưa nhất.</p>\n        <p><strong>Mùa Hạ (Tháng 4 - 6):</strong> Mùa của hoa Phượng Tím lãng mạn. Buổi sáng trời trong vắt, ban đêm se se lạnh, rất thích hợp để dạo bước Hồ Xuân Hương.</p>\n        <p><strong>Mùa Thu (Tháng 7 - 9):</strong> Mùa của những cơn mưa rào bất chợt. Tuy nhiên, nếu bạn thích nhâm nhi ly cà phê nóng và ngắm mưa, đây là thời điểm không thể tuyệt vời hơn.</p>\n        <p><strong>Mùa Đông (Tháng 10 - 12):</strong> Sương mù giăng lối khắp các triền đồi. Mùa hoa Dã Quỳ vàng rực nhuộm kín các con đường ngoại ô như đèo D\'ran, Trại Mát.</p>', 'https://images.unsplash.com/photo-1599708153386-62bf0cbcfdc1?auto=format&fit=crop&q=80&w=800', '2026-06-20 04:18:34'),
(5, 'Kinh nghiệm xin Visa Châu Âu (Schengen) bao đậu 99%', 'Xin Visa Schengen luôn là nỗi e ngại của nhiều người. Tuy nhiên, với sự chuẩn bị kỹ lưỡng, bạn hoàn toàn có thể cầm trên tay chiếc vé thông hành quyền lực này.', '<p>Khối Schengen bao gồm 27 quốc gia Châu Âu. Xin được Visa Schengen, bạn có thể tự do di chuyển giữa các quốc gia này mà không cần xin thêm visa.</p>\n        <p><strong>1. Hồ sơ cá nhân:</strong> Cần chuẩn bị đầy đủ Hộ chiếu còn hạn, Căn cước công dân, Sổ hộ khẩu, Giấy đăng ký kết hôn (nếu có).</p>\n        <p><strong>2. Hồ sơ công việc:</strong> Hợp đồng lao động, Giấy xin nghỉ phép, Bảng lương 3 tháng gần nhất. Nếu là chủ doanh nghiệp cần Giấy phép kinh doanh và Biên lai nộp thuế.</p>\n        <p><strong>3. Hồ sơ tài chính:</strong> Sổ tiết kiệm tối thiểu 100-200 triệu đồng, Sao kê tài khoản ngân hàng, Giấy tờ nhà đất (nếu có).</p>\n        <p><strong>4. Mẹo:</strong> Nên xin visa ở Lãnh sự quán Pháp hoặc Hà Lan vì thủ tục nhanh và tỷ lệ đậu thường cao hơn các nước khác. THEGIOI Travel có cung cấp dịch vụ hỗ trợ làm Visa bao đậu với chi phí cực hợp lý.</p>', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&q=80&w=800', '2026-06-20 04:18:34'),
(6, 'Cẩm nang du lịch Thái Lan 2026: Ăn gì, chơi đâu?', 'Bangkok - Pattaya luôn là hành trình \"quốc dân\" với du khách Việt. Cùng THEGIOI Travel khám phá những điểm đến mới toanh tại Xứ sở Chùa Vàng.', '<p>Thái Lan không ngừng đổi mới để thu hút khách du lịch. Ngoài những điểm tham quan quen thuộc, năm 2026 Thái Lan có rất nhiều khu vui chơi và trải nghiệm mới.</p>\n        <p><strong>Ăn uống:</strong> Ẩm thực Thái Lan chưa bao giờ làm du khách thất vọng. Từ Pad Thai, Tom Yum Gung, Som Tum đến món xôi xoài ngọt lịm. Đừng quên ghé khu phố Tàu Chinatown (Yaowarat) vào ban đêm để thưởng thức các món ăn đường phố đỉnh cao.</p>\n        <p><strong>Mua sắm:</strong> Central World, Siam Paragon cho đồ hiệu; Platinum, Chatuchak (chợ cuối tuần) cho quần áo giá sỉ. Hãy chuẩn bị một chiếc vali trống và mang một đôi giày thể thao thật êm vì bạn sẽ phải đi bộ rất nhiều!</p>\n        <p><strong>Di chuyển:</strong> Hãy thử trải nghiệm xe Tuk-tuk - \"đặc sản\" của giao thông Thái Lan. Tuy nhiên, tàu điện trên cao (BTS) và dưới ngầm (MRT) mới là phương tiện di chuyển nhanh chóng và tiện lợi nhất để tránh kẹt xe ở Bangkok.</p>', 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&q=80&w=800', '2026-06-20 04:18:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guide_images`
--

CREATE TABLE `guide_images` (
  `id` int(11) NOT NULL,
  `guide_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `guide_images`
--

INSERT INTO `guide_images` (`id`, `guide_id`, `image`, `created_at`) VALUES
(1, 2, '6a334dac4112d_0.jpg', '2026-06-18 01:45:16'),
(2, 2, '6a334dac41d9b_1.jpg', '2026-06-18 01:45:16'),
(3, 2, '6a334dac42660_2.jpg', '2026-06-18 01:45:16'),
(4, 2, '6a334dac43c5c_3.webp', '2026-06-18 01:45:16'),
(5, 2, '6a334dac4450d_4.jpg', '2026-06-18 01:45:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `star_rating` int(11) DEFAULT 3,
  `price_per_night` decimal(15,2) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `city`, `address`, `star_rating`, `price_per_night`, `thumbnail`, `description`, `created_at`) VALUES
(5, 'Khu nghỉ dưỡng Melia Vinpearl Phú Quốc', ' Phú Quốc', ' Khu Bãi Dài, xã Gành Dầu, huyện Phú Quốc, Kiên Giang', 5, 3240000.00, 'https://cdn1.ivivu.com/images/2025/02/12/16/Zmk8ePU9XHxjjzqBr2DU_d6sewo_.webp', '<h2>Combo 3N2Đ V&eacute; m&aacute;y bay + Bữa s&aacute;ng + Miễn ph&iacute; 02 trẻ dưới 12 tuổi</h2>\r\n\r\n<p>Combo &quot;Nghỉ Dưỡng Biệt Thự&quot;</p>\r\n\r\n<p>- V&eacute; m&aacute;y bay khứ hồi</p>\r\n\r\n<p>- 02 đ&ecirc;m nghỉ dưỡng ở Villa 3 Bedroom Garden View bể bơi ri&ecirc;ng&nbsp;</p>\r\n\r\n<p>- Buffet s&aacute;ng đặc sắc theo ti&ecirc;u chuẩn quốc tế tại nh&agrave; h&agrave;ng</p>\r\n\r\n<p>- Miễn phụ thu bữa s&aacute;ng cho 02 trẻ em dưới 12 tuổi</p>\r\n\r\n<p><strong>&hearts; Lưu tr&uacute; c&agrave;ng l&acirc;u - Qu&agrave; tặng c&agrave;ng nhiều,&nbsp;</strong>&aacute;p dụng số kh&aacute;ch ti&ecirc;u chuẩn</p>\r\n\r\n<p>Lưu tr&uacute; 2 đ&ecirc;m: Tặng 01 v&eacute; Safari (Người Lớn/Trẻ em ph&aacute;t sinh bắt buộc phụ thu th&ecirc;m 720,000đ/Kỳ nghỉ)</p>\r\n\r\n<p>Lưu tr&uacute; 3 đ&ecirc;m: Tặng 01 v&eacute; VinWonders (Người Lớn/Trẻ em ph&aacute;t sinh bắt buộc phụ thu th&ecirc;m 800,000đ/Kỳ nghỉ)</p>\r\n\r\n<p>Lưu tr&uacute; 4 đ&ecirc;m: Tặng 01 v&eacute; Safari + 01 v&eacute; VinWonders (Người Lớn/Trẻ em ph&aacute;t sinh bắt buộc phụ thu th&ecirc;m 1,520,000đ/Kỳ nghỉ)</p>\r\n\r\n<p>💑&nbsp;<strong>Khoảnh Khắc Đ&aacute;ng Nhớ:&nbsp;</strong>D&agrave;nh thời gian trọn vẹn b&ecirc;n người th&acirc;n y&ecirc;u tại biệt thự c&oacute; bể bơi ri&ecirc;ng v&agrave; khu&ocirc;n vi&ecirc;n nghỉ dưỡng được &ocirc;m ấp bởi hồ nước lượn quanh</p>\r\n\r\n<p>- Tiện &iacute;ch đa dạng:</p>\r\n\r\n<ul>\r\n	<li>B&atilde;i biển d&agrave;i c&aacute;t trắng v&agrave; bể bơi v&ocirc; cực trước mặt biển</li>\r\n	<li>Xe Shuttle Bus đưa đ&oacute;n s&acirc;n bay theo lịch tr&igrave;nh kh&aacute;ch h&agrave;ng</li>\r\n	<li>Xe theo lịch tr&igrave;nh đi VinWonders, Vinpearl Safari, Grand World</li>\r\n	<li>Khu vui chơi trẻ em v&ocirc; v&agrave;n hoạt động c&ugrave;ng người tr&ocirc;ng trẻ</li>\r\n	<li>Wifi tốc độ cao, ph&ograve;ng gym hiện đại</li>\r\n	<li>Thức uống ch&agrave;o mừng khi nhận ph&ograve;ng</li>\r\n</ul>\r\n\r\n<p>Điều kiện &aacute;p dụng</p>\r\n\r\n<p>- Đặt tối thiểu 06 kh&aacute;ch/Villa 3 Bedroom</p>\r\n\r\n<p>- D&agrave;nh cho kh&aacute;ch Việt Nam</p>\r\n\r\n<p>- Phụ thu Thứ 5-6-7, một số ng&agrave;y Cao điểm</p>\r\n', '2026-06-19 01:43:57'),
(6, 'The Plaza Hotel', 'New York', '768 5th Ave, New York, NY 10019, Hoa Kỳ', 5, 15000000.00, 'https://images.unsplash.com/photo-1541971875076-8f970d573be6?q=80&w=2000&auto=format&fit=crop', 'Khách sạn mang tính biểu tượng ở trung tâm Manhattan, kế bên Công viên Trung tâm.', '2026-06-20 02:01:30'),
(7, 'Waldorf Astoria Beverly Hills', 'Los Angeles', '9850 Wilshire Blvd, Beverly Hills, CA 90210, Hoa Kỳ', 5, 18000000.00, 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2000&auto=format&fit=crop', 'Nghỉ dưỡng xa hoa tại Beverly Hills với dịch vụ đẳng cấp thế giới.', '2026-06-20 02:01:30'),
(8, 'Shangri-La Hotel, Paris', 'Paris', '10 Av. d\'Iéna, 75116 Paris, Pháp', 5, 25000000.00, 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=2000&auto=format&fit=crop', 'Khách sạn cổ điển mang kiến trúc Pháp với tầm nhìn bao quát tháp Eiffel.', '2026-06-20 02:01:30'),
(9, 'The Ritz London', 'London', '150 Piccadilly, St. James\'s, London W1J 9BR, Vương quốc Anh', 5, 22000000.00, 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=2000&auto=format&fit=crop', 'Sự sang trọng bậc nhất mang đậm phong cách hoàng gia Anh.', '2026-06-20 02:01:30'),
(10, 'Aman Tokyo', 'Tokyo', 'The Otemachi Tower, 1-5-6 Otemachi, Chiyoda City, Tokyo 100-0004, Nhật Bản', 5, 28000000.00, 'https://media.privateupgrades.com/_data/default-hotel_image/11/55914/aman-tokyo-10_1400x1400_auto.jpg', '<p>Ốc đảo y&ecirc;n b&igrave;nh giữa l&ograve;ng thủ đ&ocirc; sầm uất với thiết kế tối giản truyền thống Nhật.</p>\r\n', '2026-06-20 02:01:30'),
(11, 'The Ritz-Carlton, Kyoto', 'Kyoto', 'Kamogawa Nijo-Ohashi Hotori, Nakagyo Ward, Kyoto, 604-0902, Nhật Bản', 5, 30000000.00, 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=2000&auto=format&fit=crop', 'Trải nghiệm đỉnh cao của lòng hiếu khách Nhật Bản bên bờ sông Kamo.', '2026-06-20 02:01:30'),
(12, 'Khu nghỉ dưỡng Melia Vinpearl Phú Quốc', 'Phú Quốc', 'Bãi Dài, Gành Dầu, Phú Quốc, Kiên Giang', 5, 3240000.00, 'https://pix8.agoda.net/hotelImages/1985199/0/4582dea53a252674fa623a2724bc4975.jpg?va=1&ce=2&s=1024x', '<p>Tận hưởng kỳ nghỉ dưỡng trọn vẹn với c&aacute;c biệt thự c&oacute; hồ bơi ri&ecirc;ng.</p>\r\n', '2026-06-20 02:01:30'),
(13, 'Amiana Resort Nha Trang', 'Nha Trang', 'Phạm Văn Đồng, Vĩnh Hải, Nha Trang', 5, 2500000.00, 'https://lh3.googleusercontent.com/gps-cs-s/APNQkAHt4e9Nwp7M2OeifvIyDpO5s8mgRpL0IP7jkJdz6ApJU3NVEhSJQrmt0k8odw6Nd690zhPiLkvCZdEgJrFlmikalrss3FYXJVI38mTNEnUi_3lgt3Y0_0A3Oq9gLCAo6F8ILGxHHg=s1360-w1360-h1020-rw', '<p>Khu nghỉ dưỡng với b&atilde;i biển ri&ecirc;ng trong vắt v&agrave; tắm b&ugrave;n độc đ&aacute;o.</p>\r\n', '2026-06-20 02:01:30'),
(14, 'InterContinental Danang Sun Peninsula Resort', 'Đà Nẵng', 'Bãi Bắc, Bán Đảo Sơn Trà, Đà Nẵng, Việt Nam', 5, 12500000.00, 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&q=80&w=800', 'Khu nghỉ dưỡng sang trọng bậc nhất trên bán đảo Sơn Trà, với thiết kế độc đáo của kiến trúc sư Bill Bensley. Các biệt thự ẩn mình giữa rừng nguyên sinh với tầm nhìn tuyệt đẹp ra Vịnh Bãi Bắc.', '2026-06-20 03:13:29'),
(15, 'Six Senses Ninh Van Bay', 'Nha Trang', 'Vịnh Ninh Vân, Ninh Hòa, Khánh Hòa, Việt Nam', 5, 18000000.00, 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&q=80&w=800', 'Khu nghỉ dưỡng sinh thái cao cấp với những căn villa bằng gỗ nằm chênh vênh trên những tảng đá khổng lồ. Tách biệt hoàn toàn với thế giới bên ngoài, mang lại trải nghiệm bình yên tuyệt đối.', '2026-06-20 03:13:29'),
(16, 'Hotel de la Coupole - MGallery', 'Sapa', 'Số 1 Phạm Xuân Huân, Sapa, Lào Cai, Việt Nam', 5, 3500000.00, 'https://images.unsplash.com/photo-1551882547-ff40c0d5852a?auto=format&fit=crop&q=80&w=800', 'Kiệt tác kiến trúc Đông Dương lộng lẫy giữa sương mù Sapa. Nổi bật với màu vàng mù tạt, những vòm cong và thiết kế lấy cảm hứng từ thời trang cao cấp của Pháp và bản sắc Tây Bắc.', '2026-06-20 03:13:29'),
(17, 'Four Seasons Resort The Nam Hai', 'Hội An', 'Khối Hà My, Điện Dương, Điện Bàn, Quảng Nam, Việt Nam', 5, 20000000.00, 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&q=80&w=800', 'Ốc đảo thanh bình bên bờ biển Hà My thơ mộng. Khu nghỉ dưỡng sang trọng bậc nhất thế giới mang đậm triết lý phong thủy và sự cân bằng âm dương.', '2026-06-20 03:13:29'),
(18, 'Amanoi Resort', 'Ninh Thuận', 'Thôn Vĩnh Hy, Vĩnh Hải, Ninh Hải, Ninh Thuận, Việt Nam', 5, 25000000.00, 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800', 'Resort 6 sao đầu tiên tại Việt Nam, nằm giữa Vườn quốc gia Núi Chúa và vịnh Vĩnh Hy. Mang đến sự riêng tư tuyệt đối, spa trị liệu chuyên sâu và phong cảnh thiên nhiên hoang sơ.', '2026-06-20 03:13:29'),
(19, 'Marina Bay Sands', 'Singapore', '10 Bayfront Avenue, Singapore', 5, 15000000.00, 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&q=80&w=800', 'Biểu tượng của Singapore với thiết kế con tàu khổng lồ vắt ngang qua 3 tòa tháp. Nổi tiếng với hồ bơi vô cực cao nhất thế giới và khu trung tâm mua sắm, sòng bạc sầm uất.', '2026-06-20 03:13:29'),
(20, 'The Ritz-Carlton', 'Kyoto', 'Kamogawa Nijo-Ohashi Hotori, Nakagyo Ward, Kyoto, Nhật Bản', 5, 28000000.00, 'https://images.unsplash.com/photo-1518733057094-95b53143d2a7?auto=format&fit=crop&q=80&w=800', 'Nép mình bên dòng sông Kamogawa thanh bình, khách sạn mang đậm kiến trúc Ryokan truyền thống Nhật Bản pha lẫn sự tinh tế sang trọng của thương hiệu Ritz-Carlton.', '2026-06-20 03:13:29'),
(21, 'Four Seasons Hotel George V', 'Paris', '31 Avenue George V, 75008 Paris, Pháp', 5, 45000000.00, 'https://images.unsplash.com/photo-1596436889106-be35e843f6a6?auto=format&fit=crop&q=80&w=800', 'Khách sạn huyền thoại nằm gần đại lộ Champs-Elysées. Từng phòng đều được trang trí bằng nghệ thuật cổ điển Pháp và nơi đây sở hữu các nhà hàng Michelin danh giá.', '2026-06-20 03:13:29'),
(22, 'Burj Al Arab Jumeirah', 'Dubai', 'Jumeirah St, Dubai, Các Tiểu vương quốc Ả Rập Thống nhất', 5, 40000000.00, 'https://images.unsplash.com/photo-1580637250482-132d0f5080b0?auto=format&fit=crop&q=80&w=800', 'Khách sạn hình cánh buồm nổi bật trên nền trời Dubai, thường được mệnh danh là khách sạn 7 sao duy nhất trên thế giới với sự xa hoa vượt qua mọi chuẩn mực.', '2026-06-20 03:13:29'),
(23, 'The Plaza', 'New York', '768 5th Ave, New York, NY 10019, Hoa Kỳ', 5, 20000000.00, 'https://images.unsplash.com/photo-1541971875076-8f970d573be6?auto=format&fit=crop&q=80&w=800', 'Tọa lạc ngay góc Công viên Trung tâm (Central Park), The Plaza là biểu tượng lịch sử của New York, xuất hiện trong vô số bộ phim nổi tiếng và mang phong cách lâu đài kiểu Pháp xa hoa.', '2026-06-20 03:13:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotel_bookings`
--

CREATE TABLE `hotel_bookings` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `hotel_id` bigint(20) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_guests` int(11) DEFAULT 1,
  `total_nights` int(11) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_phone` varchar(50) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `booking_status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cccd_image` varchar(255) DEFAULT NULL,
  `face_image` varchar(255) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT 'full',
  `amount_paid` decimal(15,2) DEFAULT 0.00,
  `cccd` varchar(20) DEFAULT NULL,
  `representative_name` varchar(100) DEFAULT NULL,
  `payment_face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hotel_bookings`
--

INSERT INTO `hotel_bookings` (`id`, `user_id`, `hotel_id`, `booking_code`, `check_in_date`, `check_out_date`, `total_guests`, `total_nights`, `total_amount`, `guest_name`, `guest_phone`, `special_requests`, `payment_status`, `booking_status`, `created_at`, `cccd_image`, `face_image`, `payment_type`, `amount_paid`, `cccd`, `representative_name`, `payment_face_image`) VALUES
(16, 7, 5, 'HTFBE930', '2026-06-19', '2026-06-25', 7, 6, 19440000.00, 'huy12', '098765432', '', 'paid', 'completed', '2026-06-19 01:47:59', 'assets/uploads/verifications/cccd_7_1781833679.jpg', 'assets/uploads/verifications/face_7_1781833679.jpg', 'full', 19440000.00, '098765432', 'nguyễn van á', NULL),
(17, 5, 5, 'HT65995B', '2026-06-20', '2026-07-04', 7, 14, 45360000.00, 'Admin System', '09876543', '', 'paid', 'completed', '2026-06-20 03:27:34', 'assets/uploads/verifications/cccd_5_1781926054.jpg', 'assets/uploads/verifications/face_5_1781926054.jpg', 'full', 45360000.00, '98765432345', 'nguyễn van á', NULL),
(18, 7, 14, 'HTF19852', '2026-06-29', '2026-07-11', 2, 12, 150000000.00, 'huy12', '09876543', '', 'paid', 'pending', '2026-06-28 09:16:15', NULL, NULL, 'deposit', 75000000.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `itineraries`
--

CREATE TABLE `itineraries` (
  `id` bigint(20) NOT NULL,
  `tour_id` bigint(20) NOT NULL,
  `day_number` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `itineraries`
--

INSERT INTO `itineraries` (`id`, `tour_id`, `day_number`, `title`, `description`) VALUES
(1, 2, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.'),
(2, 2, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.'),
(3, 2, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.'),
(4, 2, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.'),
(5, 3, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.'),
(6, 3, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.'),
(7, 3, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.'),
(8, 3, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.'),
(9, 4, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.'),
(10, 4, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.'),
(11, 4, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.'),
(12, 4, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.'),
(13, 5, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.'),
(14, 5, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.'),
(15, 5, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.'),
(16, 5, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.'),
(17, 6, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.'),
(18, 6, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.'),
(19, 6, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.'),
(20, 6, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logout_reviews`
--

CREATE TABLE `logout_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `logout_reviews`
--

INSERT INTO `logout_reviews` (`id`, `user_id`, `rating`, `created_at`) VALUES
(1, 2, 3, '2026-06-08 02:03:47'),
(2, 4, 4, '2026-06-08 02:07:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `payment_method` enum('vnpay','momo','zalopay','cash') DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_method`, `transaction_id`, `amount`, `payment_status`, `paid_at`) VALUES
(1, 13, '', 'TXN1708683181', 375000000.00, '', NULL),
(2, 13, '', 'TXN1703792252', 375000000.00, '', NULL),
(3, 12, '', 'TXN1709182843', 120000000.00, '', NULL),
(4, 13, '', 'TXN1706059844', 375000000.00, '', NULL),
(5, 8, '', 'TXN1708455925', 200000000.00, '', NULL),
(6, 13, '', 'TXN1701808416', 375000000.00, '', NULL),
(7, 12, '', 'TXN1708558007', 120000000.00, '', NULL),
(8, 13, '', 'TXN1708802248', 375000000.00, '', NULL),
(9, 13, '', 'TXN1708877429', 375000000.00, '', NULL),
(10, 12, '', 'TXN17061242610', 120000000.00, '', NULL),
(11, 9, '', 'TXN17048559311', 40000000.00, '', NULL),
(12, 8, '', 'TXN17045200812', 200000000.00, '', NULL),
(13, 10, '', 'TXN17042029113', 200000000.00, '', NULL),
(14, 8, '', 'TXN17075493914', 200000000.00, '', NULL),
(15, 10, '', 'TXN17071716515', 200000000.00, '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `discount_type`, `discount_value`, `start_date`, `end_date`, `usage_limit`, `used_count`, `status`, `created_at`) VALUES
(1, 'HELLO2026', 'amount', 50000.00, '2026-06-01', '2026-12-31', 100, 0, 'active', '2026-06-21 03:47:43'),
(2, 'SUMMER10', 'percent', 10.00, '2026-06-01', '2026-08-31', 500, 0, 'active', '2026-06-21 03:47:43'),
(3, 'DISCOUNT50K', 'amount', 50000.00, '2026-01-01', '2026-12-31', 1000, 0, 'active', '2026-06-21 03:47:43'),
(4, 'HOTDEAL20', 'percent', 20.00, '2026-06-20', '2026-06-30', 50, 0, 'active', '2026-06-21 03:47:43'),
(5, 'VIPONLY', 'amount', 200000.00, '2026-06-01', '2026-12-31', 20, 0, 'active', '2026-06-21 03:47:43'),
(6, 'WEEKEND5', 'percent', 5.00, '2026-06-01', '2026-12-31', 1000, 0, 'active', '2026-06-21 03:47:43'),
(7, 'FAMILY200K', 'amount', 200000.00, '2026-06-01', '2026-12-31', 200, 0, 'active', '2026-06-21 03:47:43'),
(8, 'FLASH15', 'percent', 15.00, '2026-06-21', '2026-06-23', 100, 0, 'active', '2026-06-21 03:47:43'),
(9, 'FIRSTBOOK', 'amount', 100000.00, '2026-01-01', '2026-12-31', 9999, 0, 'active', '2026-06-21 03:47:43'),
(10, 'MEGA30', 'percent', 30.00, '2026-11-01', '2026-11-30', 30, 0, 'active', '2026-06-21 03:47:43'),
(11, 'JACKPOT50', 'percent', 50.00, '2026-06-01', '2026-12-31', 10, 0, 'active', '2026-06-21 03:58:58'),
(12, 'JACKPOT100', 'percent', 100.00, '2026-06-01', '2026-12-31', 5, 0, 'active', '2026-06-21 03:58:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `tour_id` bigint(20) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `tour_id`, `rating`, `comment`, `created_at`) VALUES
(4, 5, 2, 4, 'ok', '2026-06-18 03:02:25'),
(5, 6, 14, 5, 'Tour rất tuyệt vời, hướng dẫn viên nhiệt tình, chu đáo. Lịch trình hợp lý, đồ ăn ngon và phong cảnh thì quá đẹp. Chắc chắn sẽ quay lại!', '2026-06-21 03:36:59'),
(6, 6, 2, 4, 'Nhìn chung chuyến đi khá tốt. Khách sạn sạch sẽ, thoải mái. Tuy nhiên ngày thứ 2 lịch trình hơi dày đặc nên đi bộ hơi mệt.', '2026-05-24 07:10:21'),
(7, 1, 5, 5, 'Trải nghiệm trên cả mong đợi! Gia đình mình đã có những kỷ niệm thật đẹp. Cảm ơn công ty du lịch đã tổ chức rất chuyên nghiệp.', '2026-06-14 23:59:11'),
(8, 6, 14, 5, 'Giá cả vô cùng hợp lý so với chất lượng nhận được. Đồ ăn đặc sản địa phương rất ngon. Xe di chuyển êm ái, bác tài vui tính.', '2026-06-04 19:54:38'),
(9, 1, 2, 3, 'Cảnh đẹp nhưng thời tiết lúc mình đi không được thuận lợi lắm nên chưa trải nghiệm được hết. Hướng dẫn viên thân thiện nhưng cần cải thiện thêm về thời gian tập trung.', '2026-06-21 12:09:51'),
(10, 5, 6, 4, 'Mọi thứ đều ok, gia đình mình ai cũng thích. Chỗ ở gần trung tâm rất tiện đi lại buổi tối.', '2026-06-12 06:35:01'),
(11, 5, 5, 5, 'Tuyệt vời ông mặt trời! Đáng đồng tiền bát gạo, vote 5 sao cho chất lượng dịch vụ của công ty nha.', '2026-06-04 08:21:28'),
(12, 8, 13, 5, 'Trải nghiệm rất tốt! Chuyến đi đáng nhớ cùng gia đình. Hướng dẫn viên rất vui vẻ.', '2026-06-18 09:00:27'),
(13, 9, 2, 4, 'Dịch vụ phòng khách sạn ổn, xe đưa đón đúng giờ. Hơi mệt vì lịch trình đi bộ nhiều.', '2026-06-17 09:58:10'),
(14, 10, 2, 5, 'Mọi thứ hoàn hảo! Rất đáng tiền, mình sẽ giới thiệu cho bạn bè tham gia tour này.', '2026-06-17 16:23:48'),
(15, 11, 15, 4, 'Khá hài lòng với chất lượng phục vụ của công ty. Đồ ăn các bữa chính rất hợp khẩu vị.', '2026-06-21 11:09:07'),
(16, 12, 3, 5, 'Chuyến đi tuyệt vời nhất từ trước tới nay. Cảnh đẹp tuyệt trần, dịch vụ chăm sóc khách hàng 10 điểm.', '2026-06-20 19:54:51'),
(17, 8, 2, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-18 08:26:44'),
(18, 10, 2, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-10 01:48:29'),
(19, 6, 2, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-23 02:30:49'),
(20, 10, 2, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-05-21 15:27:03'),
(21, 11, 2, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-27 00:59:41'),
(22, 9, 3, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-17 22:45:46'),
(23, 6, 3, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-04-27 17:25:53'),
(24, 10, 3, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-26 20:12:29'),
(25, 5, 3, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-05-23 16:31:24'),
(26, 12, 3, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-16 18:04:22'),
(27, 1, 4, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-06-20 13:33:36'),
(28, 7, 4, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-06-19 03:25:47'),
(29, 6, 4, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-06-06 07:18:15'),
(30, 12, 4, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-04-24 10:26:45'),
(31, 5, 4, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-04-24 00:39:51'),
(32, 5, 5, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-31 00:57:46'),
(33, 6, 5, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-06-05 22:56:54'),
(34, 5, 5, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-03 18:55:49'),
(35, 7, 5, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-06-06 11:14:54'),
(36, 12, 5, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-05 22:10:03'),
(37, 10, 6, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-07 13:04:07'),
(38, 6, 6, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-10 19:41:00'),
(39, 10, 6, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-18 22:17:05'),
(40, 9, 6, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-04-28 04:16:46'),
(41, 10, 6, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-04-30 16:34:06'),
(42, 9, 7, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-04-28 01:16:10'),
(43, 5, 7, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-10 02:34:17'),
(44, 9, 7, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-05 11:55:00'),
(45, 1, 7, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-06-06 05:42:39'),
(46, 12, 7, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-01 16:20:59'),
(47, 10, 13, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-15 22:32:57'),
(48, 1, 13, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-01 22:28:20'),
(49, 1, 13, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-25 18:18:00'),
(50, 9, 13, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-26 22:02:26'),
(51, 8, 13, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-09 17:37:15'),
(52, 9, 14, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-06-17 11:23:27'),
(53, 12, 14, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-06-20 16:01:40'),
(54, 6, 14, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-06 05:46:14'),
(55, 9, 14, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-01 16:11:48'),
(56, 10, 14, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-06-05 08:44:25'),
(57, 6, 15, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-21 05:47:13'),
(58, 7, 15, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-06-03 11:55:24'),
(59, 12, 15, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-29 18:40:59'),
(60, 11, 15, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-16 01:12:17'),
(61, 9, 15, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-06-03 04:22:27'),
(62, 10, 16, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-20 01:33:49'),
(63, 9, 16, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-30 01:55:29'),
(64, 11, 16, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-06-09 23:53:10'),
(65, 12, 16, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-09 04:34:17'),
(66, 8, 16, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-06-21 13:43:25'),
(67, 10, 17, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-20 23:38:37'),
(68, 9, 17, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-05-25 09:39:53'),
(69, 5, 17, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-11 03:24:42'),
(70, 12, 17, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-05-25 19:07:58'),
(71, 1, 17, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-26 17:35:41'),
(72, 11, 18, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-10 23:13:20'),
(73, 12, 18, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-01 20:40:07'),
(74, 12, 18, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-04 17:46:55'),
(75, 7, 18, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-25 05:19:52'),
(76, 6, 18, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-26 22:39:05'),
(77, 10, 8, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-06-01 02:08:50'),
(78, 11, 8, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-06-09 10:38:33'),
(79, 10, 8, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-06-06 18:49:29'),
(80, 9, 8, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-06-08 00:22:57'),
(81, 8, 8, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-27 06:10:33'),
(82, 12, 9, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-04-25 20:46:11'),
(83, 12, 9, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-04-27 14:14:10'),
(84, 5, 9, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-06-18 00:33:21'),
(85, 5, 9, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-04-27 18:22:29'),
(86, 10, 9, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-06-11 07:15:42'),
(87, 8, 10, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-04-23 19:46:14'),
(88, 1, 10, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-06-14 22:08:44'),
(89, 9, 10, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-09 22:14:51'),
(90, 7, 10, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-04-29 02:37:34'),
(91, 12, 10, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-06-06 06:07:18'),
(92, 1, 11, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-05-14 21:37:58'),
(93, 12, 11, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-09 09:54:00'),
(94, 11, 11, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-25 14:57:34'),
(95, 12, 11, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-06-07 04:33:37'),
(96, 5, 11, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-05 13:45:30'),
(97, 1, 12, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-28 12:25:54'),
(98, 1, 12, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-30 20:00:02'),
(99, 10, 12, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-05-30 07:37:49'),
(100, 11, 12, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-06-01 12:23:52'),
(101, 5, 12, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-06-01 12:10:42'),
(102, 8, 19, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-19 19:45:18'),
(103, 12, 19, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-04-25 12:56:43'),
(104, 5, 19, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-06-13 00:57:43'),
(105, 9, 19, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-16 21:29:39'),
(106, 1, 19, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-04 04:14:17'),
(107, 5, 20, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-05 20:09:40'),
(108, 9, 20, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-06-14 11:37:07'),
(109, 10, 20, 5, 'Không thể chê vào đâu được, lịch trình linh hoạt, phong cảnh đẹp không góc chết.', '2026-06-16 06:13:28'),
(110, 8, 20, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-04-25 03:27:49'),
(111, 6, 20, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-05-02 07:17:39'),
(112, 7, 21, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-06-06 06:16:07'),
(113, 11, 21, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-05-17 05:47:56'),
(114, 12, 21, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-16 12:22:48'),
(115, 1, 21, 5, 'Mọi người nhất định phải thử tour này nhé, cực kỳ xứng đáng.', '2026-05-15 23:31:38'),
(116, 11, 21, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-06-18 01:53:36'),
(117, 8, 22, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-04-28 18:53:42'),
(118, 6, 22, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-06-08 08:04:26'),
(119, 10, 22, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-05-01 05:58:27'),
(120, 7, 22, 5, 'Mọi thứ đều hoàn hảo, từ đồ ăn đến chỗ ở và lịch trình. Chắc chắn sẽ quay lại.', '2026-06-01 04:11:04'),
(121, 11, 22, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-05-24 01:14:23'),
(122, 6, 23, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-19 18:22:00'),
(123, 7, 23, 5, 'Hướng dẫn viên siêu nhiệt tình, cảnh đẹp mê hồn. Rất đáng tiền.', '2026-05-01 21:25:49'),
(124, 10, 23, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-06-18 18:36:56'),
(125, 8, 23, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-21 08:26:21'),
(126, 11, 23, 5, 'Chuyến đi ngoài sức tưởng tượng, vui vẻ và thú vị vô cùng.', '2026-06-13 16:04:49'),
(127, 5, 24, 5, 'Tour rất tuyệt vời, tôi cực kỳ hài lòng với dịch vụ.', '2026-05-11 10:00:14'),
(128, 5, 24, 5, 'Rất ấn tượng với sự chuyên nghiệp của công ty. Điểm 10 cho chất lượng.', '2026-06-07 13:25:03'),
(129, 5, 24, 5, 'Tôi chưa từng đi tour nào tốt như vậy. Rất cảm ơn đội ngũ hướng dẫn.', '2026-05-06 10:32:53'),
(130, 1, 24, 5, 'Gia đình tôi đã có một kỳ nghỉ thật trọn vẹn nhờ tour này. Tuyệt vời!', '2026-05-07 17:05:59'),
(131, 7, 24, 5, 'Trải nghiệm trên cả tuyệt vời, 10 điểm không có nhưng!', '2026-05-26 18:41:33'),
(132, 6, 12, 3, 'trỉa nghiệm quá tuyệt vời', '2026-06-24 03:34:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `service_id` int(11) NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `service_date` date NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `payment_type` enum('full','deposit') DEFAULT 'full',
  `amount_paid` decimal(15,2) DEFAULT 0.00,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cccd` varchar(20) DEFAULT NULL,
  `representative_name` varchar(100) DEFAULT NULL,
  `payment_face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_bookings`
--

INSERT INTO `service_bookings` (`id`, `user_id`, `service_id`, `booking_code`, `service_date`, `quantity`, `total_price`, `payment_type`, `amount_paid`, `payment_status`, `status`, `created_at`, `cccd`, `representative_name`, `payment_face_image`) VALUES
(2, 5, 5, 'SV586845', '2026-06-20', 1, 50000000.00, 'full', 50000000.00, 'paid', 'completed', '2026-06-18 02:29:09', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_reviews`
--

CREATE TABLE `service_reviews` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_reviews`
--

INSERT INTO `service_reviews` (`id`, `user_id`, `service_id`, `rating`, `comment`, `created_at`) VALUES
(1, 12, 5, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-07 08:30:12'),
(2, 5, 5, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-09 22:19:11'),
(3, 10, 5, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-05-23 21:52:29'),
(4, 12, 5, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-04 18:49:12'),
(5, 7, 5, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-05-26 10:49:50'),
(6, 9, 6, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-05 20:20:32'),
(7, 1, 6, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-05 13:52:13'),
(8, 11, 6, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-10 15:08:10'),
(9, 9, 6, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-07 20:03:02'),
(10, 8, 6, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-05-23 21:33:57'),
(11, 1, 7, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-03 06:53:17'),
(12, 11, 7, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-05-27 02:48:02'),
(13, 5, 7, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-08 19:42:22'),
(14, 11, 7, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-19 06:14:52'),
(15, 12, 7, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-06-10 05:55:01'),
(16, 9, 8, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-16 13:38:04'),
(17, 1, 8, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-05-31 18:51:28'),
(18, 7, 8, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-14 03:39:04'),
(19, 12, 8, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-11 17:51:43'),
(20, 11, 8, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-06-01 16:44:57'),
(21, 7, 9, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-19 10:25:58'),
(22, 9, 9, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-05-23 15:46:08'),
(23, 12, 9, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-09 10:29:38'),
(24, 6, 9, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-05-31 17:12:45'),
(25, 12, 9, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-07 06:01:23'),
(26, 5, 10, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-15 18:27:24'),
(27, 1, 10, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-01 18:30:39'),
(28, 1, 10, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-05-31 10:51:28'),
(29, 12, 10, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-11 17:21:10'),
(30, 7, 10, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-01 12:24:41'),
(31, 7, 11, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-13 02:05:17'),
(32, 9, 11, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-05-26 22:24:52'),
(33, 7, 11, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-12 23:11:41'),
(34, 6, 11, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-06-08 07:43:08'),
(35, 8, 11, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-03 08:45:32'),
(36, 1, 12, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-14 23:36:09'),
(37, 10, 12, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-05-25 23:53:47'),
(38, 11, 12, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-01 21:33:00'),
(39, 10, 12, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-02 18:12:14'),
(40, 10, 12, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-02 14:59:47'),
(41, 8, 13, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-05-26 05:11:36'),
(42, 6, 13, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-05-30 17:11:11'),
(43, 6, 13, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-05-26 16:31:49'),
(44, 7, 13, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-01 18:07:12'),
(45, 5, 13, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-06-12 01:52:54'),
(46, 9, 14, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-02 02:22:10'),
(47, 10, 14, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-06-13 11:36:44'),
(48, 12, 14, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-05-27 21:27:18'),
(49, 1, 14, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-05-27 22:28:59'),
(50, 10, 14, 5, 'Trải nghiệm dịch vụ tuyệt vời, 10 điểm cho chất lượng!', '2026-06-10 17:30:46'),
(51, 5, 15, 5, 'Tiện lợi và nhanh chóng. Cực kỳ hài lòng với chất lượng.', '2026-05-29 13:47:01'),
(52, 6, 15, 5, 'Rất đáng tiền, tôi sẽ giới thiệu cho người thân.', '2026-06-14 10:09:28'),
(53, 6, 15, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-05-23 12:59:33'),
(54, 5, 15, 5, 'Dịch vụ rất tốt, nhân viên thân thiện và hỗ trợ nhiệt tình.', '2026-06-11 21:26:30'),
(55, 7, 15, 5, 'Tôi đã sử dụng nhiều lần và lúc nào cũng ưng ý.', '2026-06-20 07:48:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` bigint(20) NOT NULL,
  `destination_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `duration_nights` int(11) DEFAULT NULL,
  `departure_location` varchar(255) DEFAULT NULL,
  `transport_type` varchar(100) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `discount_price` decimal(15,2) DEFAULT NULL,
  `thumbnail` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `destination_id`, `title`, `slug`, `description`, `duration_days`, `duration_nights`, `departure_location`, `transport_type`, `price`, `discount_price`, `thumbnail`, `status`, `created_at`, `updated_at`, `is_featured`) VALUES
(2, 1, 'Phú Quốc - Bãi Sao - Hòn Thơm - Khám phá Grand World', 'ph-qu-c---b-i-sao---h-n-th-m---kh-m-ph-grand-world', '<p><em><strong>Điểm tham quan H&ograve;n Thơm, Grand word, .... Ẩm thực Theo thực đơn Thời gian l&yacute; tưởng Quanh năm Phương tiện M&aacute;y bay, Xe du lịch Khuyến m&atilde;i Ưu đ&atilde;i trực tiếp v&agrave;o gi&aacute; tour Ng&agrave;y 1: Đ&agrave; Nẵng - Ph&uacute; Quốc - &quot;Th&agrave;nh phố kh&ocirc;ng ngủ&quot; Grand World Ăn chiều Ng&agrave;y 2: Ph&uacute; Quốc - H&ograve;n Thơm - Trải nghiệm c&aacute;p treo vượt biển Ăn s&aacute;ng, trưa, chiều Ng&agrave;y 3: Ph&uacute; Quốc - Đ&agrave; Nẵng Ăn s&aacute;ng, trưa</strong></em></p>\r\n', 5, 4, NULL, NULL, 40000000.00, NULL, 'assets/images/1781751071_tfd__2_10311_sun-world-hon-thom-1-resize.webp', 'active', '2026-06-18 02:51:11', '2026-06-18 03:25:24', 1),
(3, 1, 'Tour Khám Phá Hà Giang Hùng Vĩ - Cao Nguyên Đá Đồng Văn', 'tour-kh-m-ph-h-giang-h-ng-v---cao-nguy-n-ng-v-n', '<p>Kh&aacute;m ph&aacute; vẻ đẹp hoang sơ của cao nguy&ecirc;n đ&aacute; Đồng Văn, chinh phục đ&egrave;o M&atilde; P&iacute; L&egrave;ng h&ugrave;ng vĩ, trải nghiệm đi thuyền tr&ecirc;n d&ograve;ng s&ocirc;ng Nho Quế xanh biếc v&agrave; t&igrave;m hiểu bản sắc văn h&oacute;a độc đ&aacute;o của c&aacute;c d&acirc;n tộc v&ugrave;ng cao ph&iacute;a Bắc.</p>\r\n', 4, 3, NULL, NULL, 2800000.00, NULL, 'assets/images/1782018739_tải xuống (12).jpg', 'active', '2026-06-20 03:35:14', '2026-06-21 05:12:19', 1),
(4, 1, 'Tour Nghỉ Dưỡng Vinpearl Phú Quốc Khởi Hành Từ TP.HCM', 'nghi-duong-vinpearl-phu-quoc-1781926514', 'Tận hưởng kỳ nghỉ dưỡng xa hoa tại tổ hợp Vinpearl Phú Quốc. Vui chơi thỏa thích tại VinWonders, khám phá công viên chăm sóc bảo tồn động vật bán hoang dã lớn nhất Việt Nam Vinpearl Safari và tắm biển xanh cát trắng.', 3, 2, NULL, NULL, 5500000.00, NULL, 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(5, 1, 'Tour Khám Phá Đảo Ngọc Lý Sơn - Vương Quốc Tỏi', 'tour-kh-m-ph-o-ng-c-l-s-n---v-ng-qu-c-t-i', '<p>Check-in cổng T&ograve; V&ograve; l&uacute;c ho&agrave;ng h&ocirc;n, chinh phục đỉnh Thới Lới bao la, tắm biển trong vắt tại Đảo B&eacute; v&agrave; thưởng thức hải sản tươi ngon c&ugrave;ng đặc sản tỏi đen trứ danh của v&ugrave;ng biển Quảng Ng&atilde;i.</p>\r\n', 3, 2, NULL, NULL, 3200000.00, NULL, 'assets/images/1782018556_tải xuống (17).jpg', 'active', '2026-06-20 03:35:14', '2026-06-21 05:09:16', 1),
(6, 1, 'Tour Hành Hương Miền Tây - Về Miền Sông Nước', 'tour-h-nh-h-ng-mi-n-t-y---v-mi-n-s-ng-n-c', '<p>Tham quan Chợ nổi C&aacute;i Răng sầm uất l&uacute;c b&igrave;nh minh, dạo bước qua c&aacute;c vườn c&acirc;y ăn tr&aacute;i trĩu quả, nghe Đờn ca t&agrave;i tử Nam Bộ v&agrave; thưởng thức c&aacute;c m&oacute;n ăn d&acirc;n d&atilde; đậm chất miền T&acirc;y Nam Bộ.</p>\r\n', 2, 1, NULL, NULL, 1900000.00, NULL, 'assets/images/1782018597_tải xuống (20).jpg', 'active', '2026-06-20 03:35:14', '2026-06-21 05:09:57', 1),
(7, 1, 'Tour Khám Phá Hang Sơn Đoòng (Tour Thám Hiểm Chuyên Nghiệp)', 'tour-kh-m-ph-hang-s-n-o-ng-tour-th-m-hi-m-chuy-n-nghi-p-', '<p>Chuyến th&aacute;m hiểm hang động lớn nhất thế giới. Đi bộ xuy&ecirc;n rừng nhiệt đới, lội suối, cắm trại b&ecirc;n trong hang động khổng lồ. Y&ecirc;u cầu thể lực tốt. Đội ngũ chuy&ecirc;n gia an to&agrave;n quốc tế sẽ đồng h&agrave;nh c&ugrave;ng bạn.</p>\r\n', 6, 5, NULL, NULL, 69000000.00, NULL, 'assets/images/1782018622_tải xuống (25).jpg', 'active', '2026-06-20 03:35:14', '2026-06-21 05:10:22', 1),
(8, 2, 'Tour Mùa Thu Nhật Bản - Cung Đường Vàng Tokyo - Kyoto - Osaka', 'mua-thu-nhat-ban-cung-duong-vang-1781926514', 'Chiêm ngưỡng sắc đỏ rực rỡ của mùa lá phong Nhật Bản. Viếng thăm đền Asakusa Kannon, ngắm nhìn núi Phú Sĩ hùng vĩ, trải nghiệm tắm suối nước nóng Onsen truyền thống và thỏa sức mua sắm tại Akihabara.', 6, 5, NULL, NULL, 28900000.00, NULL, 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(9, 2, 'Tour Hàn Quốc Lãng Mạn - Đảo Nami - Công Viên Everland', 'han-quoc-lang-man-dao-nami-1781926514', 'Bước vào không gian lãng mạn của bộ phim Bản Tình Ca Mùa Đông tại đảo Nami. Khám phá cung điện Gyeongbokgung cổ kính, mặc trang phục Hanbok truyền thống và vui chơi tại công viên giải trí Everland lớn nhất Hàn Quốc.', 5, 4, NULL, NULL, 15500000.00, NULL, 'https://images.unsplash.com/photo-1538681105587-85640961bf8b?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(10, 2, 'Tour Châu Âu Tráng Lệ: Pháp - Thụy Sĩ - Ý - Vatican', 'chau-au-trang-le-phap-thuy-si-y-1781926514', 'Hành trình mơ ước đi qua 4 quốc gia đẹp nhất Châu Âu. Thăm tháp Eiffel lộng lẫy, ngắm núi tuyết Titlis huyền thoại, đi thuyền Gondola lãng mạn ở Venice và chiêm ngưỡng đấu trường La Mã Colosseum.', 11, 10, NULL, NULL, 59000000.00, NULL, 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(11, 2, 'Tour Bali Huyền Bí - Thiên Đường Nghỉ Dưỡng', 'bali-huyen-bi-thien-duong-1781926514', 'Đến với Hòn đảo của các vị thần. Check-in tại Cổng Trời Lempuyang nổi tiếng, tham quan đền suối thiêng Tirta Empul, xích đu Bali Swing giữa rừng nhiệt đới và ngắm hoàng hôn rực rỡ tại đền Tanah Lot.', 4, 3, NULL, NULL, 11500000.00, NULL, 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(12, 2, 'Tour Thái Lan Siêu Khuyến Mãi: Bangkok - Pattaya', 'thai-lan-sieu-khuyen-mai-bangkok-pattaya-1781926514', 'Khám phá xứ sở Chùa Vàng sôi động. Tham quan Chùa Thuyền Wat Yannawa linh thiêng, xem show biểu diễn nghệ thuật đặc sắc của người chuyển giới Alcazar Show, dạo thuyền trên sông Chao Phraya và ăn trưa Buffet tại tòa nhà 86 tầng.', 5, 4, NULL, NULL, 6900000.00, NULL, 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:35:14', '2026-06-20 03:55:20', 1),
(13, 1, 'Tour Săn Mây Tà Xùa - Mộc Châu', 'tour-s-n-m-y-t-x-a---m-c-ch-u', '<p>Trải nghiệm săn m&acirc;y tr&ecirc;n đỉnh T&agrave; X&ugrave;a h&ugrave;ng vĩ, check-in sống lưng khủng long, v&agrave; kh&aacute;m ph&aacute; những đồi ch&egrave; xanh mướt trải d&agrave;i v&ocirc; tận tại cao nguy&ecirc;n Mộc Ch&acirc;u.</p>\r\n', 2, 1, NULL, NULL, 1850000.00, NULL, 'assets/images/1782014779_at_tour-moc-chau--ta-xua-2-ngay-khoi-hanh-thu-7-tu-ha-noi_79c744f36fe169962defb125cfccf503.jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 04:06:19', 1),
(14, 1, 'Tour Vịnh Hạ Long - Du Thuyền 5 Sao', 'vinh-ha-long-du-thuyen-5-sao-1781926785', 'Nghỉ dưỡng trên du thuyền 5 sao sang trọng giữa Di sản thiên nhiên thế giới. Thưởng thức tiệc nướng BBQ trên boong tàu, chèo kayak qua các hang động và tham gia lớp học nấu ăn.', 2, 1, NULL, NULL, 3500000.00, NULL, 'https://images.unsplash.com/photo-1506501139174-099022df5260?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:39:45', '2026-06-20 03:55:20', 1),
(15, 1, 'Tour Đà Lạt Mộng Mơ - Săn Hoa Dã Quỳ', 'tour-l-t-m-ng-m---s-n-hoa-d-qu-', '<p>Ch&igrave;m đắm trong kh&ocirc;ng kh&iacute; se lạnh của Đ&agrave; Lạt. Tham quan thung lũng t&igrave;nh y&ecirc;u, check-in những con đường ngập tr&agrave;n hoa d&atilde; quỳ v&agrave;ng rực v&agrave; thưởng thức ẩm thực chợ đ&ecirc;m.</p>\r\n', 3, 2, NULL, NULL, 2200000.00, NULL, 'assets/images/1782018324_images (1).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:05:24', 1),
(16, 1, 'Tour Khám Phá Quy Nhơn - Phú Yên (Hoa Vàng Trên Cỏ Xanh)', 'tour-kh-m-ph-quy-nh-n---ph-y-n-hoa-v-ng-tr-n-c-xanh-', '<p>H&agrave;nh tr&igrave;nh biển đảo tuyệt đẹp. Chi&ecirc;m ngưỡng Eo Gi&oacute; h&ugrave;ng vĩ, lặn ngắm san h&ocirc; tại Kỳ Co, check-in B&atilde;i X&eacute;p hoang sơ v&agrave; chinh phục G&agrave;nh Đ&aacute; Đĩa kỳ th&uacute;.</p>\r\n', 4, 3, NULL, NULL, 3800000.00, NULL, 'assets/images/1782018412_tải xuống (2).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:06:52', 1),
(17, 1, 'Tour Côn Đảo Tâm Linh & Nghỉ Dưỡng', 'tour-c-n-o-t-m-linh-ngh-d-ng', '<p>Viếng nghĩa trang H&agrave;ng Dương thi&ecirc;ng li&ecirc;ng, tham quan di t&iacute;ch nh&agrave; t&ugrave; C&ocirc;n Đảo v&agrave; thư gi&atilde;n tr&ecirc;n những b&atilde;i biển hoang sơ, trong vắt đẹp nhất h&agrave;nh tinh.</p>\r\n', 3, 2, NULL, NULL, 6500000.00, NULL, 'assets/images/1782018390_tải xuống (5).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:06:30', 1),
(18, 1, 'Tour Sapa Kính Luân - Fansipan Legend', 'tour-sapa-k-nh-lu-n---fansipan-legend', '<p>Chinh phục n&oacute;c nh&agrave; Đ&ocirc;ng Dương bằng c&aacute;p treo ngoạn mục. Dạo bước qua Bản C&aacute;t C&aacute;t của người H&rsquo;M&ocirc;ng, thưởng thức c&aacute; hồi Sapa v&agrave; chi&ecirc;m ngưỡng ruộng bậc thang tuyệt đẹp.</p>\r\n', 3, 2, NULL, NULL, 2800000.00, NULL, 'assets/images/1782018433_tải xuống (10).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:07:13', 1),
(19, 2, 'Tour Khám Phá Úc Châu: Sydney - Melbourne', 'tour-kh-m-ph-c-ch-u-sydney---melbourne', '<p>Check-in Nh&agrave; h&aacute;t Con S&ograve; biểu tượng, dạo bước tr&ecirc;n cầu cảng Sydney, ngắm cảnh đẹp tr&ecirc;n cung đường ven biển Great Ocean Road v&agrave; xem cuộc diễu h&agrave;nh của chim c&aacute;nh cụt.</p>\r\n', 7, 6, NULL, NULL, 45000000.00, NULL, 'assets/images/1782018466_tải xuống (13).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:07:46', 1),
(20, 2, 'Tour Mỹ Bờ Tây: Los Angeles - Las Vegas - San Francisco', 'my-bo-tay-los-angeles-las-vegas-1781926785', 'Trải nghiệm nhịp sống sôi động tại Hollywood, thử vận may ở sòng bạc Las Vegas xa hoa, chiêm ngưỡng Grand Canyon kỳ vĩ và dạo bước qua cầu Cổng Vàng sương mù.', 9, 8, NULL, NULL, 75000000.00, NULL, 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:39:45', '2026-06-20 03:55:20', 1),
(21, 2, 'Tour Dubai - Abu Dhabi Siêu Sang', 'dubai-abu-dhabi-sieu-sang-1781926785', 'Tham quan tòa tháp cao nhất thế giới Burj Khalifa, đua xe Jeep trên sa mạc rực lửa, cưỡi lạc đà và chiêm ngưỡng Thánh đường Hồi giáo Sheikh Zayed dát vàng ngọc.', 5, 4, NULL, NULL, 25900000.00, NULL, 'https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:39:45', '2026-06-20 03:55:20', 1),
(22, 2, 'Tour Đài Loan: Đài Bắc - Đài Trung - Cao Hùng', 'tour-i-loan-i-b-c---i-trung---cao-h-ng', '<p>Thả đ&egrave;n trời ước nguyện tại Thập Phần, dạo phố cổ Cửu Phần, đi thuyền tr&ecirc;n Hồ Nhật Nguyệt thơ mộng v&agrave; thưởng thức ẩm thực đường phố tại chợ đ&ecirc;m Sĩ L&acirc;m.</p>\r\n', 5, 4, NULL, NULL, 12500000.00, NULL, 'assets/images/1782018493_tải xuống (15).jpg', 'active', '2026-06-20 03:39:45', '2026-06-21 05:08:13', 1),
(23, 2, 'Tour Khám Phá Trung Hoa: Bắc Kinh - Thượng Hải - Hàng Châu', 'kham-pha-trung-hoa-bac-kinh-1781926785', 'Chinh phục Vạn Lý Trường Thành hùng vĩ, tham quan Tử Cấm Thành uy nghi, dạo thuyền ngoạn cảnh Tây Hồ và ngắm nhìn sự sầm uất của Bến Thượng Hải về đêm.', 6, 5, NULL, NULL, 18900000.00, NULL, 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:39:45', '2026-06-20 03:55:20', 1),
(24, 2, 'Tour Maldives - Thiên Đường Biển Đảo Tình Yêu', 'maldives-thien-duong-bien-dao-1781926785', 'Kỳ nghỉ lãng mạn tại các Water Villa tuyệt đẹp. Lặn ngắm san hô cùng rùa biển, thưởng thức hải sản trên bãi cát trắng mịn và ngắm bầu trời sao kỳ diệu về đêm.', 5, 4, NULL, NULL, 39000000.00, NULL, 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&q=80&w=800', 'active', '2026-06-20 03:39:45', '2026-06-20 03:55:20', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_images`
--

CREATE TABLE `tour_images` (
  `id` bigint(20) NOT NULL,
  `tour_id` bigint(20) NOT NULL,
  `image_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_images`
--

INSERT INTO `tour_images` (`id`, `tour_id`, `image_url`) VALUES
(1, 2, 'assets/images/gallery/1781751103_5261_tfd__1_10311_grand-world-10.webp'),
(2, 2, 'assets/images/gallery/1781751103_9047_tfd__2_3276_blue-mountains1.webp'),
(3, 2, 'assets/images/gallery/1781751103_8783_tfd__2_10311_khah9026.webp'),
(4, 2, 'assets/images/gallery/1781751103_6398_tfd__2_10311_sun-world-hon-thom-1-resize.webp'),
(5, 13, 'assets/images/gallery/1782017357_5041_du-lich-ta-xua-san-may.webp'),
(6, 13, 'assets/images/gallery/1782017406_1079_oasis-1-jpg.webp'),
(7, 13, 'assets/images/gallery/1782017406_8516_tải xuống (1).jpg'),
(8, 14, 'assets/images/gallery/1782017512_9426_du-thuyen-5-sao-ha-long-06.jpg'),
(9, 14, 'assets/images/gallery/1782017512_5208_images.jpg'),
(10, 15, 'assets/images/gallery/1782017582_7910_images (1).jpg'),
(11, 15, 'assets/images/gallery/1782017582_3758_tải xuống (1).jpg'),
(12, 15, 'assets/images/gallery/1782017582_2438_tải xuống.jpg'),
(13, 16, 'assets/images/gallery/1782017666_1565_tải xuống (2).jpg'),
(14, 16, 'assets/images/gallery/1782017666_4405_tải xuống (3).jpg'),
(15, 16, 'assets/images/gallery/1782017666_3447_tải xuống (4).jpg'),
(17, 17, 'assets/images/gallery/1782017750_9754_tải xuống (5).jpg'),
(18, 17, 'assets/images/gallery/1782017750_8633_tải xuống (6).jpg'),
(19, 17, 'assets/images/gallery/1782017750_6118_tải xuống (7).jpg'),
(20, 18, 'assets/images/gallery/1782017821_8755_tải xuống (8).jpg'),
(21, 18, 'assets/images/gallery/1782017821_9972_tải xuống (9).jpg'),
(22, 18, 'assets/images/gallery/1782017821_8838_tải xuống (10).jpg'),
(23, 22, 'assets/images/gallery/1782017921_1173_tải xuống (13).jpg'),
(24, 22, 'assets/images/gallery/1782017921_9535_tải xuống (14).jpg'),
(25, 22, 'assets/images/gallery/1782017921_5978_tải xuống (15).jpg'),
(26, 5, 'assets/images/gallery/1782017995_7195_tải xuống (16).jpg'),
(27, 5, 'assets/images/gallery/1782017995_3473_tải xuống (17).jpg'),
(28, 3, 'assets/images/gallery/1782018052_6489_tải xuống (18).jpg'),
(29, 3, 'assets/images/gallery/1782018052_3294_tải xuống (19).jpg'),
(30, 6, 'assets/images/gallery/1782018139_8655_tải xuống (20).jpg'),
(31, 6, 'assets/images/gallery/1782018139_3306_tải xuống (21).jpg'),
(32, 6, 'assets/images/gallery/1782018139_8303_tải xuống (22).jpg'),
(33, 7, 'assets/images/gallery/1782018205_2854_tải xuống (23).jpg'),
(34, 7, 'assets/images/gallery/1782018205_9605_tải xuống (24).jpg'),
(35, 7, 'assets/images/gallery/1782018205_5535_tải xuống (25).jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedules`
--

CREATE TABLE `tour_schedules` (
  `id` bigint(20) NOT NULL,
  `tour_id` bigint(20) NOT NULL,
  `departure_date` date DEFAULT NULL,
  `available_slots` int(11) DEFAULT NULL,
  `booked_slots` int(11) DEFAULT 0,
  `status` enum('open','full','closed') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `face_descriptor` text DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `face_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `phone`, `avatar`, `role`, `status`, `created_at`, `updated_at`, `face_descriptor`, `reset_token`, `reset_expires`, `face_image`) VALUES
(1, 'nguyên huy', 'huynt5454@gmail.com', '$2y$10$uCDX8ezh7HNaMKvkPyR1bea7VwPFfdLAO9Vz.8fAX6WTG/V7g9kQ2', '5432', NULL, 'user', 'active', '2026-06-08 01:35:48', '2026-06-08 01:35:48', NULL, NULL, NULL, NULL),
(5, 'Admin System', 'admin@thegioi.vn', '$2y$10$NNe7XkKQ6XqWlB.CQLCHtus3uSsogtKyooKVhdZlkfk8X32PiudNq', NULL, NULL, 'admin', 'active', '2026-06-16 04:57:38', '2026-07-01 22:46:47', '[-0.08905531466007233,0.035611897706985474,0.06093630939722061,-0.02334446832537651,-0.04185735806822777,-0.12386606633663177,-0.01892555132508278,-0.10353036224842072,0.10862858593463898,-0.03624968230724335,0.23741012811660767,-0.08543668687343597,-0.1786068081855774,-0.17495590448379517,-0.0009395764209330082,0.16527633368968964,-0.15357741713523865,-0.04238232225179672,-0.024395786225795746,0.019428100436925888,0.0856897383928299,-0.04234734922647476,0.03885835409164429,0.07144016027450562,-0.07755300402641296,-0.311881422996521,-0.09431690722703934,-0.11011797189712524,0.009758047759532928,-0.04227915778756142,-0.08227792382240295,0.0491815060377121,-0.1934223771095276,-0.14908835291862488,-0.01064763031899929,0.07985357195138931,-0.0021209907718002796,-0.026351386681199074,0.1463666707277298,-0.004629639443010092,-0.22665679454803467,0.0273293424397707,0.04256419837474823,0.21795117855072021,0.17425453662872314,0.10920977592468262,0.014298473484814167,-0.10088091343641281,0.06467999517917633,-0.14513945579528809,0.057210780680179596,0.11696887761354446,0.09430709481239319,0.030648592859506607,-0.0034867441281676292,-0.10592837631702423,0.03299914300441742,0.07902448624372482,-0.1944751739501953,-0.008702028542757034,0.07853192836046219,-0.016575787216424942,-0.013559456914663315,-0.05226337909698486,0.26290109753608704,0.08625926822423935,-0.10654498636722565,-0.11697999387979507,0.13432282209396362,-0.1259758621454239,-0.08039477467536926,0.05805129557847977,-0.15435749292373657,-0.16068926453590393,-0.32944169640541077,0.05033833533525467,0.3409237265586853,0.08299441635608673,-0.18857593834400177,0.027555087581276894,-0.13047035038471222,-0.01055178139358759,0.13633102178573608,0.11894317716360092,0.0451299324631691,0.026444116607308388,-0.05419658124446869,-0.04199197515845299,0.14421960711479187,-0.07019224017858505,-0.010275650769472122,0.19986242055892944,0.009344818070530891,0.037670619785785675,-0.02149333991110325,-0.017118269577622414,-0.04430755227804184,0.07771973311901093,-0.12514206767082214,-0.03147244453430176,0.09354326874017715,-0.003515489399433136,0.03688711300492287,0.11902707815170288,-0.2001355141401291,0.07557959109544754,0.04289209842681885,0.00763304578140378,0.07903897017240524,0.004354984499514103,-0.10333383083343506,-0.10323682427406311,0.10030178725719452,-0.22906962037086487,0.2325391173362732,0.18256673216819763,0.05470321327447891,0.06755782663822174,0.08977919816970825,0.08886748552322388,0.0065647903829813,-0.028476402163505554,-0.18129123747348785,0.013443244621157646,0.13839027285575867,-0.03681107610464096,0.09076002240180969,0.012056158855557442]', NULL, NULL, 'uploads/faces/user_5_1782946007.jpg'),
(6, 'ad2', 'huy123@gmail.com', '$2y$10$Phrk4NQnjhBmZMz2LlDnDuZGDKIwciUWOITafyQZ5UhMy8PLuIxsW', '098636463', NULL, 'user', 'active', '2026-06-16 05:06:04', '2026-07-01 22:42:14', '[-0.03750402852892876,0.1739824116230011,0.07631984353065491,0.0320124551653862,-0.11987768113613129,-0.019524570554494858,0.002664705738425255,-0.0433848574757576,0.159818634390831,-0.006668031215667725,0.24528174102306366,-0.12365199625492096,-0.2761269211769104,-0.030451752245426178,-0.029142849147319794,0.06146508455276489,-0.12642493844032288,-0.16923728585243225,-0.0754547193646431,-0.0775124728679657,0.09443303197622299,-0.03954300284385681,-0.04989970475435257,0.10734057426452637,-0.17909446358680725,-0.32117804884910583,-0.04962336644530296,-0.15053318440914154,0.06347420811653137,-0.2099614292383194,-0.016569942235946655,0.05657007545232773,-0.21129029989242554,-0.15022248029708862,-0.02235080860555172,0.10214494168758392,-0.09652262926101685,-0.10957139730453491,0.2337457686662674,-0.01617780700325966,-0.12889452278614044,0.15236395597457886,0.06989411264657974,0.3188091814517975,0.1556907594203949,0.07855674624443054,0.012375393882393837,-0.07865986227989197,0.1871866136789322,-0.28694015741348267,0.1049070730805397,0.1748475581407547,0.2264535278081894,0.12993797659873962,0.1227911114692688,-0.22581419348716736,0.032822735607624054,0.1528778374195099,-0.2969222068786621,0.1906505674123764,0.06715462356805801,-0.012438587844371796,-0.015052558854222298,-0.11514879018068314,0.21228602528572083,0.11235491186380386,-0.09533730149269104,-0.10827403515577316,0.11225774884223938,-0.18651831150054932,-0.07607883960008621,0.19891592860221863,-0.06979899853467941,-0.22345224022865295,-0.271282821893692,0.17948558926582336,0.4387575685977936,0.2037641406059265,-0.23491282761096954,-0.022158045321702957,0.030334703624248505,-0.025596322491765022,0.07145938277244568,0.05081170052289963,-0.12496018409729004,-0.053198449313640594,-0.12614212930202484,0.00953909195959568,0.17953869700431824,0.07038546353578568,-0.08154742419719696,0.2493886649608612,0.0360615998506546,0.06392639130353928,0.04309331625699997,-0.005568291526287794,-0.14266635477542877,-0.006605581846088171,-0.16188450157642365,-0.0026732860133051872,0.015425276011228561,-0.0950232744216919,-0.08753705024719238,0.033484213054180145,-0.13373327255249023,0.09127532690763474,-0.042817387729883194,-0.035514816641807556,-0.10418255627155304,-0.0026546819135546684,-0.18194164335727692,0.061874035745859146,0.20174211263656616,-0.41023802757263184,0.21148830652236938,0.13279426097869873,0.056682098656892776,0.10696719586849213,0.11201034486293793,0.0064439959824085236,0.0637311115860939,-0.059463873505592346,-0.18398959934711456,-0.08247358351945877,0.14380663633346558,-0.07809577137231827,0.06374640017747879,-0.0007615187205374241]', NULL, NULL, NULL),
(7, 'huy12', 'huy1223@gmail.com', '$2y$10$zk1IYH6lWOMj.5BVw4Db5.lESnes2lf7LolDXm5db.BrS7JPh3gBu', '09843454', NULL, 'user', 'active', '2026-06-16 05:18:05', '2026-07-01 22:32:51', '[-0.03750402852892876,0.1739824116230011,0.07631984353065491,0.0320124551653862,-0.11987768113613129,-0.019524570554494858,0.002664705738425255,-0.0433848574757576,0.159818634390831,-0.006668031215667725,0.24528174102306366,-0.12365199625492096,-0.2761269211769104,-0.030451752245426178,-0.029142849147319794,0.06146508455276489,-0.12642493844032288,-0.16923728585243225,-0.0754547193646431,-0.0775124728679657,0.09443303197622299,-0.03954300284385681,-0.04989970475435257,0.10734057426452637,-0.17909446358680725,-0.32117804884910583,-0.04962336644530296,-0.15053318440914154,0.06347420811653137,-0.2099614292383194,-0.016569942235946655,0.05657007545232773,-0.21129029989242554,-0.15022248029708862,-0.02235080860555172,0.10214494168758392,-0.09652262926101685,-0.10957139730453491,0.2337457686662674,-0.01617780700325966,-0.12889452278614044,0.15236395597457886,0.06989411264657974,0.3188091814517975,0.1556907594203949,0.07855674624443054,0.012375393882393837,-0.07865986227989197,0.1871866136789322,-0.28694015741348267,0.1049070730805397,0.1748475581407547,0.2264535278081894,0.12993797659873962,0.1227911114692688,-0.22581419348716736,0.032822735607624054,0.1528778374195099,-0.2969222068786621,0.1906505674123764,0.06715462356805801,-0.012438587844371796,-0.015052558854222298,-0.11514879018068314,0.21228602528572083,0.11235491186380386,-0.09533730149269104,-0.10827403515577316,0.11225774884223938,-0.18651831150054932,-0.07607883960008621,0.19891592860221863,-0.06979899853467941,-0.22345224022865295,-0.271282821893692,0.17948558926582336,0.4387575685977936,0.2037641406059265,-0.23491282761096954,-0.022158045321702957,0.030334703624248505,-0.025596322491765022,0.07145938277244568,0.05081170052289963,-0.12496018409729004,-0.053198449313640594,-0.12614212930202484,0.00953909195959568,0.17953869700431824,0.07038546353578568,-0.08154742419719696,0.2493886649608612,0.0360615998506546,0.06392639130353928,0.04309331625699997,-0.005568291526287794,-0.14266635477542877,-0.006605581846088171,-0.16188450157642365,-0.0026732860133051872,0.015425276011228561,-0.0950232744216919,-0.08753705024719238,0.033484213054180145,-0.13373327255249023,0.09127532690763474,-0.042817387729883194,-0.035514816641807556,-0.10418255627155304,-0.0026546819135546684,-0.18194164335727692,0.061874035745859146,0.20174211263656616,-0.41023802757263184,0.21148830652236938,0.13279426097869873,0.056682098656892776,0.10696719586849213,0.11201034486293793,0.0064439959824085236,0.0637311115860939,-0.059463873505592346,-0.18398959934711456,-0.08247358351945877,0.14380663633346558,-0.07809577137231827,0.06374640017747879,-0.0007615187205374241]', '789435e5a59e08641d71adbe4afc9af3d351184e1bc318fce16d7c38302e44df', '2026-07-02 01:32:51', NULL),
(8, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '$2y$10$9pO01cCpJKB2C6B46OWZne1XEn4XcI23vWHOVUeFZ2c3/e9B5QDZm', '0912345671', NULL, 'user', 'active', '2026-06-21 18:54:27', '2026-06-21 18:54:27', NULL, NULL, NULL, NULL),
(9, 'Trần Thị B', 'tranthib@gmail.com', '$2y$10$9pO01cCpJKB2C6B46OWZne1XEn4XcI23vWHOVUeFZ2c3/e9B5QDZm', '0912345672', NULL, 'user', 'active', '2026-06-21 18:54:27', '2026-07-01 22:44:57', '[-0.03750402852892876,0.1739824116230011,0.07631984353065491,0.0320124551653862,-0.11987768113613129,-0.019524570554494858,0.002664705738425255,-0.0433848574757576,0.159818634390831,-0.006668031215667725,0.24528174102306366,-0.12365199625492096,-0.2761269211769104,-0.030451752245426178,-0.029142849147319794,0.06146508455276489,-0.12642493844032288,-0.16923728585243225,-0.0754547193646431,-0.0775124728679657,0.09443303197622299,-0.03954300284385681,-0.04989970475435257,0.10734057426452637,-0.17909446358680725,-0.32117804884910583,-0.04962336644530296,-0.15053318440914154,0.06347420811653137,-0.2099614292383194,-0.016569942235946655,0.05657007545232773,-0.21129029989242554,-0.15022248029708862,-0.02235080860555172,0.10214494168758392,-0.09652262926101685,-0.10957139730453491,0.2337457686662674,-0.01617780700325966,-0.12889452278614044,0.15236395597457886,0.06989411264657974,0.3188091814517975,0.1556907594203949,0.07855674624443054,0.012375393882393837,-0.07865986227989197,0.1871866136789322,-0.28694015741348267,0.1049070730805397,0.1748475581407547,0.2264535278081894,0.12993797659873962,0.1227911114692688,-0.22581419348716736,0.032822735607624054,0.1528778374195099,-0.2969222068786621,0.1906505674123764,0.06715462356805801,-0.012438587844371796,-0.015052558854222298,-0.11514879018068314,0.21228602528572083,0.11235491186380386,-0.09533730149269104,-0.10827403515577316,0.11225774884223938,-0.18651831150054932,-0.07607883960008621,0.19891592860221863,-0.06979899853467941,-0.22345224022865295,-0.271282821893692,0.17948558926582336,0.4387575685977936,0.2037641406059265,-0.23491282761096954,-0.022158045321702957,0.030334703624248505,-0.025596322491765022,0.07145938277244568,0.05081170052289963,-0.12496018409729004,-0.053198449313640594,-0.12614212930202484,0.00953909195959568,0.17953869700431824,0.07038546353578568,-0.08154742419719696,0.2493886649608612,0.0360615998506546,0.06392639130353928,0.04309331625699997,-0.005568291526287794,-0.14266635477542877,-0.006605581846088171,-0.16188450157642365,-0.0026732860133051872,0.015425276011228561,-0.0950232744216919,-0.08753705024719238,0.033484213054180145,-0.13373327255249023,0.09127532690763474,-0.042817387729883194,-0.035514816641807556,-0.10418255627155304,-0.0026546819135546684,-0.18194164335727692,0.061874035745859146,0.20174211263656616,-0.41023802757263184,0.21148830652236938,0.13279426097869873,0.056682098656892776,0.10696719586849213,0.11201034486293793,0.0064439959824085236,0.0637311115860939,-0.059463873505592346,-0.18398959934711456,-0.08247358351945877,0.14380663633346558,-0.07809577137231827,0.06374640017747879,-0.0007615187205374241]', NULL, NULL, 'uploads/faces/user_9_1782945897.jpg'),
(10, 'Lê Hoàng C', 'lehoangc@gmail.com', '$2y$10$9pO01cCpJKB2C6B46OWZne1XEn4XcI23vWHOVUeFZ2c3/e9B5QDZm', '0912345673', NULL, 'user', 'active', '2026-06-21 18:54:27', '2026-06-21 18:54:27', NULL, NULL, NULL, NULL),
(11, 'Phạm Minh D', 'phamminhd@gmail.com', '$2y$10$9pO01cCpJKB2C6B46OWZne1XEn4XcI23vWHOVUeFZ2c3/e9B5QDZm', '0912345674', NULL, 'user', 'active', '2026-06-21 18:54:27', '2026-06-21 18:54:27', NULL, NULL, NULL, NULL),
(12, 'Đặng Thu E', 'dangthue@gmail.com', '$2y$10$9pO01cCpJKB2C6B46OWZne1XEn4XcI23vWHOVUeFZ2c3/e9B5QDZm', '0912345675', NULL, 'user', 'active', '2026-06-21 18:54:27', '2026-06-21 18:54:27', NULL, NULL, NULL, NULL),
(13, '1234', 'h123@gmail.com', '$2y$10$WJDRr5HT1MYqFpht7Cj.We2NEmndVl9vK1CuFkFEkkRm2gj7gsdM.', '09843454', NULL, 'user', 'active', '2026-07-01 22:51:31', '2026-07-01 22:51:31', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_promotions`
--

CREATE TABLE `user_promotions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `status` enum('available','used') NOT NULL DEFAULT 'available',
  `claimed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_promotions`
--

INSERT INTO `user_promotions` (`id`, `user_id`, `promotion_id`, `status`, `claimed_at`, `used_at`) VALUES
(1, 5, 5, 'available', '2026-06-21 03:49:16', NULL),
(2, 5, 3, 'available', '2026-06-21 04:03:41', NULL),
(3, 6, 9, 'available', '2026-06-24 03:33:06', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `additional_services`
--
ALTER TABLE `additional_services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bespoke_requests`
--
ALTER TABLE `bespoke_requests`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_tour` (`tour_id`);

--
-- Chỉ mục cho bảng `booking_passengers`
--
ALTER TABLE `booking_passengers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_passenger_booking` (`booking_id`);

--
-- Chỉ mục cho bảng `combos`
--
ALTER TABLE `combos`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `combo_bookings`
--
ALTER TABLE `combo_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Chỉ mục cho bảng `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `guide_images`
--
ALTER TABLE `guide_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Chỉ mục cho bảng `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Chỉ mục cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_itinerary_tour` (`tour_id`);

--
-- Chỉ mục cho bảng `logout_reviews`
--
ALTER TABLE `logout_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_booking` (`booking_id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_user` (`user_id`),
  ADD KEY `fk_review_tour` (`tour_id`);

--
-- Chỉ mục cho bảng `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Chỉ mục cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_tour_destination` (`destination_id`);

--
-- Chỉ mục cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tour_images` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_promotions`
--
ALTER TABLE `user_promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_claim` (`user_id`,`promotion_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `additional_services`
--
ALTER TABLE `additional_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `bespoke_requests`
--
ALTER TABLE `bespoke_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `booking_passengers`
--
ALTER TABLE `booking_passengers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `combos`
--
ALTER TABLE `combos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `combo_bookings`
--
ALTER TABLE `combo_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `flight_bookings`
--
ALTER TABLE `flight_bookings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `guide_images`
--
ALTER TABLE `guide_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `logout_reviews`
--
ALTER TABLE `logout_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT cho bảng `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `user_promotions`
--
ALTER TABLE `user_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_booking_tour` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `booking_passengers`
--
ALTER TABLE `booking_passengers`
  ADD CONSTRAINT `fk_passenger_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD CONSTRAINT `flight_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flight_bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `guide_images`
--
ALTER TABLE `guide_images`
  ADD CONSTRAINT `guide_images_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD CONSTRAINT `hotel_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hotel_bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `itineraries`
--
ALTER TABLE `itineraries`
  ADD CONSTRAINT `fk_itinerary_tour` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_tour` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD CONSTRAINT `service_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `additional_services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `fk_tour_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `fk_tour_images` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_schedules`
--
ALTER TABLE `tour_schedules`
  ADD CONSTRAINT `tour_schedules_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
