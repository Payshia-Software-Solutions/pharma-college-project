<?php
// models/Winpharma/WinParmaSubmission.php

class WinPharmaSubmission
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllWinPharmaSubmissions()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `win_pharma_submission`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetSubmissionLevelCount($UserName, $batchCode)
    {

        $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT `level_id`) AS `LevelCount` FROM `win_pharma_submission` WHERE `index_number` LIKE ? AND `course_code` LIKE ? ");

        $stmt->execute([$UserName, $batchCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLevels($CourseCode)
    {
        $ArrayResult = [];

        $sql = "SELECT `level_id`, `course_code`, `level_name`, `is_active`, `created_at`, `created_by` 
                FROM `win_pharma_level` 
                WHERE `course_code` LIKE ? 
                ORDER BY `level_id`";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$CourseCode]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayResult[$row['level_id']] = $row;
        }

        return $ArrayResult;
    }

    // Fetch WinPharma Results
    public function getWinPharmaResults($UserName, $batchCode)
    {
        $levels = $this->getLevels($batchCode);
        $submissionCount = $this->getSubmissionLevelCount($UserName, $batchCode);
        $totalLevels = count($levels);


        if ($totalLevels > 0) {
            $percentage = ($submissionCount['LevelCount'] / $totalLevels) * 100;
        } else {
            $percentage = 0;
        }

        return [
            'total_levels' => $totalLevels,
            'submitted_levels' => $submissionCount,
            'completion_percentage' => $percentage
        ];
    }

    public function getWinPharmaSubmissionById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `win_pharma_submission` WHERE `submission_id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createWinPharmaSubmission($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `win_pharma_submission` (`index_number`, `level_id`, `resource_id`, `submission`, `grade`, `grade_status`, `date_time`, `attempt`, `course_code`, `reason`, `update_by`, `update_at`, `recorrection_count`, `payment_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['index_number'],
            $data['level_id'],
            $data['resource_id'],
            $data['submission'],
            $data['grade'],
            $data['grade_status'],
            $data['date_time'],
            $data['attempt'],
            $data['course_code'],
            $data['reason'],
            $data['update_by'],
            $data['update_at'],
            $data['recorrection_count'],
            $data['payment_status']

        ]);
    }


    public function updateWinPharmaSubmission($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE `win_pharma_submission` SET `submission_id` = ?, `index_number` = ?, `level_id` = ?, `resource_id`= ?, `submission` = ?, `grade` = ?, `grade_status` = ?, `date_time` = ?, `attempt` = ?, `course_code` = ?, `reason` = ?, `update_by` = ?, `update_at` = ?, `recorrection_count` = ?, `payment_status` = ? WHERE `submission_id` = ?");
        $stmt->execute([
            $data['submission_id'],
            $data['index_number'],
            $data['level_id'],
            $data['resource_id'],
            $data['submission'],
            $data['grade'],
            $data['grade_status'],
            $data['date_time'],
            $data['attempt'],
            $data['course_code'],
            $data['reason'],
            $data['update_by'],
            $data['update_at'],
            $data['recorrection_count'],
            $data['payment_status'],
            $id
        ]);
    }

    public function deleteWinPharmaSubmission($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `win_pharma_submission` WHERE `submission_id` = ?");
        $stmt->execute([$id]);
    }
}
