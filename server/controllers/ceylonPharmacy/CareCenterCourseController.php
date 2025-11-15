<?php
// controllers/ceylonPharmacy/CareCenterCourseController.php

require_once __DIR__ . '/../../models/ceylonPharmacy/CareCenterCourse.php';
require_once __DIR__ . '/../../models/ceylonPharmacy/CarePatient.php';

class CareCenterCourseController
{
    private $careCenterCourseModel;
    private $carePatientModel;

    public function __construct($pdo)
    {
        $this->careCenterCourseModel = new CareCenterCourse($pdo);
        $this->carePatientModel = new CarePatient($pdo);
    }

    public function getAll()
    {
        $courses = $this->careCenterCourseModel->getAllCareCenterCourses();
        return json_encode($courses);
    }

    public function getById($id)
    {
        $course = $this->careCenterCourseModel->getCareCenterCourseById($id);
        if ($course) {
            return json_encode($course);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'Course not found']);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $lastId = $this->careCenterCourseModel->createCareCenterCourse($data);
            http_response_code(201);
            return json_encode([
                'message' => 'Course created successfully',
                'id' => $lastId
            ]);
        } else {
            http_response_code(400);
            return json_encode(['error' => 'Invalid input']);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $this->careCenterCourseModel->updateCareCenterCourse($id, $data);
            return json_encode(['message' => 'Course updated successfully']);
        } else {
            http_response_code(400);
            return json_encode(['error' => 'Invalid input']);
        }
    }

    public function delete($id)
    {
        $this->careCenterCourseModel->deleteCareCenterCourse($id);
        return json_encode(['message' => 'Course deleted successfully']);
    }

    public function getPrescriptionIdsByCourseCode($courseCode)
    {
        $prescriptionIds = $this->careCenterCourseModel->getPrescriptionIdsByCourseCode($courseCode);
        if ($prescriptionIds) {
            $patientData = [];
            foreach ($prescriptionIds as $row) {
                $prescriptionId = $row['prescription_id'];
                $patient = $this->carePatientModel->getCarePatientByPrescriptionId($prescriptionId);
                if ($patient) {
                    $patientData[$prescriptionId] = $patient;
                }
            }
            return json_encode($patientData);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'No prescriptions found for this course']);
        }
    }
}
