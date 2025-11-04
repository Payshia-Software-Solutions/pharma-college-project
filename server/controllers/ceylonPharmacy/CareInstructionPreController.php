<?php
// controllers/ceylonPharmacy/CareInstructionPreController.php

require_once __DIR__ . '/../../models/ceylonPharmacy/CareInstructionPre.php';

class CareInstructionPreController
{
    private $careInstructionPreModel;

    public function __construct($pdo)
    {
        $this->careInstructionPreModel = new CareInstructionPre($pdo);
    }

    public function getAll()
    {
        $instructions = $this->careInstructionPreModel->getAllCareInstructionPres();
        echo json_encode($instructions);
    }

    public function getById($id)
    {
        $instruction = $this->careInstructionPreModel->getCareInstructionPreById($id);
        if ($instruction) {
            echo json_encode($instruction);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Instruction not found']);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {
            $lastId = $this->careInstructionPreModel->createCareInstructionPre($data);
            http_response_code(201);
            echo json_encode([
                'message' => 'Instruction created successfully',
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
            $this->careInstructionPreModel->updateCareInstructionPre($id, $data);
            echo json_encode(['message' => 'Instruction updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function delete($id)
    {
        $this->careInstructionPreModel->deleteCareInstructionPre($id);
        echo json_encode(['message' => 'Instruction deleted successfully']);
    }
}
