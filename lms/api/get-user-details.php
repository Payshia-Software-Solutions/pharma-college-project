<?php
require_once '../include/configuration.php';

$ArrayResult = array();

$sql = "SELECT `id`, `status_id`, `userid`, `fname`, `lname`, `batch_id`, `username`, `phone`, `email`, `password`, `userlevel`, `status`, `created_by`, `created_at`, `batch_lock` FROM `users` ORDER BY id";

// Perform error handling and use prepared statements to prevent SQL injection
if ($stmt = $link->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ArrayResult[$row['username']] = $row;
    }

    $stmt->close();
}

// Set appropriate HTTP headers for JSON response
header('Content-Type: application/json');

// Return the JSON-encoded result
echo json_encode($ArrayResult);
