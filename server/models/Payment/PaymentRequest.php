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
        // Check for required fields and throw an exception if any are missing
        $requiredFields = ['created_by', 'created_at', 'course_id', 'reason', 'extra_note', 'reference_number'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new Exception("The '{$field}' field is required.");
            }
        }
    
        // If status is not provided, set it to 0
        if (!isset($data['status'])) {
            $data['status'] = 0;
        }
    
        // Set the image path
        $data['image'] = $imagePath;
    
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO payment_request (created_by, created_at, course_id, image, reason, extra_note, status, reference_number) 
                VALUES (:created_by, :created_at, :course_id, :image, :reason, :extra_note, :status, :reference_number)";
    
        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
    
        // Execute the query with the data array
        $stmt->execute([
            'created_by' => $data['created_by'],
            'created_at' => $data['created_at'],
            'course_id' => $data['course_id'],
            'image' => $data['image'],
            'reason' => $data['reason'],
            'extra_note' => $data['extra_note'],
            'status' => $data['status'],
            'reference_number' => $data['reference_number']
        ]);
    }
    
    


    public function updateRecord($id, $data, $imagePath = null)
    {
        // Check if 'created_by' is set and not null
        if (empty($data['created_by'])) {
            throw new Exception("The 'created_by' field is required.");
        }
    
        // Check if 'created_at' is set and not null
        if (empty($data['created_at'])) {
            throw new Exception("The 'created_at' field is required.");
        }
    
        // Prepare the SQL query for updating the record
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
    
        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
    
        // Execute the query with the provided data
        $stmt->execute([
            'created_by' => $data['created_by'],
            'created_at' => $data['created_at'],
            'course_id' => $data['course_id'],
            'image' => $imagePath ?? $data['image'],
            'reason' => $data['reason'],
            'extra_note' => $data['extra_note'],
            'status' => $data['status'],
            'reference_number' => $data['reference_number'],
            'id' => $id
        ]);
    }
    


    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM payment_request WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}