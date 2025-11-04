<?php
// models/ceylonPharmacy/CareAnswerSubmit.php

class CareAnswerSubmit
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCareAnswerSubmits()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_answer_submit');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCareAnswerSubmitById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer_submit WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCareAnswerSubmit($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_answer_submit (answer_id, pres_id, cover_id, date, name, drug_name, drug_type, drug_qty, morning_qty, afternoon_qty, evening_qty, night_qty, meal_type, using_type, at_a_time, hour_qty, additional_description, created_at, created_by, answer_status, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
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
            $data['answer_status'],
            $data['score']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCareAnswerSubmit($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_answer_submit SET answer_id = ?, pres_id = ?, cover_id = ?, date = ?, name = ?, drug_name = ?, drug_type = ?, drug_qty = ?, morning_qty = ?, afternoon_qty = ?, evening_qty = ?, night_qty = ?, meal_type = ?, using_type = ?, at_a_time = ?, hour_qty = ?, additional_description = ?, created_at = ?, created_by = ?, answer_status = ?, score = ? WHERE id = ?');
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
            $data['answer_status'],
            $data['score'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCareAnswerSubmit($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_answer_submit WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
