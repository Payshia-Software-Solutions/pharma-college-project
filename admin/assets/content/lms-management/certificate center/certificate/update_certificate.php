<?php
require_once('../../../../../include/config.php');

// Ensure criteria_group_id is provided
if (!isset($_POST['criteria_group_id'])) {
    echo json_encode(['success' => false, 'message' => 'Criteria Group ID is missing.']);
    exit;
}

$criteria_group_id = intval($_POST['criteria_group_id']);

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $id = intval($_POST['id']);
    $list_name = htmlspecialchars($_POST['list_name'], ENT_QUOTES, 'UTF-8');
    $price = floatval($_POST['price']);
    $created_by = htmlspecialchars($_POST['created_by'], ENT_QUOTES, 'UTF-8');

    // Validate required fields
    if (empty($list_name) || empty($criteria_group_id)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if ($price <= 0) {
        echo json_encode(['success' => false, 'message' => 'Price must be greater than 0.']);
        exit;
    }

    // Check database connection
    if (!$lms_link) {
        echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        exit;
    }

    // Update the database record
    $query = "UPDATE cc_certificate_list 
              SET list_name = ?, criteria_group_id = ?, price = ?, created_by = ? 
              WHERE id = ?";
    $stmt = $lms_link->prepare($query);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Query preparation failed: ' . $lms_link->error]);
        exit;
    }

    $stmt->bind_param("sidsi", $list_name, $criteria_group_id, $price, $created_by, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Certificate updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update the certificate: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
