<?php 
$title = "Thêm sinh viên";
require_once 'views/layout/header.php'; 
?>

<h1>Thêm sinh viên</h1>
<form method="post">
    <div class="form-group">
        <label for="MaSV">Mã SV:</label>
        <input type="text" class="form-control" name="MaSV" id="MaSV" required>
    </div>
    <div class="form-group">
        <label for="HoTen">Họ Tên:</label>
        <input type="text" class="form-control" name="HoTen" id="HoTen" required>
    </div>
    <div class="form-group">
        <label for="GioiTinh">Giới Tính:</label>
        <select class="form-control" name="GioiTinh" id="GioiTinh">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
    </div>
    <div class="form-group">
        <label for="NgaySinh">Ngày Sinh:</label>
        <input type="date" class="form-control" name="NgaySinh" id="NgaySinh" required>
    </div>
    <div class="form-group">
        <label for="Hinh">Hình:</label>
        <input type="text" class="form-control" name="Hinh" id="Hinh" placeholder="/images/sv.jpg">
    </div>
    <div class="form-group">
        <label for="MaNganh">Ngành học:</label>
        <select class="form-control" name="MaNganh" id="MaNganh">
            <?php 
            $nganhhocs = (new SinhVien())->getNganhHoc(); 
            foreach ($nganhhocs as $nganh): ?>
                <option value="<?php echo $nganh['MaNganh']; ?>">
                    <?php echo $nganh['TenNganh']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="Password">Mật khẩu:</label>
        <input type="password" class="form-control" name="Password" id="Password" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>