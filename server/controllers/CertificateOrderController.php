<?php
// controllers/CertificateOrderController.php

require_once './models/CertificateOrder.php';

class CertificateOrderController
{
    private $model;
    private $ftpConfig;

    public function __construct($pdo)
    {
        $this->model = new CertificateOrder($pdo);
        $this->ftpConfig = include('./config/ftp.php');
    }


    // GET all certificate orders
    public function getOrders()
    {
        $orders = $this->model->getAllOrders();
        echo json_encode($orders);
    }

    // GET a single certificate order by ID
    public function getOrder($order_id)
    {
        $order = $this->model->getOrderById($order_id);
        if ($order) {
            echo json_encode($order);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found']);
        }
    }

    // GET a single certificate order by Certificate ID
    public function getOrderByCertificateId($certificate_id)
    {
        $order = $this->model->getOrderByCertificateId($certificate_id);
        if ($order) {
            echo json_encode($order);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found']);
        }
    }

    // POST create a new certificate order (no id in input)
    public function createOrder()
    {
        $paymentReceiptPath = '';
        // Check if the request is multipart/form-data
        if ($_SERVER['CONTENT_TYPE'] && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {
            $data = $_POST; // Form fields
            $file = $_FILES['payment_receipt'] ?? null; // Uploaded file (matches frontend FormData key)

            // Required fields validation
            if (
                !isset($data['created_by']) ||
                !isset($data['course_code']) ||
                !isset($data['mobile']) ||
                !isset($data['address_line1']) ||
                !isset($data['address_line2']) ||
                !isset($data['city_id']) ||
                !isset($data['type']) ||
                !isset($data['payment']) ||
                !isset($data['package_id']) ||
                !isset($data['certificate_id']) ||
                !isset($data['certificate_status'])
            ) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            // Create certificate order in the database
            $order_id = $this->model->createOrder(
                $data['created_by'],
                $data['course_code'],
                $data['mobile'],
                $data['address_line1'],
                $data['address_line2'],
                $data['city_id'],
                $data['type'],
                $data['payment'],
                $data['package_id'],
                $data['certificate_id'],
                $data['certificate_status'],
                $data['cod_amount'] ?? 0,
                $data['is_active'] ?? 1
            );

            http_response_code(201);
            echo json_encode([
                'order_id' => $order_id,
                'message' => 'Order created successfully',
                'payment_receipt_path' => $paymentReceiptPath
            ]);
        } else {
            // Fallback for JSON (if no file is sent)
            $data = json_decode(file_get_contents('php://input'), true);

            if (
                !isset($data['created_by']) ||
                !isset($data['course_code']) ||
                !isset($data['mobile']) ||
                !isset($data['address_line1']) ||
                !isset($data['address_line2']) ||
                !isset($data['city_id']) ||
                !isset($data['type']) ||
                !isset($data['payment']) ||
                !isset($data['package_id']) ||
                !isset($data['certificate_id']) ||
                !isset($data['certificate_status'])
            ) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            $order_id = $this->model->createOrder(
                $data['created_by'],
                $data['course_code'],
                $data['mobile'],
                $data['address_line1'],
                $data['address_line2'],
                $data['city_id'],
                $data['type'],
                $data['payment'],
                $data['package_id'],
                $data['certificate_id'],
                $data['certificate_status'],
                $data['cod_amount'] ?? 0,
                $data['is_active'] ?? 1
            );
            http_response_code(201);
            echo json_encode([
                'order_id' => $order_id,
                'message' => 'Order created successfully'
            ]);
        }
    }

    // PUT update a certificate order
    public function updateOrder($order_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['created_by']) || !isset($data['course_code']) ||
            !isset($data['certificate_id'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $success = $this->model->updateOrder(
            $order_id,
            $data['created_by'],
            $data['course_code'],
            $data['mobile'],
            $data['address_line1'],
            $data['address_line2'],
            $data['city_id'],
            $data['type'],
            $data['payment'],
            $data['package_id'],
            $data['certificate_id'],
            $data['certificate_status'],
            $data['cod_amount'] ?? 0,
            $data['is_active'] ?? 1
        );
        if ($success) {
            echo json_encode(['message' => 'Order updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found or update failed']);
        }
    }

    // DELETE a certificate order
    public function deleteOrder($order_id)
    {
        $success = $this->model->deleteOrder($order_id);
        if ($success) {
            echo json_encode(['message' => 'Order deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found or deletion failed']);
        }
    }
}
