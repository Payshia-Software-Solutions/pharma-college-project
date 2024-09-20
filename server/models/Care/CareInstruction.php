<?php
// models/Care/CareInstruction.php

class CareInstruction
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCareInstructions()
    {
        $stmt = $this->pdo->query("SELECT * FROM care_instruction");
        return $stmt->fetchAll();
    }

    public function getCareInstructionById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM care_instruction WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createCareInstruction($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO care_instruction (pres_code, cover_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['pres_code'],
            $data['cover_id'],
            $data['content']
        ]);
    }

    public function updateCareInstruction($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE care_instruction SET pres_code = ?, cover_id = ?, content = ? WHERE id = ?");
        return $stmt->execute([
            $data['pres_code'],
            $data['cover_id'],
            $data['content'],
            $id
        ]);
    }

    public function deleteCareInstruction($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM care_instruction WHERE id = ?");
        return $stmt->execute([$id]);
    }
}