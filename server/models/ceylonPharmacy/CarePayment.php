<?php
// models/ceylonPharmacy/CarePayment.php

class CarePayment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCarePayments()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_payment');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarePaymentById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_payment WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCarePayment($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_payment (PresCode, value, created_at) VALUES (?, ?, ?)');
        $stmt->execute([
            $data['PresCode'],
            $data['value'],
            $data['created_at']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCarePayment($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_payment SET PresCode = ?, value = ?, created_at = ? WHERE id = ?');
        $stmt->execute([
            $data['PresCode'],
            $data['value'],
            $data['created_at'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCarePayment($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_payment WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function getLastRecordByPresCode($presCode)
    {
        $stmt = $this->pdo->prepare("SELECT `id`, `PresCode`, `value`, `created_at` FROM `care_payment` WHERE `PresCode` = ? ORDER BY `id` DESC LIMIT 1");
        $stmt->execute([$presCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
