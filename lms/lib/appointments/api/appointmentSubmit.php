<?php

require '../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

// Capture the form data
$LectueId = $_POST['LectueId'];
$studentIndex = $_POST['LoggedUser'];
$date = $_POST['date'];
$time = $_POST['time'];  // This is in '09:00 AM' format
$reason = $_POST['reason'];
$category = $_POST['category'];

// Convert the time to 24-hour format
$timeObject = DateTime::createFromFormat('h:i A', $time);
$timeIn24HourFormat = $timeObject->format('H:i:s');

// Make the GET request to fetch existing appointments
$response = $client->request('GET', 'http://localhost:8000/appointments/');
$appointments = $response->toArray();

// Get the current length of the appointments array and create a new ID
$arrayLength = count($appointments);
$newAppointmentNumber = $arrayLength + 1;
$appointmentId = 'A' . str_pad($newAppointmentNumber, 3, '0', STR_PAD_LEFT);

// Prepare the data to be sent for the new appointment
$newAppointmentData = [
    'appointment_id' => $appointmentId,
    'student_number' => $studentIndex,
    'booking_date' => $date,
    'booked_time' => $timeIn24HourFormat,  // Use the converted time
    'reason' => $reason,
    'category' => $category,
    'created_at' => date('Y-m-d H:i:s'),  // Current timestamp
    'status' => '1',  // Assuming status is '1' for a new appointment
    'comment' => 'First appointment of the semester',
    'is_active' => true,
    'instructor_id' => $LectueId
];

// Send the POST request to create a new appointment
$postResponse = $client->request('POST', 'http://localhost:8000/appointments/', [
    'json' => $newAppointmentData
]);

// Check the response from the POST request
if ($postResponse->getStatusCode() == 200) {
    // If successful, return JSON response
    echo json_encode([
        'status' => 'success', 
        'message' => 'Appointment confirmed!'
    ]);
} else {
    // Handle error
    echo json_encode([
        'status' => 'error', 
        'message' => 'Failed to create appointment'
    ]);
}
?>