<?php
// models/CertificationCenter/CcCriteriaGroup.php

class CcCriteriaGroup
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCriteriaGroups()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_criteria_group`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCriteriaGroupById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `cc_criteria_group` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCriteriaGroup($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `cc_criteria_group` (`group_name`, `created_at`, `created_by`, `is_active`) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['group_name'],
            $data['created_at'],
            $data['created_by'],
            $data['is_active']
        ]);
    }

    public function updateCriteriaGroup($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `cc_criteria_group` SET `group_name` = ?, `created_at` = ?, `created_by` = ?, `is_active` = ? WHERE `id` = ?");
        $stmt->execute([
            $data['group_name'],
            $data['created_at'],
            $data['created_by'],
            $data['is_active'],
            $id
        ]);
    }

    public function deleteCriteriaGroup($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `cc_criteria_group` WHERE `id` = ?");
        $stmt->execute([$id]);
    }
}
