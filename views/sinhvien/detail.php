<?php 
$title = "Chi tiết sinh viên";
require_once 'views/layout/header.php'; 
?>

<h1>Chi tiết sinh viên</h1>
<table class="table table-bordered">
    <tr>
        <th>Mã SV</th>
        <td><?php echo $sinhvien['MaSV']; ?></td>
    </tr>
    <tr>
        <th>Họ Tên</th>
        <td><?php echo $sinhvien['HoTen']; ?></td>
    </tr>
    <tr>
        <th>Giới Tính</th>
        <td><?php echo $sinhvien['GioiTinh']; ?></td>
    </tr>
    <tr>
        <th>Ngày Sinh</th>
        <td><?php echo $sinhvien['NgaySinh']; ?></td>
    </tr>
    <tr>
        <th>Ngành</th>
        <td><?php echo $sinhvien['TenNganh']; ?></td>
    </tr>
    <tr>
        <th>Hình</th>
        <td><img src="<?php echo $sinhvien['Hinh']; ?>" alt="Hình sinh viên" width="100"></td>
    </tr>
</table>
<a href="index.php?controller=sinhvien&action=index" class="btn btn-primary">Quay lại</a>

<?php require_once 'views/layout/footer.php'; ?>