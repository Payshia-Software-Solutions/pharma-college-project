<?php
// controllers/CertificationCenter/CcCertificateOrderController.php

require_once 'models/CertificationCenter/CcCertificateOrder.php';

class CcCertificateOrderController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new CcCertificateOrder($pdo);
    }

    public function getAllOrders()
    {
        $orders = $this->model->getAllOrders();
        echo json_encode($orders);
    }

    public function getOrderById($id)
    {
        $order = $this->model->getOrderById($id);
        if ($order) {
            echo json_encode($order);
        } else {
            echo json_encode(["error" => "Order not found"]);
        }
    }

    public function createOrder()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->model->createOrder($data);
        echo json_encode(["message" => "Order created successfully"]);
    }

    public function updateOrder($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->model->updateOrder($id, $data);
        echo json_encode(["message" => "Order updated successfully"]);
    }

    public function deleteOrder($id)
    {
        $this->model->deleteOrder($id);
        echo json_encode(["message" => "Order deleted successfully"]);
    }
}
