<?php
// server/models/ceylonPharmacy/CareAnswerSubmit.php

class CareAnswerSubmit
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer_submit');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_answer_submit WHERE answer_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_answer_submit (pres_id, cover_id, date, name, drug_name, drug_type, drug_qty, morning_qty, afternoon_qty, evening_qty, night_qty, meal_type, using_type, at_a_time, hour_qty, additional_description, created_by, answer_status, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$data['pres_id'], $data['cover_id'], $data['date'], $data['name'], $data['drug_name'], $data['drug_type'], $data['drug_qty'], $data['morning_qty'], $data['afternoon_qty'], $data['evening_qty'], $data['night_qty'], $data['meal_type'], $data['using_type'], $data['at_a_time'], $data['hour_qty'], $data['additional_description'], $data['created_by'], $data['answer_status'], $data['score']]);
        return $this->pdo->lastInsertId();
    }
    
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_answer_submit SET pres_id = ?, cover_id = ?, date = ?, name = ?, drug_name = ?, drug_type = ?, drug_qty = ?, morning_qty = ?, afternoon_qty = ?, evening_qty = ?, night_qty = ?, meal_type = ?, using_type = ?, at_a_time = ?, hour_qty = ?, additional_description = ?, created_by = ?, answer_status = ?, score = ? WHERE answer_id = ?');
        return $stmt->execute([$data['pres_id'], $data['cover_id'], $data['date'], $data['name'], $data['drug_name'], $data['drug_type'], $data['drug_qty'], $data['morning_qty'], $data['afternoon_qty'], $data['evening_qty'], $data['night_qty'], $data['meal_type'], $data['using_type'], $data['at_a_time'], $data['hour_qty'], $data['additional_description'], $data['created_by'], $data['answer_status'], $data['score'], $id]);
    }


    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_answer_submit WHERE answer_id = ?');
        return $stmt->execute([$id]);
    }
    
    public function checkExistingCorrectSubmission($coverID, $prescriptionID, $LoggedUser)
    {
        $stmt = $this->pdo->prepare('SELECT answer_id FROM care_answer_submit WHERE cover_id = ? AND pres_id = ? AND answer_status = "Correct" AND created_by = ?');
        $stmt->execute([$coverID, $prescriptionID, $LoggedUser]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSubmission($data)
    {
        // Generate new answer submit code
        $stmt = $this->pdo->prepare('SELECT COUNT(answer_id) as count FROM care_answer_submit');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $previous_code = $row['count'];
        $NewAnswerSubmitCode = "UA" . ($previous_code + 1);

        $stmt = $this->pdo->prepare('INSERT INTO `care_answer_submit`(`answer_id`, `pres_id`, `cover_id`, `date`, `name`, `drug_name`, `drug_type`, `drug_qty`, `morning_qty`, `afternoon_qty`, `evening_qty`, `night_qty`, `meal_type`, `using_type`, `at_a_time`, `hour_qty`, `additional_description`, `created_by`, `answer_status`, `score`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$NewAnswerSubmitCode, $data['pres_id'], $data['cover_id'], $data['date'], $data['name'], $data['drug_name'], $data['drug_type'], $data['drug_qty'], $data['morning_qty'], $data['afternoon_qty'], $data['evening_qty'], $data['night_qty'], $data['meal_type'], $data['using_type'], $data['at_a_time'], $data['hour_qty'], $data['additional_description'], $data['created_by'], $data['answer_status'], $data['score']]);
    }
}
