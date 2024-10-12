<?php

class PaymentRequest
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM payment_request");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM payment_request WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data, $imagePath)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['image'] = $imagePath;

        $sql = "INSERT INTO payment_request (created_by, created_at, course_id, image, reason, extra_note, status, reference_number) 
                VALUES (:created_by, :created_at, :course_id, :image, :reason, :extra_note, :status, :reference_number)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data, $imagePath = null)
    {
        $data['id'] = $id;
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        $sql = "UPDATE payment_request SET 
                    created_by = :created_by, 
                    created_at = :created_at, 
                    course_id = :course_id, 
                    image = :image, 
                    reason = :reason,
                    extra_note = :extra_note,
                    status = :status,
                    reference_number = :reference_number
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM payment_request WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}