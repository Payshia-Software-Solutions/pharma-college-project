<?php
// models/ceylonPharmacy/CareInstruction.php

class CareInstruction
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCareInstructions()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_instruction');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCareInstructionById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_instruction WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getInstructionsByPrescriptionAndCover($presCode, $coverId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_instruction WHERE pres_code LIKE ? AND cover_id = ?');
        $stmt->execute(["%$presCode%", $coverId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createCareInstruction($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_instruction (pres_code, cover_id, content, created_at) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $data['pres_code'],
            $data['cover_id'],
            $data['content'],
            $data['created_at']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCareInstruction($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_instruction SET pres_code = ?, cover_id = ?, content = ?, created_at = ? WHERE id = ?');
        $stmt->execute([
            $data['pres_code'],
            $data['cover_id'],
            $data['content'],
            $data['created_at'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCareInstruction($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_instruction WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
