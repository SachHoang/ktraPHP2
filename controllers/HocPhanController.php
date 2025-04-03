<?php
class HocPhanController {
    private $model;

    public function __construct() {
        require_once 'models/HocPhan.php';
        $this->model = new HocPhan();
    }

    public function index() {
        $hocphans = $this->model->getAll();
        require_once 'views/hocphan/index.php';
    }

    public function cart() {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['add'])) {
                $maHP = $_POST['MaHP'];
                if (!in_array($maHP, $_SESSION['cart'])) {
                    $_SESSION['cart'][] = $maHP;
                }
            } elseif (isset($_POST['remove'])) {
                $maHP = $_POST['MaHP'];
                $_SESSION['cart'] = array_diff($_SESSION['cart'], [$maHP]);
            } elseif (isset($_POST['clear'])) {
                $_SESSION['cart'] = [];
            } elseif (isset($_POST['save'])) {
                $this->model->saveRegistration($_SESSION['user']['MaSV'], $_SESSION['cart']);
                $_SESSION['cart'] = [];
                $_SESSION['message'] = "Đăng ký thành công!";
                header("Location: index.php?controller=hocphan&action=registered");
                exit();
            }
        }
        
        $cartItems = $this->model->getCartItems($_SESSION['cart']);
        require_once 'views/hocphan/cart.php';
    }

    public function registered() {

        $registeredCourses = $this->model->getRegisteredCourses($_SESSION['user']['MaSV']);
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        unset($_SESSION['message']);
        require_once 'views/hocphan/registered.php';
    }

    // Xóa học phần đã đăng ký
    public function deleteRegistered($maDK, $maHP) {
        session_start();
        $this->model->deleteRegistration($maDK, $maHP);
        $_SESSION['message'] = "Đã xóa học phần thành công!";
        header("Location: index.php?controller=hocphan&action=registered");
    }
}