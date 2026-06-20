<?php
$page_title = "Chi tiết Liên hệ";
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: contacts.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch contact details
$sql = "SELECT * FROM contacts WHERE id = $id";
$result = mysqli_query($conn, $sql);
$contact = mysqli_fetch_assoc($result);

if (!$contact) {
    header("Location: contacts.php");
    exit();
}

// Mark as read if it is new
if ($contact['status'] == 'new') {
    mysqli_query($conn, "UPDATE contacts SET status = 'read' WHERE id = $id");
    $contact['status'] = 'read';
}

// Handle mark as resolved
if (isset($_POST['mark_resolved'])) {
    mysqli_query($conn, "UPDATE contacts SET status = 'resolved' WHERE id = $id");
    $contact['status'] = 'resolved';
}

// Handle send reply
if (isset($_POST['send_reply'])) {
    $reply = mysqli_real_escape_string($conn, trim($_POST['admin_reply']));
    mysqli_query($conn, "UPDATE contacts SET admin_reply = '$reply', status = 'resolved' WHERE id = $id");
    $contact['admin_reply'] = $_POST['admin_reply'];
    $contact['status'] = 'resolved';
}

include 'includes/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold">Chi tiết Tin nhắn Liên hệ</h2>
    <a href="contacts.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại danh sách</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold mb-1"><?= htmlspecialchars($contact['subject']) ?></h4>
                        <p class="text-muted mb-0">Gửi lúc: <?= date('H:i d/m/Y', strtotime($contact['created_at'])) ?></p>
                    </div>
                    <?php if ($contact['status'] == 'read'): ?>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">Đã đọc</span>
                    <?php else: ?>
                        <span class="badge bg-success px-3 py-2 rounded-pill">Đã xử lý</span>
                    <?php endif; ?>
                </div>

                <div class="bg-light p-4 rounded-3 mb-4" style="white-space: pre-line;">
                    <?= htmlspecialchars($contact['message']) ?>
                </div>

                <?php if (!empty($contact['admin_reply'])): ?>
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-reply-fill text-primary"></i> Phản hồi từ Admin</h5>
                        <div class="bg-primary bg-opacity-10 p-4 rounded-3 border border-primary border-opacity-25" style="white-space: pre-line;">
                            <?= htmlspecialchars($contact['admin_reply']) ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-5">
                        <h5 class="fw-bold mb-3">Trả lời Khách hàng</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <textarea class="form-control" name="admin_reply" rows="5" required placeholder="Nhập nội dung trả lời cho khách hàng..."></textarea>
                                <small class="text-muted d-block mt-2"><i class="bi bi-info-circle"></i> Nội dung này sẽ được lưu lại trong hệ thống và gửi email cho khách (nếu có cấu hình gửi mail).</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="send_reply" class="btn btn-primary fw-bold px-4"><i class="bi bi-send"></i> Gửi trả lời & Đánh dấu xử lý</button>
                                <?php if ($contact['status'] != 'resolved'): ?>
                                    <button type="submit" name="mark_resolved" class="btn btn-outline-success fw-bold px-4"><i class="bi bi-check-circle"></i> Chỉ đánh dấu đã xử lý</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold">Thông tin Khách hàng</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Họ và tên</label>
                    <span class="fs-5 fw-medium"><?= htmlspecialchars($contact['name']) ?></span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold d-block">Số điện thoại</label>
                    <span class="fs-5 fw-medium"><?= htmlspecialchars($contact['phone']) ?></span>
                </div>
                <div class="mb-0">
                    <label class="text-muted small fw-bold d-block">Email</label>
                    <span class="fs-5 fw-medium"><?= htmlspecialchars($contact['email']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
