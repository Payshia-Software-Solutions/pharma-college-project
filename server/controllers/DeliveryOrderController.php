
<?php
// controllers/DeliveryOrderController.php

require_once './models/DeliveryOrders.php';

class DeliveryOrderController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new DeliveryOrder($pdo);
    }

    public function getDeliveryOrders()
    {
        $deliveryOrders = $this->model->getAllDeliveryOrders();
        echo json_encode($deliveryOrders);
    }

    public function getDeliveryOrder($id)
    {
        $deliveryOrder = $this->model->getDeliveryOrderById($id);
        echo json_encode($deliveryOrder);
    }

    public function getDeliveryOrderByIndexNumber($username)
    {
        $deliveryOrder = $this->model->getDeliveryOrderByIndexNumber($username);
        echo json_encode($deliveryOrder);
    }

    public function createDeliveryOrder()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->model->createDeliveryOrder($data)) {
            echo json_encode(['status' => 'Delivery order created']);
        } else {
            echo json_encode(['status' => 'Failed to create delivery order']);
        }
    }

    public function updateDeliveryOrder($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->model->updateDeliveryOrder($id, $data)) {
            echo json_encode(['status' => 'Delivery order updated']);
        } else {
            echo json_encode(['status' => 'Failed to update delivery order']);
        }
    }

    public function deleteDeliveryOrder($id)
    {
        if ($this->model->deleteDeliveryOrder($id)) {
            echo json_encode(['status' => 'Delivery order deleted']);
        } else {
            echo json_encode(['status' => 'Failed to delete delivery order']);
        }
    }
}
