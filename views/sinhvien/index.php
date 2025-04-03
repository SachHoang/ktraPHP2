<?php
$title = "Danh sách sinh viên";
require_once 'views/layout/header.php'; // Đảm bảo header đã được cập nhật như yêu cầu trước đó
?>

<div class="container mt-4 main-content"> <!-- Sử dụng container từ header/footer và class main-content -->

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Danh sách sinh viên</h1>
        <a href="index.php?controller=sinhvien&action=create" class="btn btn-primary">
            <i class="fas fa-user-plus mr-2"></i>Thêm sinh viên mới
        </a>
    </div>

    <?php
    // (Tùy chọn) Hiển thị thông báo thành công/lỗi nếu có từ controller
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . ($_SESSION['message_type'] ?? 'success') . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION['message'];
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
        echo '</div>';
        unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
        unset($_SESSION['message_type']);
    }
    ?>

    <div class="card shadow-sm"> <!-- Bọc bảng trong card để có nền và bóng mờ -->
        <div class="card-body">
            <div class="table-responsive"> <!-- Quan trọng cho màn hình nhỏ -->
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead class="thead-light text-center"> <!-- Header nền sáng, chữ căn giữa -->
                        <tr>
                            <th scope="col" style="width: 10%;">Mã SV</th>
                            <th scope="col">Họ Tên</th>
                            <th scope="col" style="width: 10%;">Giới Tính</th>
                            <th scope="col" style="width: 15%;">Ngày Sinh</th>
                            <th scope="col">Ngành</th>
                            <th scope="col" style="width: 20%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sinhviens)): ?>
                            <?php foreach ($sinhviens as $sv): ?>
                            <tr>
                                <td class="text-center align-middle"><?php echo htmlspecialchars($sv['MaSV'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($sv['HoTen'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center align-middle"><?php echo htmlspecialchars($sv['GioiTinh'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center align-middle">
                                    <?php
                                    // Định dạng lại ngày sinh cho dễ đọc (dd/mm/yyyy)
                                    try {
                                        $date = new DateTime($sv['NgaySinh']);
                                        echo $date->format('d/m/Y');
                                    } catch (Exception $e) {
                                        echo htmlspecialchars($sv['NgaySinh'], ENT_QUOTES, 'UTF-8'); // Hiển thị như cũ nếu lỗi
                                    }
                                    ?>
                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($sv['TenNganh'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center align-middle text-nowrap"> <!-- text-nowrap tránh nút xuống dòng -->
                                    <a href="index.php?controller=sinhvien&action=detail&id=<?php echo htmlspecialchars($sv['MaSV'], ENT_QUOTES, 'UTF-8'); ?>"
                                       class="btn btn-info btn-sm mr-1" title="Chi tiết">
                                       <i class="fas fa-eye"></i> <!-- Icon xem -->
                                    </a>
                                    <a href="index.php?controller=sinhvien&action=edit&id=<?php echo htmlspecialchars($sv['MaSV'], ENT_QUOTES, 'UTF-8'); ?>"
                                       class="btn btn-warning btn-sm mr-1" title="Sửa">
                                       <i class="fas fa-edit"></i> <!-- Icon sửa -->
                                    </a>
                                    <a href="index.php?controller=sinhvien&action=delete&id=<?php echo htmlspecialchars($sv['MaSV'], ENT_QUOTES, 'UTF-8'); ?>"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên \'<?php echo htmlspecialchars(addslashes($sv['HoTen']), ENT_QUOTES, 'UTF-8'); ?>\' (<?php echo htmlspecialchars($sv['MaSV'], ENT_QUOTES, 'UTF-8'); ?>)? Thao tác này không thể hoàn tác!')"
                                       class="btn btn-danger btn-sm" title="Xóa">
                                       <i class="fas fa-trash-alt"></i> <!-- Icon xóa -->
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle mr-2"></i>Không tìm thấy sinh viên nào.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.card-body -->

        <?php if (!empty($sinhviens) && isset($totalPages) && $totalPages > 1): ?>
        <div class="card-footer bg-light d-flex justify-content-center">
             <!-- Phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <?php
                    // Nút Previous (Trang trước) - (Tùy chọn)
                    $prevPage = $page - 1;
                    if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?controller=sinhvien&action=index&page=<?php echo $prevPage; ?>" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                             <span class="page-link" aria-hidden="true">«</span>
                        </li>
                    <?php endif; ?>

                    <?php // Hiển thị các trang
                    for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?controller=sinhvien&action=index&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                                <?php if ($page == $i): ?> <span class="sr-only">(current)</span><?php endif; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Nút Next (Trang sau) - (Tùy chọn)
                    $nextPage = $page + 1;
                    if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?controller=sinhvien&action=index&page=<?php echo $nextPage; ?>" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">»</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div><!-- /.card-footer -->
        <?php endif; ?>
    </div><!-- /.card -->

</div> <!-- /.container -->

<?php require_once 'views/layout/footer.php'; ?>

<?php
// Thêm đoạn script nhỏ này vào cuối (hoặc trong footer.php) nếu bạn dùng tooltip
// Cần đảm bảo Popper.js được load trước Bootstrap JS (như trong header/footer mẫu)
?>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip() // Kích hoạt tooltip nếu bạn dùng title cho icon
})
</script>