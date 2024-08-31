<?php

class HpSaveAnswer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Generator to fetch all answers in batches to avoid memory exhaustion
    public function getAllAnswers($batchSize = 1000)
    {
        $offset = 0;

        while (true) {
            // Prepare the query with LIMIT for batch processing
            $stmt = $this->pdo->prepare("SELECT * FROM hp_save_answer LIMIT :offset, :batchSize");
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':batchSize', $batchSize, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the current batch
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($results) === 0) {
                break; // Exit the loop if no more results
            }

            foreach ($results as $row) {
                yield $row; // Yield each row individually
            }

            $offset += $batchSize;
        }
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
