<?php
// models/ceylonPharmacy/CarePatient.php

class CarePatient
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCarePatients()
    {
        $stmt = $this->pdo->query('SELECT * FROM care_patient');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarePatientById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM care_patient WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCarePatient($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO care_patient (prescription_id, prescription_name, prescription_status, created_at, created_by, Pres_Name, pres_date, Pres_Age, Pres_Method, doctor_name, notes, patient_description, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['prescription_id'],
            $data['prescription_name'],
            $data['prescription_status'],
            $data['created_at'],
            $data['created_by'],
            $data['Pres_Name'],
            $data['pres_date'],
            $data['Pres_Age'],
            $data['Pres_Method'],
            $data['doctor_name'],
            $data['notes'],
            $data['patient_description'],
            $data['address']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCarePatient($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE care_patient SET prescription_id = ?, prescription_name = ?, prescription_status = ?, created_at = ?, created_by = ?, Pres_Name = ?, pres_date = ?, Pres_Age = ?, Pres_Method = ?, doctor_name = ?, notes = ?, patient_description = ?, address = ? WHERE id = ?');
        $stmt->execute([
            $data['prescription_id'],
            $data['prescription_name'],
            $data['prescription_status'],
            $data['created_at'],
            $data['created_by'],
            $data['Pres_Name'],
            $data['pres_date'],
            $data['Pres_Age'],
            $data['Pres_Method'],
            $data['doctor_name'],
            $data['notes'],
            $data['patient_description'],
            $data['address'],
            $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteCarePatient($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM care_patient WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
