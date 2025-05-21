<?php
// models/Assignment/AssignmentSubmission.php

class AssignmentSubmission
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSubmissions()
    {
        $stmt = $this->pdo->query("SELECT * FROM assignment_submittion");
        return $stmt->fetchAll();
    }

    public function getSubmissionById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM assignment_submittion WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getSubmissionsByAssignmentId($assignmentId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM assignment_submittion WHERE assignment_id = ?");
        $stmt->execute([$assignmentId]);
        return $stmt->fetchAll();
    }


    public function getSubmissionsByStudentNumber($studentNumber)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM assignment_submittion WHERE created_by = ?");
        $stmt->execute([$studentNumber]);

        $resultArray = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultArray[$row['assignment_id']] = $row;
        }

        return $resultArray;
    }

    public function createSubmission($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO assignment_submittion (assignment_id, file_path, created_by, created_at, status, grade) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['assignment_id'],
            $data['file_path'],
            $data['created_by'],
            $data['created_at'],
            $data['status'],
            $data['grade']
        ]);
    }

    public function updateSubmission($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE assignment_submittion SET assignment_id = ?, file_path = ?, created_by = ?, created_at = ?, status = ?, grade = ? WHERE id = ?");
        return $stmt->execute([
            $data['assignment_id'],
            $data['file_path'],
            $data['created_by'],
            $data['created_at'],
            $data['status'],
            $data['grade'],
            $id
        ]);
    }

    public function deleteSubmission($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM assignment_submittion WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
