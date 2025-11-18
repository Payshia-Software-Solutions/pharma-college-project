<?php
// controllers/ceylonPharmacy/CareAnswerSubmitController.php

require_once __DIR__ . '/../../models/ceylonPharmacy/CareAnswerSubmit.php';

class CareAnswerSubmitController
{
    private $careAnswerSubmitModel;

    public function __construct($pdo)
    {
        $this->careAnswerSubmitModel = new CareAnswerSubmit($pdo);
    }

    public function getAll()
    {
        $answers = $this->careAnswerSubmitModel->getAllCareAnswerSubmits();
        echo json_encode($answers);
    }

    public function getById($id)
    {
        $answer = $this->careAnswerSubmitModel->getCareAnswerSubmitById($id);
        if ($answer) {
            echo json_encode($answer);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Answer not found']);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $lastId = $this->careAnswerSubmitModel->createCareAnswerSubmit($data);
            http_response_code(201);
            echo json_encode([
                'message' => 'Answer created successfully',
                'id' => $lastId
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $this->careAnswerSubmitModel->updateCareAnswerSubmit($id, $data);
            echo json_encode(['message' => 'Answer updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function delete($id)
    {
        $this->careAnswerSubmitModel->deleteCareAnswerSubmit($id);
        echo json_encode(['message' => 'Answer deleted successfully']);
    }
}
