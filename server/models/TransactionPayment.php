<?php
// models/TransactionPayment.php

class TransactionPayment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllPayments()
    {
        $stmt = $this->pdo->query("SELECT * FROM transcation_payments");
        return $stmt->fetchAll();
    }

    public function getPaymentById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM transcation_payments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getPaymentsByStudentNumber($studentNumber)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM transcation_payments WHERE student_number = ?");
        $stmt->execute([$studentNumber]);
        return $stmt->fetchAll();
    }



    public function createPayment($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO transcation_payments (transaction_id, rec_time, reference, ref_id, created_by, created_at, student_number, transaction_type, reference_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['transaction_id'],
            $data['rec_time'],
            $data['reference'],
            $data['ref_id'],
            $data['created_by'],
            $data['created_at'],
            $data['student_number'],
            $data['transaction_type'],
            $data['reference_key']
        ]);
    }

    public function updatePayment($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE transcation_payments SET transaction_id = ?, rec_time = ?, reference = ?, ref_id = ?, created_by = ?, created_at = ?, student_number = ?, transaction_type = ?, reference_key = ? WHERE id = ?");
        return $stmt->execute([
            $data['transaction_id'],
            $data['rec_time'],
            $data['reference'],
            $data['ref_id'],
            $data['created_by'],
            $data['created_at'],
            $data['student_number'],
            $data['transaction_type'],
            $data['reference_key'],
            $id
        ]);
    }

    public function deletePayment($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM transcation_payments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
