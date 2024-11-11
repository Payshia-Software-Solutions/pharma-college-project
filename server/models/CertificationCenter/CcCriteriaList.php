<?php
// models/CertificationCenter/CcCriteriaList.php

class CcCriteriaList
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCriteriaLists()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_criteria_list`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCriteriaListById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_criteria_list` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCriteriaList($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `cc_criteria_list` (`list_name`, `created_at`, `created_by`, `is_active`) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['list_name'],
            $data['created_at'],
            $data['created_by'],
            $data['is_active']
        ]);
    }

    public function updateCriteriaList($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `cc_criteria_list` SET `list_name` = ?, `created_at` = ?, `created_by` = ?, `is_active` = ? WHERE `id` = ?");
        $stmt->execute([
            $data['list_name'],
            $data['created_at'],
            $data['created_by'],
            $data['is_active'],
            $id
        ]);
    }

    public function deleteCriteriaList($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `cc_criteria_list` WHERE `id` = ?");
        $stmt->execute([$id]);
    }
}
