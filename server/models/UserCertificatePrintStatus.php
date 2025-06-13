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
        // Automatically generate certificate_id based on type
        if (!isset($data['certificate_id'])) {
            switch ($data['type']) {
                case 'Transcript':
                    $data['certificate_id'] = GenerateCertificateId('Transcript', 'CTR');
                    break;
                case 'Certificate':
                    $data['certificate_id'] = GenerateCertificateId('Certificate', 'CREF');
                    break;
                default:
                    $data['certificate_id'] = GenerateCertificateId('Workshop-Certificate', 'WC');
                    break;
            }
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
