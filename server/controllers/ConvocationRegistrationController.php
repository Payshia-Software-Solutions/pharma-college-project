<?php
// controllers/ConvocationRegistrationController.php

require_once './models/ConvocationRegistration.php';

class ConvocationRegistrationController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new ConvocationRegistration($pdo);
    }

    // GET all registrations
    public function getRegistrations()
    {
        $registrations = $this->model->getAllRegistrations();
        echo json_encode($registrations);
    }

    // GET a single registration by ID
    public function getRegistration($registration_id)
    {
        $registration = $this->model->getRegistrationById($registration_id);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }

    // GET a single registration by reference number
    public function getRegistrationByReference($reference_number)
    {
        $registration = $this->model->getRegistrationByReference($reference_number);
        if ($registration) {
            echo json_encode($registration);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found']);
        }
    }

    // POST create a new registration (no reference_number in input)
    public function createRegistration()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['student_number']) || !isset($data['course_id']) ||
            !isset($data['package_id'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields: student_number, course_id, package_id']);
            return;
        }

        $registration_id = $this->model->createRegistration(
            $data['student_number'],
            $data['course_id'],
            $data['package_id'],
            $data['event_id'] ?? null,
            $data['payment_status'] ?? 'pending',
            $data['payment_amount'] ?? null,
            $data['registration_status'] ?? 'pending'
        );
        http_response_code(201);
        // Return registration_id as reference_number
        echo json_encode([
            'registration_id' => $registration_id,
            'reference_number' => $registration_id,
            'message' => 'Registration created successfully'
        ]);
    }

    // PUT update a registration
    public function updateRegistration($registration_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['student_number']) || !isset($data['course_id']) ||
            !isset($data['package_id'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $success = $this->model->updateRegistration(
            $registration_id,
            $data['student_number'],
            $data['course_id'],
            $data['package_id'],
            $data['event_id'] ?? null,
            $data['payment_status'] ?? 'pending',
            $data['payment_amount'] ?? null,
            $data['registration_status'] ?? 'pending'
        );
        if ($success) {
            echo json_encode(['message' => 'Registration updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found or update failed']);
        }
    }

    // DELETE a registration
    public function deleteRegistration($registration_id)
    {
        $success = $this->model->deleteRegistration($registration_id);
        if ($success) {
            echo json_encode(['message' => 'Registration deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Registration not found or deletion failed']);
        }
    }
}
