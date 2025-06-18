<?php

$start = 1;
$end = 10;
$batchSize = 10;

$baseUrl = "https://qa-api.pharmacollege.lk/convocation-registrations/notify-ceremony?referenceNumber="; // Replace with your actual API endpoint

for ($i = $start; $i <= $end; $i += $batchSize) {


    for ($j = $i; $j < $i + $batchSize && $j <= $end; $j++) {
        $url = $baseUrl . $j;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Separate headers and body
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);

        curl_close($ch);

        echo "ID: $j | Status: $httpCode | Sent: $url<br>";
    }
    // Optional sleep between batches
    sleep(1); // Delay 1 second between batches to avoid hitting the server too hard
}
