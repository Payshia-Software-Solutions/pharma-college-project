<?php
// controllers/ceylonPharmacy/CareAnswerController.php

require_once __DIR__ . '/../../models/ceylonPharmacy/CareAnswer.php';

class CareAnswerController
{
    private $careAnswerModel;

    public function __construct($pdo)
    {
        $this->careAnswerModel = new CareAnswer($pdo);
    }

    public function getAll()
    {
        $answers = $this->careAnswerModel->getAllCareAnswers();
        echo json_encode($answers);
    }

    public function getById($id)
    {
        $answer = $this->careAnswerModel->getCareAnswerById($id);
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
            $lastId = $this->careAnswerModel->createCareAnswer($data);
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
            $this->careAnswerModel->updateCareAnswer($id, $data);
            echo json_encode(['message' => 'Answer updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function delete($id)
    {
        $this->careAnswerModel->deleteCareAnswer($id);
        echo json_encode(['message' => 'Answer deleted successfully']);
    }
}
