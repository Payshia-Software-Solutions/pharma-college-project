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
    // test

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
        $stmt = $this->pdo->prepare('INSERT INTO care_answer (answer_id, pres_id, cover_id, date, name, drug_name, drug_type, drug_qty, morning_qty, afternoon_qty, evening_qty, night_qty, meal_type, using_type, at_a_time, hour_qty, additional_description, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['answer_id'],
            $data['pres_id'],
            $data['cover_id'],
            $data['date'],
            $data['name'],
            $data['drug_name'],
            $data['drug_type'],
            $data['drug_qty'],
            $data['morning_qty'],
            $data['afternoon_qty'],
            $data['evening_qty'],
            $data['night_qty'],
            $data['meal_type'],
            $data['using_type'],
            $data['at_a_time'],
            $data['hour_qty'],
            $data['additional_description'],
            $data['created_at'],
            $data['created_by']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCareAnswer($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_answer SET answer_id = ?, pres_id = ?, cover_id = ?, date = ?, name = ?, drug_name = ?, drug_type = ?, drug_qty = ?, morning_qty = ?, afternoon_qty = ?, evening_qty = ?, night_qty = ?, meal_type = ?, using_type = ?, at_a_time = ?, hour_qty = ?, additional_description = ?, created_at = ?, created_by = ? WHERE id = ?');
        $stmt->execute([
            $data['answer_id'],
            $data['pres_id'],
            $data['cover_id'],
            $data['date'],
            $data['name'],
            $data['drug_name'],
            $data['drug_type'],
            $data['drug_qty'],
            $data['morning_qty'],
            $data['afternoon_qty'],
            $data['evening_qty'],
            $data['night_qty'],
            $data['meal_type'],
            $data['using_type'],
            $data['at_a_time'],
            $data['hour_qty'],
            $data['additional_description'],
            $data['created_at'],
            $data['created_by'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCareAnswer($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_answer WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
