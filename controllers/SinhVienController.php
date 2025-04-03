<?php
class SinhVienController {
    private $model;

    public function __construct() {
        require_once 'models/SinhVien.php';
        $this->model = new SinhVien();
    }

    public function index() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 4;
        $offset = ($page - 1) * $limit;
        $sinhviens = $this->model->getAll($limit, $offset);
        $total = $this->model->getTotal();
        $totalPages = ceil($total / $limit);
        require_once 'views/sinhvien/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->create($_POST);
            header("Location: index.php?controller=sinhvien&action=index");
        }
        require_once 'views/sinhvien/create.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->update($id, $_POST);
            header("Location: index.php?controller=sinhvien&action=index");
        }
        $sinhvien = $this->model->getById($id);
        $nganhhocs = $this->model->getNganhHoc(); // Lấy danh sách ngành học để hiển thị trong form
        require_once 'views/sinhvien/edit.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?controller=sinhvien&action=index");
    }

    public function detail($id) {
        $sinhvien = $this->model->getById($id);
        require_once 'views/sinhvien/detail.php';
    }
}