<?php
require 'includes/db.php';

$guides = [
    [
        'title' => 'Bí kíp du lịch Phú Quốc 3 Ngày 2 Đêm tự túc siêu tiết kiệm',
        'excerpt' => 'Phú Quốc luôn là điểm đến hấp dẫn với biển xanh, cát trắng và nắng vàng. Bài viết này sẽ hướng dẫn bạn cách đi Phú Quốc với chi phí cực rẻ.',
        'content' => '<p>Phú Quốc không chỉ nổi tiếng với những bãi biển tuyệt đẹp như Bãi Sao, Bãi Khem mà còn thu hút du khách bởi ẩm thực phong phú và các khu vui chơi giải trí hàng đầu như VinWonders, Safari.</p>
        <p><strong>1. Thời điểm lý tưởng:</strong> Thời tiết đẹp nhất để đi Phú Quốc là từ tháng 11 đến tháng 4 năm sau. Lúc này biển êm, ít mưa và có nắng đẹp.</p>
        <p><strong>2. Di chuyển:</strong> Nếu bạn ở TP.HCM, vé máy bay khứ hồi thường dao động từ 1.000.000đ - 1.500.000đ. Đặt vé sớm 1 tháng để có giá tốt nhất.</p>
        <p><strong>3. Chỗ ở:</strong> Để tiết kiệm, bạn có thể chọn các homestay ở khu vực trung tâm thị trấn Dương Đông với giá từ 300.000đ/đêm. Nếu thích nghỉ dưỡng, khu vực Bãi Trường có nhiều Resort cao cấp.</p>
        <p><strong>4. Ăn uống:</strong> Đừng bỏ qua chợ đêm Phú Quốc với vô vàn món hải sản tươi sống: Nhum nướng mỡ hành, gỏi cá trích, mực trứng nướng...</p>',
        'image' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Lịch trình khám phá Đà Lạt 4 mùa hoa nở rực rỡ',
        'excerpt' => 'Đà Lạt mùa nào cũng đẹp, mỗi mùa mang một vẻ đẹp riêng. Cùng khám phá Đà Lạt qua lăng kính 4 mùa trong năm nhé.',
        'content' => '<p>Đà Lạt được mệnh danh là thành phố ngàn hoa, nơi bạn có thể cảm nhận được vẻ đẹp lãng mạn và bình yên đến lạ kỳ.</p>
        <p><strong>Mùa Xuân (Tháng 1 - 3):</strong> Mùa rực rỡ nhất với sắc hồng của hoa Mai Anh Đào nở rộ khắp các con phố. Đây cũng là lúc thời tiết ấm áp, ít mưa nhất.</p>
        <p><strong>Mùa Hạ (Tháng 4 - 6):</strong> Mùa của hoa Phượng Tím lãng mạn. Buổi sáng trời trong vắt, ban đêm se se lạnh, rất thích hợp để dạo bước Hồ Xuân Hương.</p>
        <p><strong>Mùa Thu (Tháng 7 - 9):</strong> Mùa của những cơn mưa rào bất chợt. Tuy nhiên, nếu bạn thích nhâm nhi ly cà phê nóng và ngắm mưa, đây là thời điểm không thể tuyệt vời hơn.</p>
        <p><strong>Mùa Đông (Tháng 10 - 12):</strong> Sương mù giăng lối khắp các triền đồi. Mùa hoa Dã Quỳ vàng rực nhuộm kín các con đường ngoại ô như đèo D\'ran, Trại Mát.</p>',
        'image' => 'https://images.unsplash.com/photo-1599708153386-62bf0cbcfdc1?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Kinh nghiệm xin Visa Châu Âu (Schengen) bao đậu 99%',
        'excerpt' => 'Xin Visa Schengen luôn là nỗi e ngại của nhiều người. Tuy nhiên, với sự chuẩn bị kỹ lưỡng, bạn hoàn toàn có thể cầm trên tay chiếc vé thông hành quyền lực này.',
        'content' => '<p>Khối Schengen bao gồm 27 quốc gia Châu Âu. Xin được Visa Schengen, bạn có thể tự do di chuyển giữa các quốc gia này mà không cần xin thêm visa.</p>
        <p><strong>1. Hồ sơ cá nhân:</strong> Cần chuẩn bị đầy đủ Hộ chiếu còn hạn, Căn cước công dân, Sổ hộ khẩu, Giấy đăng ký kết hôn (nếu có).</p>
        <p><strong>2. Hồ sơ công việc:</strong> Hợp đồng lao động, Giấy xin nghỉ phép, Bảng lương 3 tháng gần nhất. Nếu là chủ doanh nghiệp cần Giấy phép kinh doanh và Biên lai nộp thuế.</p>
        <p><strong>3. Hồ sơ tài chính:</strong> Sổ tiết kiệm tối thiểu 100-200 triệu đồng, Sao kê tài khoản ngân hàng, Giấy tờ nhà đất (nếu có).</p>
        <p><strong>4. Mẹo:</strong> Nên xin visa ở Lãnh sự quán Pháp hoặc Hà Lan vì thủ tục nhanh và tỷ lệ đậu thường cao hơn các nước khác. THEGIOI Travel có cung cấp dịch vụ hỗ trợ làm Visa bao đậu với chi phí cực hợp lý.</p>',
        'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&q=80&w=800'
    ],
    [
        'title' => 'Cẩm nang du lịch Thái Lan 2026: Ăn gì, chơi đâu?',
        'excerpt' => 'Bangkok - Pattaya luôn là hành trình "quốc dân" với du khách Việt. Cùng THEGIOI Travel khám phá những điểm đến mới toanh tại Xứ sở Chùa Vàng.',
        'content' => '<p>Thái Lan không ngừng đổi mới để thu hút khách du lịch. Ngoài những điểm tham quan quen thuộc, năm 2026 Thái Lan có rất nhiều khu vui chơi và trải nghiệm mới.</p>
        <p><strong>Ăn uống:</strong> Ẩm thực Thái Lan chưa bao giờ làm du khách thất vọng. Từ Pad Thai, Tom Yum Gung, Som Tum đến món xôi xoài ngọt lịm. Đừng quên ghé khu phố Tàu Chinatown (Yaowarat) vào ban đêm để thưởng thức các món ăn đường phố đỉnh cao.</p>
        <p><strong>Mua sắm:</strong> Central World, Siam Paragon cho đồ hiệu; Platinum, Chatuchak (chợ cuối tuần) cho quần áo giá sỉ. Hãy chuẩn bị một chiếc vali trống và mang một đôi giày thể thao thật êm vì bạn sẽ phải đi bộ rất nhiều!</p>
        <p><strong>Di chuyển:</strong> Hãy thử trải nghiệm xe Tuk-tuk - "đặc sản" của giao thông Thái Lan. Tuy nhiên, tàu điện trên cao (BTS) và dưới ngầm (MRT) mới là phương tiện di chuyển nhanh chóng và tiện lợi nhất để tránh kẹt xe ở Bangkok.</p>',
        'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&q=80&w=800'
    ]
];

$count = 0;
foreach ($guides as $g) {
    $title = mysqli_real_escape_string($conn, $g['title']);
    $excerpt = mysqli_real_escape_string($conn, $g['excerpt']);
    $content = mysqli_real_escape_string($conn, $g['content']);
    $image = mysqli_real_escape_string($conn, $g['image']);
    
    $sql = "INSERT INTO guides (title, excerpt, content, image, created_at) 
            VALUES ('$title', '$excerpt', '$content', '$image', NOW())";
            
    if (mysqli_query($conn, $sql)) {
        $count++;
    } else {
        echo "Lỗi khi chèn: " . mysqli_error($conn) . "\n";
    }
}
echo "Đã chèn thành công $count bài viết cẩm nang!\n";
?>
