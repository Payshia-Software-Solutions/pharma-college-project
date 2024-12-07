<?php
require_once('../../../../../include/config.php');

// File existence check
$filePath = __DIR__ . '/update_criteria_group.php';
if (!file_exists($filePath)) {
    error_log("[E004] Missing File Error: update_criteria_group.php");
    echo json_encode(['status' => 'error', 'message' => 'Server error: File not found.', 'error_code' => 'E004']);
    exit;
}

// Validate Criteria Group ID
if (!isset($_POST['criteria_group_id'])) {
    error_log("[E005] Missing Criteria Group ID");
    echo json_encode(['status' => 'error', 'message' => 'Criteria Group ID is missing.', 'error_code' => 'E005']);
    exit;
}

$criteria_group_id = intval($_POST['criteria_group_id']);

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("[E006] Invalid Request Method");
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.', 'error_code' => 'E006']);
    exit;
}

// Sanitize and validate input
$group_name = htmlspecialchars($_POST['group_name'] ?? '', ENT_QUOTES, 'UTF-8');
$created_by = htmlspecialchars($_POST['created_by'] ?? '', ENT_QUOTES, 'UTF-8');
$criteria_group = filter_input(INPUT_POST, 'criteria_group', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

// Ensure `criteria_group` is provided and valid
if (empty($criteria_group)) {
    error_log("[E007] Validation Error: Criteria group is missing or empty");
    echo json_encode(['status' => 'error', 'message' => 'At least one criteria must be selected.', 'error_code' => 'E007']);
    exit;
}

// Prepare JSON string for `criteria_group`
$criteria_group_json = json_encode(array_map('intval', $criteria_group)); // Convert array to JSON and ensure integers

// Check database connection
if (!$lms_link) {
    error_log("[E008] Database Connection Error");
    echo json_encode(['status' => 'error', 'message' => 'Database connection error. Please contact support.', 'error_code' => 'E008']);
    exit;
}

// Update the database record
$query = "UPDATE cc_criteria_group 
          SET group_name = ?, criteria_group = ?, created_by = ? 
          WHERE id = ?";
$stmt = $lms_link->prepare($query);

if (!$stmt) {
    error_log("[E009] SQL Preparation Error: " . $lms_link->error);
    echo json_encode(['status' => 'error', 'message' => 'Internal server error. Please try again later.', 'error_code' => 'E009']);
    exit;
}

$stmt->bind_param("sssi", $group_name, $criteria_group_json, $created_by, $criteria_group_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Criteria Group updated successfully.']);
} else {
    error_log("[E010] SQL Execution Error: " . $stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update the criteria group. Please try again.', 'error_code' => 'E010']);
}

$stmt->close();
