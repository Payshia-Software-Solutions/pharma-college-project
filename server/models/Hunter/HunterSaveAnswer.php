<?php

class HunterSaveAnswer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM hunter_saveanswer");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hunter_saveanswer WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        $sql = "INSERT INTO hunter_saveanswer (index_number, category_id, medicine_id, rack_id, dosage_id, answer_status, score, score_type, attempts) 
                VALUES (:index_number, :category_id, :medicine_id, :rack_id, :dosage_id, :answer_status, :score, :score_type, :attempts)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE hunter_saveanswer SET 
                    index_number = :index_number, 
                    category_id = :category_id,
                    medicine_id = :medicine_id,
                    rack_id = :rack_id,
                    dosage_id = :dosage_id,
                    answer_status = :answer_status,
                    score = :score,
                    score_type = :score_type,
                    attempts = :attempts
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM hunter_saveanswer WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
