<?php
// controllers/Winpharma/WinPharmaLevelResourceController.php

require_once './models/Winpharma/WinPharmaLevelResource.php';


class WinPharmaLevelResourceController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new WinPharmaLevelResource($pdo);
    }

    public function getWinPharmaLevelResources()
    {
        $WinPharmaLevelResources = $this->model->getAllWinPharmaLevelResources();
        echo json_encode($WinPharmaLevelResources);
    }

    public function getWinPharmaLevelResource($id)
    {
        $WinPharmaLevelResource = $this->model->getWinPharmaLevelResourceById($id);
        echo json_encode($WinPharmaLevelResource);
    }
    
    public function createWinPharmaLevelResource()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->createWinPharmaLevelResource($data);
        echo json_encode(['status' => 'WinPharmaLevelResource created']);
    }

    public function updateWinPharmaLevelResource($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateWinPharmaLevelResource($id, $data);
        echo json_encode(['status' => 'WinPharmaLevelResource updated']);
    }

    public function deleteWinPharmaLevelResource($id)
    {
        $this->model->deleteWinPharmaLevelResource($id);
        echo json_encode(['status' => 'WinPharmaLevelResource deleted']);
    }
}