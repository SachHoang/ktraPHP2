<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Đăng nhập - Hệ thống đăng ký học phần</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional: Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Link đến file CSS tùy chỉnh của bạn (đặt SAU Bootstrap) -->
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        html, body {
            height: 100%; /* Cần thiết để căn giữa theo chiều dọc */
        }
        body {
            display: flex;
            flex-direction: column; /* Cho phép footer dính xuống dưới */
            background-color: #f8f9fa; /* Màu nền nhẹ nhàng */
            /* Optional: Thêm background image nếu muốn */
            /* background-image: url('path/to/your/background.jpg'); */
            /* background-size: cover; */
            /* background-position: center; */
        }
        .main-content {
            flex: 1 0 auto; /* Quan trọng để đẩy footer xuống */
            display: flex;
            align-items: center; /* Căn giữa form theo chiều dọc */
            justify-content: center; /* Căn giữa form theo chiều ngang */
            padding: 20px 0; /* Thêm padding trên/dưới */
        }
        .login-card {
            width: 100%;
            max-width: 400px; /* Giới hạn chiều rộng tối đa của card */
            border: none; /* Bỏ border mặc định của card */
            border-radius: 0.5rem; /* Bo góc mềm mại hơn */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); /* Đổ bóng rõ hơn */
        }
        .login-card .card-header {
            background-color: #007bff; /* Màu xanh dương chủ đạo */
            color: white;
            border-bottom: none;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            padding: 1.5rem; /* Tăng padding header */
        }
         .login-card .card-header h2 {
            margin-bottom: 0; /* Bỏ margin dưới của h2 */
            font-weight: 300; /* Chữ mỏng hơn một chút */
         }
        .login-card .card-body {
            padding: 2rem; /* Tăng padding body */
        }
        .form-control-lg {
             height: calc(1.5em + 1rem + 2px); /* Làm input cao hơn */
        }
        .input-group-text {
             background-color: #e9ecef; /* Màu nền nhẹ cho icon */
             border: 1px solid #ced4da;
        }
        .btn-login {
            padding: 0.75rem 1.25rem; /* Làm nút to hơn */
            font-size: 1rem;
            font-weight: 500;
        }
        .login-footer {
            flex-shrink: 0; /* Ngăn footer co lại */
            background-color: transparent; /* Bỏ nền tối */
            color: #6c757d; /* Màu text xám mờ */
            padding: 1.5rem 0;
            font-size: 0.9em;
        }
        /* Style cho thông báo lỗi */
        .alert-login-error {
             background-color: #f8d7da;
             color: #721c24;
             border-color: #f5c6cb;
             padding: 0.75rem 1.25rem;
             margin-bottom: 1rem;
             border: 1px solid transparent;
             border-radius: 0.25rem;
        }

    </style>
</head>
<body>
    <div class="container main-content">
        <div class="col-lg-5 col-md-7 col-sm-9"> <!-- Điều chỉnh cột để phù hợp hơn -->
            <div class="card login-card">
                <div class="card-header text-center">
                    <h2>
                        <i class="fas fa-user-lock mr-2"></i> Đăng nhập hệ thống
                    </h2>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-login-error text-center" role="alert">
                            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php?controller=auth&action=login"> <!-- Thêm action rõ ràng -->
                        <div class="form-group mb-3">
                            <label for="MaSV" class="sr-only">Mã Sinh viên</label> <!-- sr-only ẩn label nhưng giữ cho screen reader -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="MaSV" id="MaSV" placeholder="Nhập Mã sinh viên" required autofocus> <!-- Thêm placeholder, autofocus -->
                            </div>
                        </div>
                        <div class="form-group mb-4">
                             <label for="Password" class="sr-only">Mật khẩu</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control form-control-lg" name="Password" id="Password" placeholder="Nhập Mật khẩu" required>
                            </div>
                             <!-- Optional: Thêm link quên mật khẩu -->
                             <!-- <div class="text-right mt-2">
                                 <a href="#" class="small text-muted">Quên mật khẩu?</a>
                             </div> -->
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block btn-login">
                            <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
                        </button>
                         <!-- Optional: Thêm link đăng ký nếu có -->
                         <!-- <p class="text-center mt-4 small">Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a></p> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center login-footer">
        <p class="mb-0">© <?php echo date("Y"); ?> Hệ thống đăng ký học phần. Phát triển bởi [Tên của bạn/Nhóm].</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>