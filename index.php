<?php
session_start();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$maDK = isset($_GET['maDK']) ? $_GET['maDK'] : null;
$maHP = isset($_GET['maHP']) ? $_GET['maHP'] : null;

switch ($controller) {
    case 'sinhvien':
        require_once 'controllers/SinhVienController.php';
        $controller = new SinhVienController();
        break;
    case 'hocphan':
        require_once 'controllers/HocPhanController.php';
        $controller = new HocPhanController();
        break;
    case 'auth':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        break;
}

if (method_exists($controller, $action)) {
    if ($action == 'deleteRegistered') {
        $controller->$action($maDK, $maHP);
    } elseif (isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    echo "404 - Page not found";
}