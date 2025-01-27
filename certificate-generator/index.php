<?php
header("Content-Type: application/json");

// Check if student_id and course_code are provided
if (!isset($_GET['student_id']) || !isset($_GET['course_code'])) {
    echo json_encode(["validation_result" => ["status" => "error", "message" => "Student ID and Course Code are required."]]);
    exit;
}

$student_id = $_GET['student_id'];
$course_code = $_GET['course_code'];

// Fetch Certificate Data from API (to check if it already exists)
$certificate_api_url = "https://qa-api.pharmacollege.lk/certificate-verification?studentNumber=" . urlencode($student_id) . "&courseCode=" . urlencode($course_code);
$certificate_response = file_get_contents($certificate_api_url);

// Validate API Response
if ($certificate_response === FALSE) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Unable to fetch certificate data for Student ID: " . htmlspecialchars($student_id) . " and Course Code: " . htmlspecialchars($course_code)
        ]
    ]);
    exit;
}

$certificate_data = json_decode($certificate_response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Failed to decode certificate JSON response."
        ]
    ]);
    exit;
}

// Check if the certificate data already exists
if (!empty($certificate_data) && isset($certificate_data[0])) {
    // If certificate exists, return the existing certificate image
    $existing_certificate = $certificate_data[0];  // Assuming the data is an array of certificate records
    echo json_encode([
        "certificate_check" => [
            "status" => "success",
            "message" => "Certificate already generated.",
            "certificate_image" => $existing_certificate['generated_image_name']
        ]
    ]);
    exit;
} else {
    // If no certificate data found, proceed to generate the image
    echo json_encode([
        "certificate_check" => [
            "status" => "info",
            "message" => "Proceeding to generate a new image."
        ]
    ]);
}

// Fetch Student Data from the Student Info API
$student_api_url = "https://qa-api.pharmacollege.lk/certificate-verification?studentNumber=" . urlencode($student_id);
$student_response = file_get_contents($student_api_url);

// Validate Student API Response
if ($student_response === FALSE) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Unable to fetch student data for Student ID: " . htmlspecialchars($student_id)
        ]
    ]);
    exit;
}

$student_data = json_decode($student_response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Failed to decode student JSON response."
        ]
    ]);
    exit;
}

// Extract Name for Certificate
$studentInfo = $student_data['studentInfo'] ?? [];
$name_on_certificate = $studentInfo['name_on_certificate'] ?? 'Unknown Name';

// Certificate Template
$img_path = "images/e-certificate.jpg";
$font_path = realpath("font/Roboto-Black.ttf");

// Check if files exist
if (!file_exists($img_path) || !file_exists($font_path)) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Required files are missing."
        ]
    ]);
    exit;
}

// Load Image
$image = imagecreatefromjpeg($img_path);
if (!$image) {
    echo json_encode([
        "validation_result" => [
            "status" => "error",
            "message" => "Unable to create image from file."
        ]
    ]);
    exit;
}

// Set Text Properties
$text_color = imagecolorallocate($image, 0, 0, 0);
$font_size = 40;
$x = 650;
$y = 570;

// Add Student Name to Certificate
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_path, $name_on_certificate);

// Generate Unique Number
$unique_number = time();

// Define the filename format: eCertificate-{CourseCode}-{StudentID}-{UniqueNumber}.jpg
$file_name = "eCertificate-{$course_code}-{$student_id}-{$unique_number}.jpg";

// Save Certificate in a folder named after the student's name
$folder_name = str_replace(" ", "_", $student_id);
$folder_path = "certificates/" . $folder_name;

// Check if the folder exists, if not, create it
if (!is_dir($folder_path)) {
    mkdir($folder_path, 0777, true); // Create the folder if it doesn't exist
}

// Define the full save path
$save_path = $folder_path . "/" . $file_name;

// Save the image to the specified path
imagejpeg($image, $save_path);
imagedestroy($image);

// --- 🔹 POST Certificate Details to Database ---
$post_data = [
    "student_number" => $student_id,
    "course_code" => $course_code,
    "generated_image_name" => $file_name,
    "unique_number" => $unique_number,
    "created_at" => date('Y-m-d H:i:s'),
    "created_by" => "System"
];

$post_json = json_encode($post_data);
$post_url = "https://qa-api.pharmacollege.lk/ecertificates";

// Initialize cURL session to post the certificate details
$ch = curl_init($post_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$response_data = json_decode($response, true);
// Handle Success or Error Based on Response
if ($http_code == 200 || $http_code == 201 || (isset($response_data['message']) && $response_data['message'] === "Certificate created successfully")) {
    echo json_encode([
        "certificate_generation" => [
            "status" => "success",
            "message" => "Certificate generated and saved!",
            "image_name" => $file_name
        ]
    ]);
} else {
    echo json_encode([
        "certificate_generation" => [
            "status" => "error",
            "message" => "Failed to save certificate details.",
            "response" => $response_data
        ]
    ]);
}
