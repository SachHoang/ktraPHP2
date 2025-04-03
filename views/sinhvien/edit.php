<?php 
$title = "Sửa thông tin sinh viên";
require_once 'views/layout/header.php'; 
?>

<h1>Sửa thông tin sinh viên</h1>
<form method="post">
    <div class="form-group">
        <label for="MaSV">Mã SV:</label>
        <input type="text" class="form-control" name="MaSV" id="MaSV" value="<?php echo $sinhvien['MaSV']; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="HoTen">Họ Tên:</label>
        <input type="text" class="form-control" name="HoTen" id="HoTen" value="<?php echo $sinhvien['HoTen']; ?>" required>
    </div>
    <div class="form-group">
        <label for="GioiTinh">Giới Tính:</label>
        <select class="form-control" name="GioiTinh" id="GioiTinh">
            <option value="Nam" <?php if ($sinhvien['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
            <option value="Nữ" <?php if ($sinhvien['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
        </select>
    </div>
    <div class="form-group">
        <label for="NgaySinh">Ngày Sinh:</label>
        <input type="date" class="form-control" name="NgaySinh" id="NgaySinh" value="<?php echo $sinhvien['NgaySinh']; ?>" required>
    </div>
    <div class="form-group">
        <label for="Hinh">Hình:</label>
        <input type="text" class="form-control" name="Hinh" id="Hinh" value="<?php echo $sinhvien['Hinh']; ?>" placeholder="/images/sv.jpg">
    </div>
    <div class="form-group">
        <label for="MaNganh">Ngành học:</label>
        <select class="form-control" name="MaNganh" id="MaNganh">
            <?php foreach ($nganhhocs as $nganh): ?>
                <option value="<?php echo $nganh['MaNganh']; ?>" <?php if ($sinhvien['MaNganh'] == $nganh['MaNganh']) echo 'selected'; ?>>
                    <?php echo $nganh['TenNganh']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>