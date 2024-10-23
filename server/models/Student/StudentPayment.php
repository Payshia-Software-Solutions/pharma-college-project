<?php

use Carbon\Carbon;

class StudentPayment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllRecords()
    {
        $stmt = $this->pdo->query("SELECT * FROM student_payment");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM student_payment WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRecord($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO student_payment 
                (receipt_number, course_code, student_id, paid_amount, discount_amount, payment_status, payment_type, paid_date, created_at, created_by, reason) 
                VALUES 
                (:receipt_number, :course_code, :student_id, :paid_amount, :discount_amount, :payment_status, :payment_type, :paid_date, :created_at, :created_by, :reason)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateRecord($id, $data)
    {
        if (!isset($data['update_at'])) {
            $data['update_at'] = date('Y-m-d H:i:s');
        }

        $data['id'] = $id;

        $sql = "UPDATE student_payment SET 
                    receipt_number = :receipt_number, 
                    course_code = :course_code, 
                    student_id = :student_id,
                    paid_amount = :paid_amount, 
                    discount_amount = :discount_amount,
                    payment_status = :payment_status, 
                    payment_type = :payment_type,
                    paid_date = :paid_date,
                    update_at = :update_at,
                    reason = :reason
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteRecord($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM student_payment WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}