<?php
// models/Winpharma/WinPharmaLevelResource.php

class WinPharmaLevelResource
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllWinPharmaLevelResources()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `win_pharma_level_resources`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWinPharmaLevelResourceById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `win_pharma_level_resources` WHERE `resource_id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createWinPharmaLevelResource($data)
{
    $stmt = $this->pdo->prepare("INSERT INTO `win_pharma_level_resources` 
    (`level_id`, `resource_title`, `resource_data`, `created_by`, `task_cover`, `is_active`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['level_id'],
        $data['resource_title'],
        $data['resource_data'],
        $data['created_by'],
        $data['task_cover'],
        $data['is_active']
    ]);
}


    public function updateWinPharmaLevelResource($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `win_pharma_level_resources` SET `resource_id` = ?, `level_id` = ?, `resource_title` = ?, `resource_data` = ?, `created_by` = ?, `task_cover` = ?, `is_active` = ? WHERE `resource_id` = ?");
        $stmt->execute([
            $data['resource_id'],
            $data['level_id'],
            $data['resource_title'],
            $data['resource_data'],
            $data['created_by'],
            $data['task_cover'],
            $data['is_active'],
            $id
        ]);
    }

    public function deleteWinPharmaLevelResource($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `win_pharma_level_resources` WHERE `resource_id` = ?");
        $stmt->execute([$id]);
    }
}