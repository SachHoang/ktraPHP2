<?php
class HocPhan {
    private $db;

    public function __construct() {
        require_once 'config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM HocPhan WHERE SoLuongDuKien > 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartItems($cart) {
        if (empty($cart)) return [];
        $placeholders = str_repeat('?,', count($cart) - 1) . '?';
        $query = "SELECT * FROM HocPhan WHERE MaHP IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($cart);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveRegistration($maSV, $cart) {
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (CURDATE(), :MaSV)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':MaSV' => $maSV]);
            $maDK = $this->db->lastInsertId();

            foreach ($cart as $maHP) {
                $query = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (:MaDK, :MaHP)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':MaDK' => $maDK, ':MaHP' => $maHP]);

                $query = "UPDATE HocPhan SET SoLuongDuKien = SoLuongDuKien - 1 WHERE MaHP = :MaHP";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':MaHP' => $maHP]);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getRegisteredCourses($maSV) {
        $query = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi, dk.MaDK, dk.NgayDK 
                  FROM HocPhan hp 
                  JOIN ChiTietDangKy ctdk ON hp.MaHP = ctdk.MaHP 
                  JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                  WHERE dk.MaSV = :MaSV";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':MaSV', $maSV);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa một học phần đã đăng ký
    public function deleteRegistration($maDK, $maHP) {
        $this->db->beginTransaction();
        try {
            // Xóa chi tiết đăng ký
            $query = "DELETE FROM ChiTietDangKy WHERE MaDK = :MaDK AND MaHP = :MaHP";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':MaDK' => $maDK, ':MaHP' => $maHP]);

            // Tăng lại số lượng dự kiến
            $query = "UPDATE HocPhan SET SoLuongDuKien = SoLuongDuKien + 1 WHERE MaHP = :MaHP";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':MaHP' => $maHP]);

            // Kiểm tra xem MaDK còn học phần nào không, nếu không thì xóa luôn MaDK
            $query = "SELECT COUNT(*) as count FROM ChiTietDangKy WHERE MaDK = :MaDK";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':MaDK' => $maDK]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($count == 0) {
                $query = "DELETE FROM DangKy WHERE MaDK = :MaDK";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':MaDK' => $maDK]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}