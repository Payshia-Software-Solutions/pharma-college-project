<?php
// models/ceylonPharmacy/CareAnswer.php

class CareAnswer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAnswerByPrescriptionAndCover($presId, $coverId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer WHERE pres_id = ? AND cover_id = ?');
        $stmt->execute([$presId, $coverId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ... other methods
}
