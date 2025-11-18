<?php
// models/ceylonPharmacy/CareAnswer.php

class CareAnswer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCareAnswers()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_answer');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCareAnswerById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAnswersByPrescriptionAndCover($presId, $coverId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer WHERE pres_id = ? AND cover_id = ?');
        $stmt->execute([$presId, $coverId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswerByPrescriptionAndCover($presId, $coverId) 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer WHERE pres_id = ? AND cover_id = ?');
        $stmt->execute([$presId, $coverId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getDistinctNames()
    {
        $stmt = $this->pdo->query('SELECT DISTINCT name FROM care_answer');
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getFormSelectionData()
    {
        $columns = [
            'name', 'drug_name', 'drug_type', 'drug_qty', 'morning_qty', 'afternoon_qty',
            'evening_qty', 'night_qty', 'meal_type', 'using_type', 'at_a_time', 'hour_qty',
            'additional_description'
        ];

        $selectionData = [];

        foreach ($columns as $column) {
            $stmt = $this->pdo->query("SELECT DISTINCT `$column` FROM care_answer WHERE `$column` IS NOT NULL AND `$column` != '' ORDER BY `$column` ASC");
            $selectionData[$column] = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }

        return $selectionData;
    }

    public function createCareAnswer($data)
    {
        $columns = '`' . implode('`, `', array_keys($data)) . '`';
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO `care_answer` ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute($data)) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function updateCareAnswer($id, $data)
    {
        $setPart = [];
        foreach ($data as $key => $value) {
            $setPart[] = "`$key` = :$key";
        }
        $sql = "UPDATE care_answer SET " . implode(', ', $setPart) . " WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteCareAnswer($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_answer WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
