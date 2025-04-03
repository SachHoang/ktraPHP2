<!DOCTYPE html>
<html lang="vi"> <!-- Đổi lang thành tiếng Việt -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"> <!-- Thêm shrink-to-fit=no -->
    <title><?php echo isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Hệ thống đăng ký học phần'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional: Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Link đến file CSS tùy chỉnh của bạn (đặt SAU Bootstrap) -->
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        /* Optional: Thêm CSS tùy chỉnh nhẹ nhàng nếu cần */
        body {
            padding-top: 70px; /* Thêm padding top để nội dung không bị che bởi navbar fixed-top */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Đảm bảo footer dính xuống dưới */
        }
        .main-content {
            flex: 1; /* Đẩy footer xuống dưới */
        }
        .navbar-brand strong {
            letter-spacing: 0.5px;
        }
        .footer {
             background-color: #343a40; /* Màu nền giống navbar cũ */
             color: white;
             padding: 1rem 0;
             text-align: center;
             /* mt-auto sẽ đẩy nó xuống dưới nếu body dùng flex */
        }
        /* Làm nổi bật link active (Cần thêm logic PHP để thêm class 'active') */
        .navbar-nav .nav-item .nav-link.active {
            font-weight: bold;
            color: #007bff !important; /* Màu xanh dương mặc định của Bootstrap */
        }
    </style>
</head>
<body>
    <!-- Navbar được thiết kế lại -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm fixed-top">
        <!-- fixed-top: Giữ navbar luôn ở trên cùng khi cuộn -->
        <!-- bg-light: Nền sáng -->
        <!-- border-bottom shadow-sm: Thêm đường viền dưới và bóng mờ nhẹ -->
        <div class="container"> <!-- Bọc nội dung navbar trong container để căn giữa và giới hạn chiều rộng -->
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap mr-2"></i> <!-- Icon Font Awesome (tùy chọn) -->
                <strong>Hệ thống ĐKHP</strong> <!-- In đậm tên -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto"> <!-- mr-auto đẩy các mục bên phải ra xa -->
                    <li class="nav-item">
                        <!-- Ví dụ thêm class active (cần logic PHP để xác định trang hiện tại) -->
                        <?php $isSinhVienActive = (isset($_GET['controller']) && $_GET['controller'] == 'sinhvien'); ?>
                        <a class="nav-link <?php echo $isSinhVienActive ? 'active' : ''; ?>" href="index.php?controller=sinhvien&action=index">
                            <i class="fas fa-users mr-1"></i> Quản lý sinh viên
                        </a>
                    </li>
                    <li class="nav-item">
                         <?php $isHocPhanActive = (isset($_GET['controller']) && $_GET['controller'] == 'hocphan' && isset($_GET['action']) && $_GET['action'] == 'index'); ?>
                        <a class="nav-link <?php echo $isHocPhanActive ? 'active' : ''; ?>" href="index.php?controller=hocphan&action=index">
                            <i class="fas fa-edit mr-1"></i> Đăng ký học phần
                        </a>
                    </li>
                    <li class="nav-item">
                         <?php $isRegisteredActive = (isset($_GET['controller']) && $_GET['controller'] == 'hocphan' && isset($_GET['action']) && $_GET['action'] == 'registered'); ?>
                        <a class="nav-link <?php echo $isRegisteredActive ? 'active' : ''; ?>" href="index.php?controller=hocphan&action=registered">
                            <i class="fas fa-check-circle mr-1"></i> Đã đăng ký
                        </a>
                    </li>
                </ul>
                <!-- Phần thông tin người dùng và đăng xuất -->
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user']['HoTen'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle mr-1"></i> <!-- Icon người dùng -->
                                <?php echo htmlspecialchars($_SESSION['user']['HoTen'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <!-- Thêm các link khác nếu cần (vd: Hồ sơ, Cài đặt) -->
                                <!-- <a class="dropdown-item" href="#">Hồ sơ</a> -->
                                <!-- <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="index.php?controller=auth&action=logout">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
                                </a>
                            </div>
                        </li>
                    <?php else: ?>
                        <!-- Hiển thị nút Đăng nhập nếu chưa đăng nhập -->
                        <li class="nav-item">
                             <a class="nav-link" href="index.php?controller=auth&action=login">
                                 <i class="fas fa-sign-in-alt mr-1"></i> Đăng nhập
                             </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div> <!-- /.collapse -->
        </div> <!-- /.container -->
    </nav>

    <!-- Phần nội dung chính của trang -->
    <!-- Đảm bảo container này nằm ngoài <nav> -->
    <div class="container main-content mt-4">
