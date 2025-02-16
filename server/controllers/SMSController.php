<?php
// controllers/SMSController.php

require_once '../models/SMSModel.php';

class SMSController
{
    private $smsModel;

    public function __construct($authToken)
    {
        $this->smsModel = new SMSModel($authToken);
    }

    public function sendSMS($mobile, $senderId = 'Pharma C.', $message = "Waiting..!")
    {
        $response = $this->smsModel->sendSMS($mobile, $senderId, $message);

        if ($response['status'] === 'error') {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $response['message']]);
        } else {
            echo json_encode($response);
        }
    }
}
