<?php
// models/DeliveryOrder.php

class DeliveryOrder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllDeliveryOrders()
    {
        $stmt = $this->pdo->query("SELECT * FROM delivery_orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeliveryOrderById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDeliveryOrderByIndexNumber($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE index_number = ?");
        $stmt->execute([$username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDeliveryOrder($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO delivery_orders 
            (delivery_id, tracking_number, index_number, order_date, packed_date, send_date, removed_date, current_status, delivery_partner, value, payment_method, course_code, estimate_delivery, full_name, street_address, city, district, phone_1, phone_2, is_active, received_date, cod_amount, package_weight)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['delivery_id'],
            $data['tracking_number'],
            $data['index_number'],
            $data['order_date'],
            $data['packed_date'],
            $data['send_date'],
            $data['removed_date'],
            $data['current_status'],
            $data['delivery_partner'],
            $data['value'],
            $data['payment_method'],
            $data['course_code'],
            $data['estimate_delivery'],
            $data['full_name'],
            $data['street_address'],
            $data['city'],
            $data['district'],
            $data['phone_1'],
            $data['phone_2'],
            $data['is_active'],
            $data['received_date'],
            $data['cod_amount'],
            $data['package_weight']
        ]);
    }

    public function updateDeliveryOrder($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE delivery_orders 
            SET delivery_id = ?, tracking_number = ?, index_number = ?, order_date = ?, packed_date = ?, send_date = ?, removed_date = ?, current_status = ?, delivery_partner = ?, value = ?, payment_method = ?, course_code = ?, estimate_delivery = ?, full_name = ?, street_address = ?, city = ?, district = ?, phone_1 = ?, phone_2 = ?, is_active = ?, received_date = ?, cod_amount = ?, package_weight = ?
            WHERE id = ?");
        return $stmt->execute([
            $data['delivery_id'],
            $data['tracking_number'],
            $data['index_number'],
            $data['order_date'],
            $data['packed_date'],
            $data['send_date'],
            $data['removed_date'],
            $data['current_status'],
            $data['delivery_partner'],
            $data['value'],
            $data['payment_method'],
            $data['course_code'],
            $data['estimate_delivery'],
            $data['full_name'],
            $data['street_address'],
            $data['city'],
            $data['district'],
            $data['phone_1'],
            $data['phone_2'],
            $data['is_active'],
            $data['received_date'],
            $data['cod_amount'],
            $data['package_weight'],
            $id
        ]);
    }

    public function deleteDeliveryOrder($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM delivery_orders WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
