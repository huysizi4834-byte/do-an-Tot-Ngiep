TRƯỜNG CAO ĐẲNG KỸ THUẬT – CÔNG NGHỆ BÁCH KHOA
KHOA CÔNG NGHỆ THÔNG TIN
***

# BÁO CÁO ĐỒ ÁN TỐT NGHIỆP

**ĐỀ TÀI: XÂY DỰNG HỆ THỐNG ĐẶT CHỖ VÀ QUẢN LÝ DỊCH VỤ DU LỊCH (TRAVEL BOOKING SYSTEM)**

**Giảng viên hướng dẫn:** Lê Văn Quân  
**Sinh viên thực hiện:** [Tên của bạn]  
**Mã học sinh sinh viên:** [Mã SV của bạn]  
**Lớp:** [Lớp của bạn]  

**Hà Nội, ngày ..…. tháng……. năm 2026**

---

## MỤC LỤC
[TOC] *(Mục lục sẽ được tự động tạo trong Word)*

---

## LỜI MỞ ĐẦU
Trong bối cảnh chuyển đổi số đang diễn ra mạnh mẽ, ngành du lịch là một trong những lĩnh vực đòi hỏi sự số hóa cao nhất nhằm mang lại trải nghiệm tiện lợi cho khách hàng. Việc ứng dụng công nghệ thông tin vào quản lý và tự động hóa các quy trình nghiệp vụ ngày càng trở nên cần thiết. Đồ án tập trung nghiên cứu, phân tích, thiết kế và xây dựng hệ thống **Đặt chỗ và Quản lý Dịch vụ Du lịch (Travel Booking System)** nhằm giải quyết các hạn chế của phương pháp quản lý truyền thống như đặt tour thủ công, thiếu tích hợp thanh toán và khó khăn trong việc quản lý tập trung nhiều loại hình dịch vụ.

Đề tài sử dụng các công nghệ **PHP, MySQL, HTML/CSS/JS thuần, và các API hiện đại (Face ID, Vòng quay may mắn)** để phát triển hệ thống. Quá trình thực hiện bao gồm khảo sát yêu cầu, phân tích nghiệp vụ, thiết kế cơ sở dữ liệu, xây dựng giao diện người dùng, triển khai các chức năng chính và tiến hành kiểm thử.

Kết quả thực nghiệm cho thấy hệ thống hoạt động ổn định, đáp ứng các yêu cầu đặt ra và có khả năng mở rộng trong tương lai.

## LỜI CẢM ƠN
Trong quá trình thực hiện đề tài **“Xây dựng hệ thống Đặt chỗ và Quản lý Dịch vụ Du lịch”**, em đã nhận được sự quan tâm, hướng dẫn và tạo điều kiện thuận lợi từ phía Nhà trường và quý thầy cô.

Trước hết, em xin gửi lời cảm ơn chân thành đến Ban Giám hiệu Nhà trường cùng toàn thể quý thầy cô trong Khoa Công nghệ Thông tin đã tận tình giảng dạy, truyền đạt cho em những kiến thức chuyên môn quý báu trong suốt quá trình học tập. Những kiến thức nền tảng và kinh nghiệm thực tiễn mà quý thầy cô truyền đạt là hành trang quan trọng giúp em có thể tiếp cận, nghiên cứu và hoàn thành đề tài này.

Đặc biệt, em xin bày tỏ lòng biết ơn sâu sắc tới thầy **Lê Văn Quân** đã tận tình hướng dẫn, định hướng nội dung nghiên cứu và đóng góp nhiều ý kiến quý báu trong suốt quá trình thực hiện báo cáo. Sự quan tâm, hỗ trợ và những góp ý của thầy không chỉ giúp em hoàn thiện đề tài mà còn giúp em nâng cao kiến thức, kỹ năng nghiên cứu và khả năng tiếp cận các vấn đề thực tế trong lập trình web.

Mặc dù em đã cố gắng nghiên cứu và hoàn thiện báo cáo với tinh thần nghiêm túc và trách nhiệm, tuy nhiên do kiến thức và kinh nghiệm thực tế còn hạn chế nên báo cáo khó tránh khỏi những thiếu sót nhất định. Em rất mong nhận được những ý kiến đóng góp từ quý thầy cô để đề tài được hoàn thiện hơn.

Cuối cùng, em xin kính chúc quý thầy cô luôn mạnh khỏe, hạnh phúc và thành công trong công tác giảng dạy cũng như nghiên cứu khoa học.

Em xin chân thành cảm ơn!

## DANH MỤC TỪ VIẾT TẮT

| Từ viết tắt | Tiếng Anh | Tiếng Việt |
|---|---|---|
| CSDL | Database | Cơ sở dữ liệu |
| HTML | HyperText Markup Language | Ngôn ngữ đánh dấu siêu văn bản |
| CSS | Cascading Style Sheets | Ngôn ngữ định dạng trang web |
| JS | JavaScript | Ngôn ngữ lập trình kịch bản |
| API | Application Programming Interface | Giao diện lập trình ứng dụng |
| ERD | Entity-Relationship Diagram | Sơ đồ thực thể liên kết |

## DANH MỤC HÌNH ẢNH
*(Bạn sẽ chèn hình ảnh thực tế từ dự án của mình vào file Word và cập nhật số trang tương ứng)*
- Hình 1.1: Sơ đồ Use Case của hệ thống Travel Booking
- Hình 2.1: Sơ đồ kiến trúc công nghệ
- Hình 3.1: Mô hình thực thể liên kết (ERD) của Cơ sở dữ liệu
- Hình 3.2: Giao diện Trang chủ (index.php)
- Hình 3.3: Giao diện Đăng nhập bằng Face ID (register-face.php)
- Hình 3.4: Giao diện vòng quay may mắn (voucher-center.php)
- Hình 4.1: Môi trường phát triển XAMPP/MySQL

## DANH MỤC BẢNG BIỂU
- Bảng 1.1: So sánh ưu nhược điểm các công nghệ phát triển web
- Bảng 2.1: Danh sách tác nhân trong hệ thống
- Bảng 3.1: Chi tiết bảng Users
- Bảng 3.2: Chi tiết bảng Tours
- Bảng 5.1: Kết quả kiểm thử chức năng

---

# CHƯƠNG 1. TỔNG QUAN ĐỀ TÀI

### 1.1. Lý do chọn đề tài
Ngày nay, du lịch không chỉ là nhu cầu nghỉ ngơi mà còn là nhu cầu trải nghiệm văn hóa. Các doanh nghiệp du lịch đang phải đối mặt với bài toán số hóa: làm thế nào để khách hàng có thể tự do đặt tour, vé máy bay, khách sạn trên cùng một nền tảng một cách dễ dàng và minh bạch. Phương pháp quản lý qua điện thoại hoặc ghi chép thủ công không còn phù hợp, dễ dẫn đến sai sót và thất thoát dữ liệu. Do đó, việc xây dựng một hệ thống Travel Booking toàn diện là nhu cầu cấp thiết để nâng cao trải nghiệm khách hàng và tối ưu hóa quản lý doanh nghiệp.

### 1.2. Mục tiêu nghiên cứu
- **Tìm hiểu công nghệ liên quan:** Nắm vững cấu trúc lập trình PHP thuần, tương tác với MySQL và tích hợp các API như nhận diện khuôn mặt (Face Recognition).
- **Xây dựng hệ thống đáp ứng yêu cầu:** Phát triển hệ thống cho phép khách hàng tìm kiếm, đặt mua Tour, Khách sạn, Vé máy bay, Combo cũng như tích hợp thanh toán và các tính năng Gamification (như vòng quay Voucher). Cung cấp giao diện quản trị cho Admin.
- **Đánh giá hiệu quả hoạt động của hệ thống:** Đảm bảo luồng đặt chỗ chính xác, giao dịch lưu vết an toàn trong CSDL.

### 1.3. Đối tượng và phạm vi nghiên cứu
**1.3.1. Đối tượng nghiên cứu**
- **Người dùng hệ thống:** Khách hàng cá nhân, Nhân viên quản trị (Admin).
- **Công nghệ sử dụng:** PHP, MySQL, WebRTC (cho Face ID), JavaScript, HTML/CSS.

**1.3.2. Phạm vi nghiên cứu**
- **Chức năng hệ thống:** Bao gồm các module cốt lõi như Quản lý người dùng, Đặt tour, Đặt phòng, Đặt vé máy bay, Giỏ hàng, Cổng thanh toán, Trung tâm Voucher, Hỗ trợ Chatbot.
- **Dữ liệu sử dụng:** Dữ liệu giả lập về địa danh, giá tour, thông tin khách sạn.
- **Môi trường triển khai:** Web platform trên môi trường server Apache/Nginx.

### 1.4. Phương pháp thực hiện
- **Khảo sát yêu cầu:** Thu thập yêu cầu từ các quy trình đặt tour thực tế.
- **Phân tích thiết kế hệ thống:** Thiết kế cơ sở dữ liệu (ERD), sơ đồ chức năng (Use Case).
- **Lập trình và kiểm thử:** Tiến hành lập trình mã nguồn, cấu hình database và chạy kiểm thử hộp đen.
- **Đánh giá kết quả:** Tổng hợp lỗi và tối ưu hiệu suất tải trang.

**Tiểu kết chương 1:**
Chương 1 đã trình bày lý do chọn đề tài, mục tiêu nghiên cứu, phạm vi nghiên cứu và phương pháp thực hiện. Đây là cơ sở để triển khai các nội dung nghiên cứu ở các chương tiếp theo.

---

# CHƯƠNG 2. CƠ SỞ LÝ THUYẾT

### 2.1. Tổng quan lĩnh vực nghiên cứu
Lĩnh vực thương mại điện tử du lịch (E-tourism) là việc cung cấp và phân phối các dịch vụ liên quan đến du lịch thông qua internet. Nghiên cứu trong lĩnh vực này đòi hỏi sự hiểu biết về trải nghiệm người dùng (UX) đối với các form đặt chỗ phức tạp, cũng như xử lý luồng thanh toán an toàn.

### 2.2. Các công nghệ sử dụng
**2.2.1. Ngôn ngữ lập trình**
- **PHP (Hypertext Preprocessor):** Ngôn ngữ kịch bản chạy phía máy chủ. Lý do sử dụng: Cực kỳ phù hợp để xây dựng các ứng dụng web động quy mô vừa và nhỏ. Có cộng đồng hỗ trợ lớn và tốc độ tải trang nhanh do sử dụng native code không qua các tầng overhead của framework phức tạp.
- **JavaScript:** Ngôn ngữ xử lý phía Client. Trong dự án này, JS đóng vai trò then chốt trong việc gửi các yêu cầu bất đồng bộ (AJAX qua file `api_spin_wheel.php`...) và xử lý API WebRTC lấy luồng video để nhận diện Face ID.
- **HTML5 & CSS3:** Ngôn ngữ xây dựng cấu trúc và định dạng giao diện trang web.

**2.2.2. Hệ quản trị cơ sở dữ liệu**
- **MySQL:** Hệ quản trị CSDL quan hệ mã nguồn mở phổ biến nhất kết hợp với PHP.
- **Lý do sử dụng:** Độ tin cậy cao, tốc độ truy vấn nhanh, dễ dàng thao tác qua thư viện `mysqli`. MySQL cung cấp khả năng toàn vẹn dữ liệu cực tốt cho các bảng giao dịch (Bookings) thông qua các khóa ngoại (Foreign Keys).

**2.2.3. Framework và thư viện**
- **Bootstrap:** CSS framework giúp xây dựng giao diện Responsive (tự động điều chỉnh kích thước trên điện thoại, tablet) nhanh chóng.
- **FontAwesome:** Thư viện icon đa dạng làm sinh động giao diện.
- **Thư viện Face Recognition (JS):** Xử lý nhận diện và mã hóa khuôn mặt người dùng tại trình duyệt trước khi đẩy vector đặc trưng về CSDL.

### 2.3. Các nghiên cứu liên quan
Trên thị trường có nhiều hệ thống như Traveloka, Agoda, nhưng chúng quá khổng lồ và phức tạp. Đề tài này hướng đến một hệ thống gọn nhẹ, có tính cá nhân hóa (Bespoke Tours) và tích hợp các công nghệ tương tác hiện đại như Gamification (quay thưởng) và đăng nhập sinh trắc học mà các nền tảng nhỏ lẻ chưa làm được.

**Tiểu kết chương 2:**
Chương 2 đã trình bày các cơ sở lý thuyết, công nghệ sử dụng và các nghiên cứu liên quan làm nền tảng cho quá trình thiết kế và phát triển hệ thống.

---

# CHƯƠNG 3. PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG

### 3.1. Khảo sát yêu cầu
**3.1.1. Yêu cầu chức năng**
- **Dành cho Khách hàng:**
  - Đăng ký, Đăng nhập (Mật khẩu hoặc Face ID).
  - Tìm kiếm và đặt Tour, Hotel, Flight, Combo.
  - Quản lý giỏ hàng, Thanh toán.
  - Quay vòng quay may mắn nhận Voucher, dùng Voucher khi thanh toán.
  - Nhắn tin với Chatbot hỗ trợ.
- **Dành cho Quản trị viên (Admin):**
  - Quản lý người dùng, hướng dẫn viên.
  - Quản lý dữ liệu dịch vụ (Thêm/Sửa/Xóa Tour, Hotel, Flight).
  - Quản lý các chương trình ưu đãi (Voucher).
  - Thống kê, duyệt hóa đơn thanh toán.

**3.1.2. Yêu cầu phi chức năng**
- **Bảo mật:** Chống SQL Injection khi truy vấn CSDL, mã hóa mật khẩu, Face Data.
- **Hiệu năng:** Hệ thống phải tải trang sản phẩm dưới 3 giây.
- **Khả năng mở rộng:** Dễ dàng bổ sung thêm các dịch vụ mới ngoài tour, khách sạn.

### 3.2. Phân tích hệ thống
*(Lưu ý: Trong file Word, bạn hãy dùng Draw.io hoặc StarUML vẽ các sơ đồ này và chèn vào đây)*

**3.2.1. Sơ đồ Use Case**
- Tác nhân: Khách hàng, Quản trị viên (Admin).
- Khách hàng có thể "Đặt tour" (có Include: Đăng nhập), "Tham gia vòng quay", "Thanh toán". Admin có thể "Quản lý hệ thống".

**3.2.2. Activity Diagram (Sơ đồ hoạt động Đặt chỗ)**
Bắt đầu -> Chọn dịch vụ -> Thêm vào giỏ hàng -> Chọn phương thức thanh toán -> Hệ thống kiểm tra thanh toán -> Trừ tiền / Tạo hóa đơn -> Gửi email/thông báo -> Kết thúc.

**3.2.3. Sequence Diagram (Sơ đồ tuần tự Tính năng Face ID)**
Khách hàng -> Bật Camera (Browser) -> Chụp ảnh -> Gửi lên Server -> Server đối chiếu Database -> Trả về kết quả (Token/Session) -> Trình duyệt vào trang chủ.

### 3.3. Thiết kế cơ sở dữ liệu
**3.3.1. Mô hình ERD**
*(Bạn vẽ ERD chứa các bảng chính: Users, Tours, Bookings, Destinations)*
Mối quan hệ: Một User có thể tạo nhiều Bookings. Một Booking chứa nhiều dịch vụ (Tours, Hotels). Các Tour thuộc về các Destinations cụ thể.

**3.3.2. Thiết kế bảng dữ liệu**
Dưới đây là một số bảng cốt lõi của hệ thống:

**Bảng Users (Người dùng)**
| Tên cột | Kiểu dữ liệu | Khóa | Ghi chú |
|---|---|---|---|
| id | INT | PK | Khóa chính tự tăng |
| username | VARCHAR(50) | | Tên đăng nhập |
| password | VARCHAR(255) | | Mật khẩu mã hóa |
| face_data | LONGTEXT | | Lưu trữ vector khuôn mặt Face ID |
| role | VARCHAR(20) | | user hoặc admin |

**Bảng Tours (Danh mục Tour)**
| Tên cột | Kiểu dữ liệu | Khóa | Ghi chú |
|---|---|---|---|
| id | INT | PK | Khóa chính tự tăng |
| title | VARCHAR(255) | | Tên tour |
| price | DECIMAL(10,2) | | Giá tiền |
| destination_id | INT | FK | ID của bảng Destinations |
| is_featured | BOOLEAN | | Trạng thái Tour nổi bật |

### 3.4. Thiết kế giao diện
- **Giao diện trang chủ (`index.php`):** Nổi bật thanh công cụ tìm kiếm, hiển thị các điểm đến hot và các tour nổi bật (Featured Tours).
- **Giao diện đăng nhập / Face ID (`login.php`, `register-face.php`):** Khung camera hiện giữa màn hình để quét sinh trắc học.
- **Giao diện Quản lý Admin (`/admin`):** Sidebar bên trái, nội dung quản lý các bảng dữ liệu (CRUD) nằm bên phải dạng Table Grid.

**Tiểu kết chương 3:**
Chương 3 đã hoàn thành việc phân tích yêu cầu và thiết kế hệ thống bao gồm chức năng và cấu trúc CSDL. Kết quả thiết kế là cơ sở để tiến hành xây dựng và triển khai.

---

# CHƯƠNG 4. XÂY DỰNG VÀ TRIỂN KHAI HỆ THỐNG

### 4.1. Môi trường phát triển
**Phần cứng:**
- CPU: Intel Core i5 / AMD Ryzen 5 trở lên.
- RAM: 8GB trở lên.
- Ổ cứng: 256GB SSD.

**Phần mềm:**
- Hệ điều hành: Windows 10/11 hoặc macOS.
- IDE/Text Editor: Visual Studio Code.
- Môi trường Local Server: XAMPP / WAMP.
- Database: MySQL tích hợp trong XAMPP (phpMyAdmin).

### 4.2. Xây dựng cơ sở dữ liệu
- Thiết lập kết nối CSDL thông qua file `includes/db.php`.
- Hệ thống hỗ trợ xây dựng CSDL hoàn toàn tự động bằng các Script PHP (ví dụ: `create_combo_tables.php`, `create_hotel_tables.php`, `seed_hotels.php`, `seed_flights.php`). Người lập trình chỉ cần chạy các file seed để hệ thống tự động tạo cấu trúc bảng (schema) và chèn dữ liệu giả lập (mock data) để phục vụ kiểm thử.

### 4.3. Xây dựng các chức năng
- **Chức năng Giao dịch:** `cart.php` xử lý giỏ hàng session. `payment-gateway.php` xử lý luồng giả lập cổng thanh toán và lưu vào DB, xuất ra `invoice.php`.
- **Chức năng API Bất đồng bộ:** Sử dụng AJAX trong `voucher-center.php` gọi đến `api_spin_wheel.php` để xử lý vòng quay may mắn; gọi đến `chat_api.php` để xử lý hội thoại chatbot.
- **Chức năng Admin:** Xây dựng thư mục `/admin/` với các file như `delete-hotel.php`, `edit-guide.php`, `featured-tours.php` để thực hiện thao tác Thêm/Sửa/Xóa dữ liệu thông qua truy vấn `mysqli`.

### 4.4. Triển khai hệ thống
- Tải mã nguồn vào thư mục `htdocs` của XAMPP.
- Khởi động Apache và MySQL.
- Chạy các file `seed_*.php` để cài đặt dữ liệu ban đầu.
- Truy cập qua `http://localhost/travel-booking/`.

**Tiểu kết chương 4:**
Chương 4 đã trình bày quá trình xây dựng và triển khai hệ thống từ cơ sở dữ liệu đến các chức năng nghiệp vụ chính.

---

# CHƯƠNG 5. KẾT QUẢ THỰC NGHIỆM, ĐÁNH GIÁ VÀ HƯỚNG PHÁT TRIỂN

### 5.1. Mục tiêu thực nghiệm
Đánh giá hiệu quả hoạt động của hệ thống, phát hiện các lỗi logic (bug) trong luồng giao dịch, đảm bảo các API sinh trắc học và vòng quay hoạt động trơn tru.

### 5.2. Kịch bản thực nghiệm
Sử dụng phương pháp kiểm thử hộp đen (Blackbox Testing) để thử nghiệm hệ thống dưới góc nhìn người dùng thực tế. Tạo tài khoản mẫu, thử đặt tour, sử dụng voucher, và thử đăng nhập bằng Face ID với webcam.

### 5.3. Kết quả kiểm thử chức năng

| STT | Chức năng | Dữ liệu đầu vào | Kết quả mong đợi | Kết quả thực tế |
|---|---|---|---|---|
| 1 | Đăng nhập tài khoản | User hợp lệ | Chuyển hướng về trang chủ | Đạt |
| 2 | Đăng nhập tài khoản | Sai mật khẩu | Hiện thông báo báo lỗi | Đạt |
| 3 | Thêm Tour vào giỏ | Nhấn nút "Thêm vào giỏ" | Số lượng icon giỏ hàng tăng lên | Đạt |
| 4 | Nhận diện Face ID | Quét đúng khuôn mặt | Đăng nhập thành công | Đạt |
| 5 | Vòng quay may mắn | Nhấn nút "Quay" | Quay ngẫu nhiên, lưu voucher vào DB | Đạt |
| 6 | Thanh toán | Nhập mã Voucher | Tính lại tổng tiền sau khi giảm | Đạt |

**Nhận xét:**
Tất cả các chức năng cốt lõi đều hoạt động đúng theo logic yêu cầu của dự án.

### 5.4. Đánh giá hiệu năng
- **Thời gian phản hồi:** Tốc độ load các trang `.php` cực nhanh (< 1 giây) do không bị phụ thuộc vào các framework nặng.
- **API Bất đồng bộ:** Vòng quay may mắn phản hồi kết quả gần như tức thì mà không cần phải reload lại trang.

### 5.5. Đánh giá ưu điểm và hạn chế
**5.5.1. Ưu điểm**
- Giao diện thân thiện, chuẩn Responsive, màu sắc bắt mắt.
- Tích hợp thành công các công nghệ mới (Nhận diện khuôn mặt Face ID) vào nền tảng PHP cổ điển.
- Quản lý dữ liệu thông minh qua cấu trúc thư mục rõ ràng và các script tự động gen dữ liệu.
- Phân tách riêng rẽ luồng logic giữa khách sạn, chuyến bay và tour.

**5.5.2. Hạn chế**
- Do sử dụng PHP thuần, nếu số lượng file và tính năng tiếp tục tăng lên, việc bảo trì (maintenance) có thể gặp khó khăn do thiếu kiến trúc MVC tiêu chuẩn.
- Thanh toán hiện tại vẫn đang ở dạng giả lập (Test Gateway) chứ chưa kết nối API của các bên ngân hàng thực (Momo, VNPay).

### 5.6. Hướng phát triển
- Tích hợp các cổng thanh toán điện tử thực tế như VNPay, ZaloPay, MoMo.
- Nâng cấp dự án sang sử dụng framework (ví dụ Laravel) để tối ưu luồng xử lý và nâng cao bảo mật.
- Triển khai (Deploy) dự án lên Cloud Server (AWS, Digital Ocean) thay vì chạy Localhost.
- Tích hợp thêm AI cho hệ thống Gợi ý Tour (Recommendation System) dựa trên lịch sử mua hàng của khách hàng.

**Tiểu kết chương 5:**
Kết quả thực nghiệm cho thấy hệ thống hoạt động ổn định và đáp ứng các mục tiêu đề ra. Tuy nhiên vẫn còn một số hạn chế nhỏ cần được cải thiện trong tương lai.

---

## KẾT LUẬN
Đồ án đã hoàn thành các mục tiêu đề ra: Xây dựng thành công hệ thống Đặt chỗ và Quản lý Dịch vụ Du lịch toàn diện. Hệ thống không chỉ đáp ứng tốt yêu cầu đặt dịch vụ cơ bản mà còn tiên phong tích hợp các tính năng công nghệ nâng cao trải nghiệm người dùng. Kết quả đạt được là nền tảng vững chắc để tiếp tục nghiên cứu và phát triển sản phẩm thương mại hóa trong tương lai.

---

## TÀI LIỆU THAM KHẢO
[1] Kevin Tatroe, Peter MacIntyre (2020), *Programming PHP: Creating Dynamic Web Pages*, O'Reilly Media.
[2] Luke Welling, Laura Thomson (2016), *PHP and MySQL Web Development*, Addison-Wesley Professional.
[3] Trang chủ thư viện Bootstrap: *https://getbootstrap.com/*
[4] Tài liệu tham khảo API Nhận diện khuôn mặt (Face-API JS).

---

## PHỤ LỤC
**Phụ lục A. Hướng dẫn cài đặt**
1. Cài đặt XAMPP, bật module Apache và MySQL.
2. Clone/Copy mã nguồn vào thư mục `C:\xampp\htdocs\travel-booking`.
3. Tạo cơ sở dữ liệu `travel_booking` trên phpMyAdmin.
4. Chạy các file `seed_*.php` thông qua trình duyệt để tự động tạo cấu trúc bảng và dữ liệu mẫu.
5. Đăng nhập Admin và kiểm tra hệ thống.

**Phụ lục B. Hình ảnh kết quả thực nghiệm**
*(Sinh viên dán hình ảnh kết quả thực thi các màn hình tại phần này trong file Word)*.
