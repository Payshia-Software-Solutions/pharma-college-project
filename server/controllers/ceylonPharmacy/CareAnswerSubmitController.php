<?php
require_once __DIR__ . '/../../models/ceylonPharmacy/CareAnswerSubmit.php';
require_once __DIR__ . '/../../models/ceylonPharmacy/CareAnswer.php';

class CareAnswerSubmitController
{
    private $pdo;
    private $careAnswerSubmitModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->careAnswerSubmitModel = new CareAnswerSubmit($this->pdo);
    }

    public function getAll()
    {
        $careAnswerSubmits = $this->careAnswerSubmitModel->getAll();
        echo json_encode($careAnswerSubmits);
    }

    public function getById($id)
    {
        $careAnswerSubmit = $this->careAnswerSubmitModel->getById($id);
        echo json_encode($careAnswerSubmit);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->careAnswerSubmitModel->create($data);
        echo json_encode($result);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->careAnswerSubmitModel->update($id, $data);
        echo json_encode($result);
    }

    public function delete($id)
    {
        $result = $this->careAnswerSubmitModel->delete($id);
        echo json_encode($result);
    }

    public function submitAnswer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                $data = $_POST;
            }

            $LoggedUser = $data['LoggedUser'];
            $UserLevel = $data['UserLevel'];

            if ($UserLevel !== 'Student') {
                http_response_code(403);
                echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
                return;
            }

            $prescriptionID = $data['prescriptionID'];
            $coverID = $data['coverID'];

            $fields = [
                'date' => $data['envelope-date'],
                'name' => $data['envelope-name'],
                'drug_name' => $data['envelope-drug-name'],
                'drug_type' => $data['envelope-dosage-form'],
                'drug_qty' => $data['envelope-drug-quantity'],
                'morning_qty' => $data['envelope-morning-quantity'],
                'afternoon_qty' => $data['envelope-afternoon-quantity'],
                'evening_qty' => $data['envelope-evening-quantity'],
                'night_qty' => $data['envelope-night-quantity'],
                'meal_type' => $data['envelope-meal-type'],
                'using_type' => $data['envelope-using-frequency'],
                'at_a_time' => $data['envelope-at-a-time'],
                'hour_qty' => $data['envelope-using-frequency-hour'],
                'additional_description' => $data['envelope-additional-instruction']
            ];

            $careAnswerModel = new CareAnswer($this->pdo);
            $incorrectFields = $careAnswerModel->validateAnswers($fields, $prescriptionID, $coverID);

            $answer_status = empty($incorrectFields) ? "Correct" : "In-Correct";
            $score = empty($incorrectFields) ? 10 : -1;

            $alreadySubmitted = $this->careAnswerSubmitModel->checkExistingCorrectSubmission($coverID, $prescriptionID, $LoggedUser);

            if ($alreadySubmitted) {
                echo json_encode(['status' => 'error', 'message' => 'Already Saved Correct Attempt']);
                return;
            }
            
            $submissionData = array_merge(
                [
                    'pres_id' => $prescriptionID,
                    'cover_id' => $coverID,
                    'created_by' => $LoggedUser,
                    'answer_status' => $answer_status,
                    'score' => $score,
                ],
                $fields
            );


            $result = $this->careAnswerSubmitModel->createSubmission($submissionData);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Answer Saved', 'incorrect_values' => $incorrectFields, 'answer_status' => $answer_status]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.', 'incorrect_values' => $incorrectFields, 'answer_status' => $answer_status]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Invalid Method']);
        }
    }
}
