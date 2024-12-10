<?php
require_once('../../../../../include/config.php');
include '../../../../../include/lms-functions.php';

// header('Content-Type: application/json');

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

try {
    // Use $lms_link as the database connection
    global $lms_link;

    // Sanitize and validate inputs
    $list_name = trim($_POST['list_name'] ?? '');
    $criteria_group_id = intval($_POST['criteria_group_id'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $created_by = trim($_POST['created_by'] ?? '');
    $created_at = date('Y-m-d H:i:s');
    $is_active = 1;

    // Perform server-side validation
    if (empty($list_name)) {
        echo json_encode(['success' => false, 'message' => 'Certificate Name cannot be empty.']);
        exit;
    }

    if ($criteria_group_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please Select Criteria Group.']);
        exit;
    }

    if ($price <= 0) {
        echo json_encode(['success' => false, 'message' => 'Price must be greater than 0.']);
        exit;
    }

    if (empty($created_by)) {
        echo json_encode(['success' => false, 'message' => 'Created By cannot be empty.']);
        exit;
    }

    // Insert data into the database
    $stmt = $lms_link->prepare("INSERT INTO `cc_certificate_list` (`list_name`, `criteria_group_id`, `price`, `created_at`, `created_by`, `is_active`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$list_name, $criteria_group_id, $price, $created_at, $created_by, $is_active]);

    echo json_encode(['status' => 'success', 'message' => 'Certificate added successfully.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
