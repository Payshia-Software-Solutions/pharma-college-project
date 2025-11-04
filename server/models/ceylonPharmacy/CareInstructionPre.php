<?php
// models/ceylonPharmacy/CareInstructionPre.php

class CareInstructionPre
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCareInstructionPres()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_instruction_pre');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCareInstructionPreById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_instruction_pre WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCareInstructionPre($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_instruction_pre (created_by, instruction, created_at) VALUES (?, ?, ?)');
        $stmt->execute([
            $data['created_by'],
            $data['instruction'],
            $data['created_at']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCareInstructionPre($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_instruction_pre SET created_by = ?, instruction = ?, created_at = ? WHERE id = ?');
        $stmt->execute([
            $data['created_by'],
            $data['instruction'],
            $data['created_at'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCareInstructionPre($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_instruction_pre WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
