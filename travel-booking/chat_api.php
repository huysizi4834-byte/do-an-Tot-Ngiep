<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? mb_strtolower(trim($_POST['message'])) : '';
    
    // Simulate AI thinking time
    sleep(1);
    
    // Bộ lọc từ thô tục
    $bad_words = ['đm', 'dm', 'vcl', 'địt', 'lồn', 'cặc', 'ngu', 'chó', 'fuck', 'shit', 'bitch', 'đĩ', 'điếm', 'cút', 'khốn'];
    foreach ($bad_words as $word) {
        if (strpos($message, $word) !== false) {
            echo json_encode(['reply' => "Xin lỗi, tôi nhận thấy có từ ngữ không phù hợp. Nếu bạn cần khiếu nại, hãy gọi cho Admin theo số 1900 1234 nhé!"]);
            exit;
        }
    }
    
    $reply = "Dạ, em là AI của THEGIOI Travel. Em ghi nhận câu hỏi '" . htmlspecialchars($_POST['message']) . "' của anh/chị. Hiện tại em đang được huấn luyện thêm về chủ đề này. Anh/chị có muốn tham khảo các Tour Khuyến Mãi không ạ?";
    
    // Detect destinations first
    $destinations = ['phú quốc', 'đà lạt', 'sapa', 'hạ long', 'đà nẵng', 'nha trang', 'quy nhơn', 'thái lan', 'hàn quốc', 'nhật bản', 'châu âu', 'bali', 'đài loan', 'singapore'];
    $found_dest = false;
    foreach ($destinations as $dest) {
        if (strpos($message, $dest) !== false) {
            $destName = mb_convert_case($dest, MB_CASE_TITLE, "UTF-8");
            
            // Check if user also mentioned combo
            if (strpos($message, 'combo') !== false) {
                $reply = "Tuyệt vời! THEGIOI Travel đang có rất nhiều <strong>Combo (Vé máy bay + Khách sạn) đi {$destName}</strong> với giá cực kỳ ưu đãi. Anh/chị có thể xem chi tiết và đặt chỗ ngay tại <a href='tours.php?search=" . urlencode($destName) . "'>Danh sách Combo {$destName}</a> nhé!";
            } else {
                $reply = "Tuyệt vời! THEGIOI Travel đang có rất nhiều <strong>Tour đi {$destName}</strong> với lịch trình siêu hấp dẫn. Anh/chị có thể xem chi tiết và đặt chỗ ngay tại <a href='tours.php?search=" . urlencode($destName) . "'>Danh sách Tour {$destName}</a> nhé!";
            }
            $found_dest = true;
            break;
        }
    }
    
    // Keyword based logic (Simulated AI) if no destination was mentioned
    if (!$found_dest) {
        if (strpos($message, 'đặt tour') !== false || strpos($message, 'cách đặt') !== false) {
            $reply = "Để đặt tour, bạn vui lòng chọn mục 'Tour du lịch' trên menu, tìm tour ưng ý, bấm vào xem chi tiết và điền form thông tin hành khách để xác nhận đặt nhé!";
        } elseif (strpos($message, 'combo') !== false) {
            $reply = "Dạ, THEGIOI Travel hiện đang cung cấp rất nhiều Combo Du Lịch (Bao gồm Vé máy bay + Khách sạn) siêu tiết kiệm. Anh/chị có thể vào mục 'Combo du lịch' trên menu để tham khảo hoặc cho em biết điểm đến cụ thể ạ!";
        } elseif (strpos($message, 'hủy') !== false || strpos($message, 'hoàn tiền') !== false || strpos($message, 'đổi') !== false) {
            $reply = "Bạn có thể hủy đơn đặt tour trong trang 'Hồ sơ -> Tour của tôi'. Nếu đơn hàng chưa được duyệt, bạn sẽ được hoàn tiền 100%. Nếu đã duyệt, vui lòng liên hệ trực tiếp tổng đài để xử lý.";
        } elseif (strpos($message, 'thanh toán') !== false || strpos($message, 'chuyển khoản') !== false || strpos($message, 'tiền') !== false) {
            $reply = "Chúng tôi hỗ trợ 2 phương thức thanh toán: Đặt cọc trước 50% hoặc Thanh toán 100%. Sau khi đặt, hệ thống sẽ sinh ra mã QR Code để bạn quét chuyển khoản bằng bất kỳ ứng dụng ngân hàng nào (Momo, VNPay, SmartBanking...).";
        } elseif (strpos($message, 'liên hệ') !== false || strpos($message, 'tổng đài') !== false || strpos($message, 'admin') !== false || strpos($message, ' ad ') !== false || strpos($message, 'gọi ad') !== false || strpos($message, 'số điện thoại') !== false || strpos($message, 'sđt') !== false || strpos($message, 'sdt') !== false || strpos($message, 'hotline') !== false) {
            $reply = "Dạ, để trao đổi trực tiếp với Admin hỗ trợ, anh/chị vui lòng gọi vào số Hotline: <strong><a href='tel:19001234' style='color:#0d6efd; text-decoration:underline;'><i class='fa-solid fa-phone-volume'></i> 1900 1234</a></strong> nhé. Admin của THEGIOI Travel luôn túc trực 24/7 để hỗ trợ anh/chị ạ!";
        } elseif (strpos($message, 'chào') !== false || strpos($message, 'hi ') !== false || $message === 'hi') {
            $reply = "Chào bạn! Mình là AI hỗ trợ của THEGIOI Travel. Mình giúp gì được cho chuyến đi sắp tới của bạn?";
        } elseif (strpos($message, 'giá') !== false || strpos($message, 'bao nhiêu') !== false) {
            $reply = "Giá của các Tour/Khách sạn/Vé máy bay được hiển thị chi tiết trên từng trang. Bạn có thể sử dụng chức năng chọn Tiền tệ (VND, USD, EUR, JPY) ở góc phải trên cùng màn hình để xem giá theo ngoại tệ nhé.";
        } elseif (strpos($message, 'ngoại tệ') !== false || strpos($message, 'usd') !== false) {
            $reply = "Hệ thống tự động quy đổi ngoại tệ khi bạn chọn Vị trí đến là nước ngoài (Mỹ -> USD, Châu Âu -> EUR, Nhật Bản -> JPY) ở thanh công cụ phía trên trang web.";
        }
    }

    echo json_encode(['reply' => $reply]);
    exit;
}
