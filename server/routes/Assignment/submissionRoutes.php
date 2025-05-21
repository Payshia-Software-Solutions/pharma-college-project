<?php
// routes/Assignments/submissionRoutes.php

require_once './controllers/Assignment/AssignmentSubmissionController.php';

$pdo = $GLOBALS['pdo'];
$submissionController = new AssignmentSubmissionController($pdo);

return [
    'GET /submissions/$' => function () use ($submissionController) {
        return $submissionController->getSubmissions();
    },

    'GET /submissions/(\d+)/$' => function ($id) use ($submissionController) {
        return $submissionController->getSubmission($id);
    },

    'GET /submissions\?assignment_id=\d+/$' => function () use ($submissionController) {
        $assignmentId = $_GET['assignment_id'] ?? null;
        if ($assignmentId) {
            return $submissionController->getSubmissionsByAssignmentId($assignmentId);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required parameters. assignment_id is required']);
        }
    },

    'POST /submissions/$' => function () use ($submissionController) {
        return $submissionController->createSubmission();
    },

    'PUT /submissions/(\d+)/$' => function ($id) use ($submissionController) {
        return $submissionController->updateSubmission($id);
    },

    'DELETE /submissions/(\d+)/$' => function ($id) use ($submissionController) {
        return $submissionController->deleteSubmission($id);
    },
];
