<?php
function SentSMS($mobile, $senderId = 'Pharma C.', $message = "Waiting..!")
{
    $MSISDN = $mobile;
    $SRC = $senderId;
    $MESSAGE = (urldecode($message));
    $AUTH = "2218|Ysh7ZLYM83rxJc4Reztir1OYD31UppbEmewtbK9p";  //Replace your Access Token

    $msgdata = array("recipient" => $MSISDN, "sender_id" => $SRC, "message" => $MESSAGE);

    $curl = curl_init();

    //IF you are running in locally and if you don't have https/SSL. then uncomment bellow two lines
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sms.send.lk/api/v3/sms/send",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($msgdata),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer $AUTH",
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // Return error information in case of a cURL failure
        return array('status' => 'error', 'message' => $err);
    }

    $responseArray = json_decode($response, true);

    // Handle invalid JSON response
    if (json_last_error() !== JSON_ERROR_NONE) {
        return array('status' => 'error', 'message' => 'Invalid JSON response from server');
    }

    // Return response or error based on the API status
    if (isset($responseArray['status']) && $responseArray['status'] === "success") {
        return array('status' => 'success', 'message' => $responseArray['message']);
    }

    return array('status' => 'error', 'message' => $responseArray['message'] ?? 'Unknown error occurred');
}
