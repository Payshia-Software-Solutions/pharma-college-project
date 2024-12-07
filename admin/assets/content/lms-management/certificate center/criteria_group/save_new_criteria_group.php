<?php
// Include necessary files
require_once('../../../../../include/config.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $group_name = htmlspecialchars($_POST['group_name'], ENT_QUOTES, 'UTF-8');
    $created_by = htmlspecialchars($_POST['created_by'], ENT_QUOTES, 'UTF-8');
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Ensure 'criteria_group' is an array and sanitize it
    $criteria_group = isset($_POST['criteria_group']) ? $_POST['criteria_group'] : [];
    if (!is_array($criteria_group)) {
        echo json_encode(['success' => false, 'message' => 'Invalid criteria group data.']);
        exit;
    }

    // Convert all elements to integers
    $criteria_group_int = array_map('intval', $criteria_group);

    // Validate required fields
    if (empty($group_name) || empty($created_by) || empty($criteria_group_int)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required, and at least one criterion must be selected.']);
        exit;
    }

    // Convert criteria group to JSON (as integers)
    $criteria_group_json = json_encode($criteria_group_int);

    // Prepare and execute the SQL query
    $query = "INSERT INTO cc_criteria_group (group_name, criteria_group, created_at, created_by, is_active) 
              VALUES (?, ?, NOW(), ?, ?)";
    $stmt = $lms_link->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $lms_link->error]);
        exit;
    }

    $stmt->bind_param("sssi", $group_name, $criteria_group_json, $created_by, $is_active);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Criteria Group added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save data: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
