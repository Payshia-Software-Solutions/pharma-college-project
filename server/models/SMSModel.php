<?php
// models/SMSModel.php

class SMSModel
{
    private $authToken;

    public function __construct($authToken)
    {
        $this->authToken = $authToken;
    }

    public function sendWelcomeSMS($mobile, $studentName, $referenceNumber)
    {
        // SMS Template
        $message = "Hello $studentName,\nYour Reference number is $referenceNumber.\n\nThank you,\nCeylon Pharma College";

        // Send SMS
        return $this->sendSMS($mobile, 'Pharma C.', $message);
    }

    public function sendSMS($mobile, $senderId = 'Pharma C.', $message = "Waiting..!")
    {
        $msgdata = [
            "recipient" => $mobile,
            "sender_id" => $senderId,
            "message" => $message
        ];

        $curl = curl_init();

        // Disable SSL verification if running locally without HTTPS
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://sms.send.lk/api/v3/sms/send",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($msgdata),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer {$this->authToken}",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['status' => 'error', 'message' => $err];
        } else {
            $responseArray = json_decode($response, true);
            return $responseArray;
        }
    }
}
