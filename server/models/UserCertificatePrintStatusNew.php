<?php
// models/CertificationCenter/UserCertificatePrintStatus.php

require_once 'helpers/CertificateHelper.php';

class UserCertificatePrintStatusNew
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllStatuses()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user_certificate_print_status`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatusById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `user_certificate_print_status` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createStatus($data)
    {
        // Automatically generate certificate_id if not provided
        if (!isset($data['certificate_id'])) {
            if ($data['type'] === 'Transcript') {
                $data['certificate_id'] = $this->generateCertificateId('Transcript', 'CTR');
            } elseif ($data['type'] === 'Certificate') {
                $data['certificate_id'] = $this->generateCertificateId('Certificate', 'CREF');
            } else {
                $data['certificate_id'] = $this->generateCertificateId('Workshop-Certificate', 'WC');
            }
        }


        if (empty($data['print_date'])) {
            $data['print_date'] = date('Y-m-d H:i:s'); // Or just 'Y-m-d' if only date is needed
        }

        $stmt = $this->pdo->prepare("INSERT INTO `user_certificate_print_status` (`student_number`, `certificate_id`, `print_date`, `print_status`, `print_by`, `type`, `course_code`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['student_number'],
            $data['certificate_id'],
            $data['print_date'],
            $data['print_status'],
            $data['print_by'],
            $data['type'],
            $data['course_code']
        ]);
    }

    // Generates a certificate ID with prefix and incrementing number
    private function generateCertificateId($type, $prefix)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(id) AS total FROM user_certificate_print_status WHERE `type` = ?");
        $stmt->execute([$type]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $count = isset($row['total']) ? (int)$row['total'] + 1 : 1;

        // Example: CREF001, CTR023, WC015
        return $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
    }


    public function updateStatus($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `user_certificate_print_status` SET `student_number` = ?, `certificate_id` = ?, `print_date` = ?, `print_status` = ?, `print_by` = ?, `type` = ?, `course_code` = ? WHERE `id` = ?");
        $stmt->execute([
            $data['student_number'],
            $data['certificate_id'],
            $data['print_date'],
            $data['print_status'],
            $data['print_by'],
            $data['type'],
            $data['course_code'],
            $id
        ]);
    }

    public function deleteStatus($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `user_certificate_print_status` WHERE `id` = ?");
        $stmt->execute([$id]);
    }
}
