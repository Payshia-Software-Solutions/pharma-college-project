<?php
// models/CertificationCenter/CcCertificateOrder.php

class CcCertificateOrder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllOrders()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_certificate_order`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_certificate_order` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getUserAddress($userId)
    {
        $stmt = $this->pdo->prepare("SELECT `address_line_1`, `address_line_2` FROM `user_full_details` WHERE `id` = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function createOrder($data)
    {
        // Fetch address from user details
        $userAddress = $this->getUserAddress($data['created_by']);

        // Assign address lines to the order data
        $data['address_line1'] = $userAddress['address_line1'];
        $data['address_line2'] = $userAddress['address_line2'];

        // Prepare and execute the insert statement
        $stmt = $this->pdo->prepare("INSERT INTO `cc_certificate_order` (`created_by`, `created_at`, `updated_at`, `mobile`, `address_line1`, `address_line2`, `city_id`, `type`, `payment`, `package_id`, `certificate_id`, `certificate_status`, `cod_amount`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['created_by'],
            $data['created_at'],
            $data['updated_at'],
            $data['mobile'],
            $data['address_line1'],
            $data['address_line2'],
            $data['city_id'],
            $data['type'],
            $data['payment'],
            $data['package_id'],
            $data['certificate_id'],
            $data['certificate_status'],
            $data['cod_amount'],
            $data['is_active']
        ]);
    }


    public function updateOrder($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `cc_certificate_order` SET `created_by` = ?, `created_at` = ?, `updated_at` = ?, `mobile` = ?, `address_line1` = ?, `address_line2` = ?, `city_id` = ?, `type` = ?, `payment` = ?, `package_id` = ?, `certificate_id` = ?, `certificate_status` = ?, `cod_amount` = ?, `is_active` = ? WHERE `id` = ?");
        $stmt->execute([
            $data['created_by'],
            $data['created_at'],
            $data['updated_at'],
            $data['mobile'],
            $data['address_line1'],
            $data['address_line2'],
            $data['city_id'],
            $data['type'],
            $data['payment'],
            $data['package_id'],
            $data['certificate_id'],
            $data['certificate_status'],
            $data['cod_amount'],
            $data['is_active'],
            $id
        ]);
    }

    public function deleteOrder($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `cc_certificate_order` WHERE `id` = ?");
        $stmt->execute([$id]);
    }
}
