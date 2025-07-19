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

    // GET all certificate orders by course code
    public function getOrdersByCourseCode($courseCode)
    {
        $orders = $this->model->getOrdersWithCourseCode($courseCode);
        if ($orders) {
            echo json_encode($orders);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No orders found for this course code']);
        }
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
        $data = $_POST; // Form fields

        $requiredFields = [
            'created_by',
            'mobile',
            'address_line1',
            'address_line2',
            'city_id',
            'district',
            'type',
            'payment_amount',
            'package_id',
            'certificate_id',
            'certificate_status'
        ];

        // Check for missing fields
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields', 'missing_fields' => $missingFields]);
            return;
        }

        // Extract course_ids directly from $_POST['course_id']
        $courseIds = isset($data['course_id']) && is_array($data['course_id']) ? $data['course_id'] : [];
        // Convert course_ids array to a comma-separated string
        $courseIdsString = implode(',', $courseIds);


        // Create certificate order in the database
        $order_id = $this->model->createOrder(
            $data['created_by'],
            $courseIdsString,
            $data['mobile'],
            $data['address_line1'],
            $data['address_line2'],
            $data['city_id'],
            $data['district'],
            $data['type'],
            $data['payment_amount'],
            $data['package_id'],
            $data['certificate_id'],
            $data['certificate_status'],
            $data['cod_amount'] ?? 0,
            $data['is_active'] ?? 1
        );

        http_response_code(201);
        echo json_encode([
            'reference_number' => $order_id,
            'message' => 'Order created successfully',
        ]);
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
            $data['district'],
            $data['type'],
            $data['payment_amount'],
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

    // PUT update courses in a certificate order
    public function updateCourses($orderId)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['course_code'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing course_code']);
            return;
        }

        // Handle both string "2,1" and array [2,1]
        if (is_array($data['course_code'])) {
            $courseIds = $data['course_code'];
        } else {
            $courseIds = array_map('trim', explode(',', $data['course_code']));
        }

        // Filter out any empty values and re-implode
        $courseIdsString = implode(',', array_filter($courseIds));

        $success = $this->model->updateCourses($orderId, $courseIdsString);
        if ($success) {
            echo json_encode(['message' => 'Courses updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found or update failed']);
        }
    }
}
