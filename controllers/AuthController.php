<?php
class AuthController {
    private $model;

    public function __construct() {
        require_once 'models/SinhVien.php';
        $this->model = new SinhVien();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['MaSV'];
            $password = $_POST['Password'];
            $user = $this->model->getById($maSV);
            
            if ($user && $password === $user['Password']) { // So sánh trực tiếp
                $_SESSION['user'] = $user;
                header("Location: index.php?controller=hocphan&action=index");
            } else {
                $error = "Sai mã sinh viên hoặc mật khẩu!";
            }
        }
        require_once 'views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
    }
}