<?php
class SinhVien {
    private $db;

    public function __construct() {
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll($limit, $offset) {
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv 
                 JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                 LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal() {
        $query = "SELECT COUNT(*) as total FROM SinhVien";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getById($id) {
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv 
                 JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                 WHERE sv.MaSV = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh, Password) 
                 VALUES (:MaSV, :HoTen, :GioiTinh, :NgaySinh, :Hinh, :MaNganh, :Password)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':MaSV' => $data['MaSV'],
            ':HoTen' => $data['HoTen'],
            ':GioiTinh' => $data['GioiTinh'],
            ':NgaySinh' => $data['NgaySinh'],
            ':Hinh' => $data['Hinh'],
            ':MaNganh' => $data['MaNganh'],
            ':Password' => $data['Password']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE SinhVien SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, 
                 Hinh = :Hinh, MaNganh = :MaNganh WHERE MaSV = :MaSV";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':MaSV' => $id,
            ':HoTen' => $data['HoTen'],
            ':GioiTinh' => $data['GioiTinh'],
            ':NgaySinh' => $data['NgaySinh'],
            ':Hinh' => $data['Hinh'],
            ':MaNganh' => $data['MaNganh']
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM SinhVien WHERE MaSV = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // Lấy danh sách ngành học
    public function getNganhHoc() {
        $query = "SELECT * FROM NganhHoc";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}