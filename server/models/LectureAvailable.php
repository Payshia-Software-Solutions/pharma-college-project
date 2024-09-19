<?php

class LectureAvailable
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllLectures()
    {
        $stmt = $this->pdo->query("SELECT * FROM lecture_available");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableLectures()
{
    $stmt = $this->pdo->query("SELECT * FROM lecture_available WHERE is_available = 1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all available lectures
}


    public function getLectureById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM lecture_available WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createLecture($data)
    {
        $sql = "INSERT INTO lecture_available (is_available, lecture_id) VALUES (:is_available, :lecture_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateLecture($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE lecture_available SET is_available = :is_available, lecture_id = :lecture_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function deleteLecture($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM lecture_available WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}