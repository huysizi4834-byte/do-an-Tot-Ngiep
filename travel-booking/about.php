<?php
session_start();
include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="fw-bold mb-4 text-primary">Về THEGIOI Travel</h1>
            <p class="fs-5 text-muted mb-4">Chúng tôi là đơn vị lữ hành hàng đầu, mang đến những trải nghiệm du lịch tuyệt vời và đáng nhớ nhất cho mọi khách hàng.</p>
            <p class="text-secondary">Được thành lập với niềm đam mê khám phá thế giới, THEGIOI Travel không ngừng nỗ lực để cung cấp các dịch vụ du lịch trọn gói, đặt phòng khách sạn, vé máy bay và các tiện ích du lịch với chất lượng cao nhất. Đội ngũ chuyên gia của chúng tôi luôn tận tâm thiết kế những hành trình độc đáo, phù hợp với sở thích và ngân sách của bạn.</p>
            <div class="row mt-4">
                <div class="col-sm-6 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-earth-americas fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">10,000+</h4>
                            <small class="text-muted">Chuyến đi thành công</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-users fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">50,000+</h4>
                            <small class="text-muted">Khách hàng tin tưởng</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="About Us" class="img-fluid rounded-4 shadow-lg w-100" style="height: 450px; object-fit: cover;">
        </div>
    </div>

    <div class="row text-center mt-5 pt-5 border-top">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">Tại sao chọn chúng tôi?</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="fa-solid fa-hand-holding-dollar text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold">Giá Cả Cạnh Tranh</h5>
                    <p class="text-muted">Chúng tôi cam kết mang đến mức giá tốt nhất cùng những chương trình khuyến mãi hấp dẫn nhất trên thị trường.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="fa-solid fa-user-shield text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold">An Toàn & Tin Cậy</h5>
                    <p class="text-muted">Mọi chuyến đi đều được bảo hiểm đầy đủ, đối tác uy tín, đảm bảo an toàn tuyệt đối cho khách hàng.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="fa-solid fa-headset text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
                    <p class="text-muted">Đội ngũ tổng đài viên và chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn bất cứ lúc nào, bất cứ nơi đâu.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
