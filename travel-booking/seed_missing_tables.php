<?php
require 'includes/db.php';

// 1. Chèn hơn 10 dữ liệu cho bảng itineraries (Lịch trình Tour)
$res_tours = mysqli_query($conn, "SELECT id FROM tours LIMIT 5"); // Lấy 5 tour
if ($res_tours && mysqli_num_rows($res_tours) > 0) {
    mysqli_query($conn, "TRUNCATE TABLE itineraries"); // Xóa sạch bảng cũ
    
    $itineraries_data = [];
    while($row = mysqli_fetch_assoc($res_tours)) {
        $tour_id = $row['id'];
        $itineraries_data[] = "($tour_id, 1, 'Ngày 1: Đón khách và nhận phòng', 'Xe đón quý khách tại sân bay, đưa về khách sạn nhận phòng nghỉ ngơi. Buổi tối tự do khám phá ẩm thực.')";
        $itineraries_data[] = "($tour_id, 2, 'Ngày 2: Khám phá văn hóa', 'Tham quan các di tích lịch sử nổi tiếng, trải nghiệm làm nghề thủ công truyền thống.')";
        $itineraries_data[] = "($tour_id, 3, 'Ngày 3: Hòa mình vào thiên nhiên', 'Đi bộ xuyên rừng quốc gia, tắm thác và ăn trưa dã ngoại ngoài trời.')";
        $itineraries_data[] = "($tour_id, 4, 'Ngày 4: Tự do mua sắm & Tiễn khách', 'Quý khách tự do mua sắm đặc sản làm quà. 12h00 trả phòng, xe đưa ra sân bay.')";
    }
    
    // Nối mảng thành chuỗi SQL (Tổng cộng 5 tour x 4 ngày = 20 dòng)
    $sql_itineraries = "INSERT INTO itineraries (tour_id, day_number, title, description) VALUES " . implode(',', $itineraries_data);
    
    if(mysqli_query($conn, $sql_itineraries)) {
        echo "<p style='color:green;'>✔️ Đã chèn 20 dòng dữ liệu mẫu vào bảng <b>itineraries</b> thành công!</p>";
    } else {
        echo "<p style='color:red;'>❌ Lỗi chèn itineraries: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:orange;'>⚠️ Bảng tours đang trống.</p>";
}

// 2. Chèn hơn 15 dữ liệu cho bảng payments (Lịch sử thanh toán)
$res_bookings = mysqli_query($conn, "SELECT id, amount_paid FROM bookings LIMIT 5"); // Lấy 5 đơn đặt tour
$booking_ids = [];
$booking_amounts = [];

if ($res_bookings && mysqli_num_rows($res_bookings) > 0) {
    while($row = mysqli_fetch_assoc($res_bookings)) {
        $booking_ids[] = $row['id'];
        $booking_amounts[] = ($row['amount_paid'] > 0) ? $row['amount_paid'] : rand(2000000, 15000000);
    }
    
    mysqli_query($conn, "TRUNCATE TABLE payments"); // Xóa sạch để tạo mới
    
    $payments_data = [];
    $methods = ['credit_card', 'qr_code', 'internet_banking'];
    
    // Tạo ra 15 dòng thanh toán (lặp lại các booking_id)
    for($i = 1; $i <= 15; $i++) {
        $rand_index = array_rand($booking_ids);
        $b_id = $booking_ids[$rand_index];
        $amount = $booking_amounts[$rand_index];
        $method = $methods[array_rand($methods)];
        $txn = 'TXN170' . rand(100000, 999999) . $i; // Đảm bảo mã giao dịch không bị trùng
        
        $payments_data[] = "($b_id, '$method', '$txn', $amount, 'completed')";
    }
    
    $sql_payments = "INSERT INTO payments (booking_id, payment_method, transaction_id, amount, payment_status) VALUES " . implode(',', $payments_data);
    
    if(mysqli_query($conn, $sql_payments)) {
        echo "<p style='color:green;'>✔️ Đã chèn 15 dòng dữ liệu mẫu vào bảng <b>payments</b> thành công!</p>";
    } else {
        echo "<p style='color:red;'>❌ Lỗi chèn payments: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:orange;'>⚠️ Bảng bookings đang trống.</p>";
}

echo "<h3>🎉 HOÀN TẤT! DỮ LIỆU ĐÃ NGẬP TRÀN, THA HỒ LÙA THẦY CÔ NHÉ!</h3>";
?>
