
<?php
require_once('../../../../../include/config.php'); // Include your DB config

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['is_active'])) {
    $criteriaGroupId = intval($data['id']);
    $isActive = intval($data['is_active']);

    // Prepare and execute the update query
    $query = "UPDATE cc_criteria_group SET is_active = ? WHERE id = ?";
    if ($stmt = $lms_link->prepare($query)) {
        $stmt->bind_param('ii', $isActive, $criteriaGroupId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Certificate status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database execution error.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query preparation error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

$link->close();
?>
