<?php
// models/CertificateOrder.php

class CertificateOrder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Read all certificate orders
    public function getAllOrders()
    {
        $sql = "SELECT * FROM cc_certificate_order";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Create a new certificate order
    public function createOrder($created_by, $course_code, $mobile, $address_line1, $address_line2, $city_id, $district, $type, $payment, $package_id, $certificate_id, $certificate_status, $cod_amount, $is_active)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO cc_certificate_order (created_by, course_code, mobile, address_line1, address_line2, city_id,district, type, payment, package_id, certificate_id, certificate_status, cod_amount, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
        ");
        $stmt->execute([$created_by, $course_code, $mobile, $address_line1, $address_line2, $city_id, $district, $type, $payment, $package_id, $certificate_id, $certificate_status, $cod_amount, $is_active]);

        $order_id = $this->pdo->lastInsertId();
        return $order_id;
    }



    // Read a single certificate order by ID
    public function getOrderById($order_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cc_certificate_order WHERE id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Read a single certificate order by Certificate ID
    public function getOrderByCertificateId($certificate_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cc_certificate_order WHERE certificate_id = ?");
        $stmt->execute([$certificate_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a certificate order
    public function updateOrder($order_id, $created_by, $course_code, $mobile, $address_line1, $address_line2, $city_id, $district, $type, $payment, $package_id, $certificate_id, $certificate_status, $cod_amount, $is_active)
    {
        $stmt = $this->pdo->prepare("
            UPDATE cc_certificate_order 
            SET created_by = ?, course_code = ?, mobile = ?, address_line1 = ?, address_line2 = ?, city_id = ?,district=?, type = ?, payment = ?, package_id = ?, certificate_id = ?, certificate_status = ?, cod_amount = ?, is_active = ?
            WHERE id = ?
        ");
        return $stmt->execute([$created_by, $course_code, $mobile, $address_line1, $address_line2, $city_id, $district, $type, $payment, $package_id, $certificate_id, $certificate_status, $cod_amount, $is_active, $order_id]);
    }

    // Delete a certificate order
    public function deleteOrder($order_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cc_certificate_order WHERE id = ?");
        return $stmt->execute([$order_id]);
    }

    // Validate duplicate order by Certificate ID
    public function validateDuplicate($certificate_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cc_certificate_order WHERE certificate_id = ?");
        $stmt->execute([$certificate_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
