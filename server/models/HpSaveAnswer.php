<?php

class HpSaveAnswer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Generator to fetch all answers in batches to avoid memory exhaustion
    // public function getAllAnswers()
    // {
    //     $stmt = $this->pdo->query("SELECT * FROM hp_save_answer");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getAllAnswers($offset = 0, $limit = 100)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hp_save_answer LIMIT :offset, :limit");
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getAnswerById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hp_save_answer WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createAnswer($data)
    {
        $sql = "INSERT INTO hp_save_answer (index_number, category_id, medicine_id, rack_id, dosage_id, drug_type, answer_status, created_at, score, score_type, attempts) 
                VALUES (:index_number, :category_id, :medicine_id, :rack_id, :dosage_id, :drug_type, :answer_status, :created_at, :score, :score_type, :attempts)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateAnswer($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE hp_save_answer SET 
                    index_number = :index_number, 
                    category_id = :category_id, 
                    medicine_id = :medicine_id, 
                    rack_id = :rack_id, 
                    dosage_id = :dosage_id, 
                    drug_type = :drug_type, 
                    answer_status = :answer_status, 
                    created_at = :created_at, 
                    score = :score, 
                    score_type = :score_type, 
                    attempts = :attempts
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteAnswer($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM hp_save_answer WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
