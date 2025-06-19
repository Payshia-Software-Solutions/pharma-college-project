<?php
// models/ConvocationRegistration.php

class ConvocationRegistration
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // Read all registrations
    public function getAllRegistrations()
    {
        $sql = "SELECT 
    cr.*, 
    p.package_name, 
    p.price, 
    p.parent_seat_count, 
    p.garland, 
    p.graduation_cloth, 
    p.photo_package, 
    p.is_active, 
    p.created_at AS package_created_at, 
    p.updated_at AS package_updated_at,
    u.name_on_certificate
FROM convocation_registrations cr
LEFT JOIN packages p ON cr.package_id = p.package_id
LEFT JOIN user_full_details u ON cr.student_number = u.username;
";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountsBySessions()
    {
        $stmt = $this->pdo->prepare("SELECT `session`, COUNT(registration_id) AS `sessionCounts` FROM convocation_registrations GROUP BY `session`");
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdditionalSeatsCountsBySessions($sessionId)
    {
        $stmt = $this->pdo->prepare("SELECT SUM(additional_seats) AS `total_additional_seats` FROM convocation_registrations WHERE `session` = ?");
        $stmt->execute([$sessionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all registrations for a specific course
    public function getRegistrationByStudentNumber($student_number)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE student_number = ?");
        $stmt->execute([$student_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new registration (reference_number set after insert)
    public function createRegistration($student_number, $course_id, $package_id, $event_id = null, $payment_status = 'pending', $payment_amount = null, $registration_status = 'pending', $hash_value = null, $image_path = null, $additional_seats = null, $session = 1)
    {
        // Insert without reference_number initially
        $stmt = $this->pdo->prepare("
            INSERT INTO convocation_registrations (student_number, course_id, package_id, event_id, payment_status, payment_amount, registration_status, hash_value, image_path, additional_seats, session)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$student_number, $course_id, $package_id, $event_id, $payment_status, $payment_amount, $registration_status, $hash_value, $image_path, $additional_seats, $session]);

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


    // Validate duplicate registration
    public function validateDuplicate($student_number)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE student_number = ?");
        $stmt->execute([$student_number]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkHashDupplicate($generated_hash)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE hash_value = ?");
        $stmt->execute([$generated_hash]);
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

    public function getPayableAmount($reference_number)
    {
        $stmt = $this->pdo->prepare("SELECT 
        cr.*, 
        p.package_name, 
        p.price, 
        p.parent_seat_count, 
        p.garland, 
        p.graduation_cloth, 
        p.photo_package, 
        p.is_active, 
        p.created_at AS package_created_at, 
        p.updated_at AS package_updated_at
    FROM convocation_registrations cr
    LEFT JOIN packages p ON cr.package_id = p.package_id
    WHERE cr.reference_number = ?");

        $stmt->execute([$reference_number]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // or throw an exception if preferred
        }

        $dueAmount = $row['price'] + ($row['additional_seats'] * 500);
        return $dueAmount;
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

    // Update only the registration_status of a registration
    public function updateRegistrationStatus($reference_number, $registration_status)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET registration_status = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$registration_status, $reference_number]);
    }

    public function updatePayment($reference_number, $payment_status, $payment_amount)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET registration_status = ?, payment_amount = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$payment_status, $payment_amount, $reference_number]);
    }


    public function updateSession($reference_number, $session)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET session = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$session, $reference_number]);
    }

    public function updateAdditionalSeats($reference_number, $additional_seats)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET additional_seats = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$additional_seats, $reference_number]);
    }

    public function updatePackages($reference_number, $package_id)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET package_id = ?
        WHERE reference_number = ?

    ");
        return $stmt->execute([$package_id, $reference_number]);
    }

    public function GetListbyCourseAndSession($courseId, $session)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE FIND_IN_SET(?, course_id) AND `session` = ?");
        $stmt->execute([$courseId, $session]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetListbyCourse($courseId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE FIND_IN_SET(?, course_id)");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetListbySession($session)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM convocation_registrations WHERE `session` = ?");
        $stmt->execute([$session]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCeremonyNumber($reference_number, $ceremony_number)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET ceremony_number = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$ceremony_number, $reference_number]);
    }


    public function updateCertificatePrintStatus($certificate_print_status, $certificate_id, $reference_number)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET certificate_print_status = ?, certificate_id = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$certificate_print_status, $certificate_id, $reference_number]);
    }

    // Update advanced certificate print status
    public function updateAdvancedCertificatePrintStatus($advanced_print_status, $advancedcertificate_id, $reference_number)
    {
        $stmt = $this->pdo->prepare("
        UPDATE convocation_registrations 
        SET advanced_print_status = ?, advanced_id = ?
        WHERE reference_number = ?
    ");
        return $stmt->execute([$advanced_print_status, $advancedcertificate_id, $reference_number]);
    }
}
// End of ConvocationRegistration class
// Note: This class assumes that the PDO connection is passed to it when instantiated.