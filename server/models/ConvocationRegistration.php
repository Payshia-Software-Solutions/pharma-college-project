<?php
// models/ConvocationRegistration.php

class ConvocationRegistration
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new registration (reference_number set after insert)
    public function createRegistration($student_number, $course_id, $package_id, $event_id = null, $payment_status = 'pending', $payment_amount = null, $registration_status = 'pending', $hash_value = null, $image_path = null)
    {
        // Insert without reference_number initially
        $stmt = $this->pdo->prepare("
            INSERT INTO convocation_registrations (student_number, course_id, package_id, event_id, payment_status, payment_amount, registration_status, hash_value, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$student_number, $course_id, $package_id, $event_id, $payment_status, $payment_amount, $registration_status, $hash_value, $image_path]);

        $registration_id = $this->pdo->lastInsertId();

        // Update reference_number to match registration_id
        $stmt = $this->pdo->prepare("
            UPDATE convocation_registrations 
            SET reference_number = ? 
            WHERE registration_id = ?
        ");
        $stmt->execute([$registration_id, $registration_id]);

        return $registration_id;
    }

    // Read all registrations
    public function getAllRegistrations()
    {
        $stmt = $this->pdo->query("SELECT * FROM convocation_registrations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Validate duplicate registration
    public function validateDuplicate($student_number)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE student_number = ? AND registration_status = 'pending'");
        $stmt->execute([$student_number]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single registration by ID
    public function getRegistrationById($registration_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE registration_id = ?");
        $stmt->execute([$registration_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Read a single registration by reference number (same as ID now)
    public function getRegistrationByReference($reference_number)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE reference_number = ?");
        $stmt->execute([$reference_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a registration
    public function updateRegistration($registration_id, $student_number, $course_id, $package_id, $event_id, $payment_status, $payment_amount, $registration_status)
    {
        $stmt = $this->pdo->prepare("
            UPDATE convocation_registrations 
            SET student_number = ?, course_id = ?, package_id = ?, event_id = ?, payment_status = ?, payment_amount = ?, registration_status = ?
            WHERE registration_id = ?
        ");
        return $stmt->execute([$student_number, $course_id, $package_id, $event_id, $payment_status, $payment_amount, $registration_status, $registration_id]);
    }

    // Delete a registration
    public function deleteRegistration($registration_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM convocation_registrations WHERE registration_id = ?");
        return $stmt->execute([$registration_id]);
    }
}
