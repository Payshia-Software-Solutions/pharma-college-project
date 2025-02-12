<?php
header("Content-Type: application/json");

// Load the .env file
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use chillerlan\QRCode\{QRCode, QROptions};

// Initialize the Dotenv instance
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access the API_URL from the .env file
$api_url = $_ENV['API_URL'];

// Check if student_id and course_code are provided
if (!isset($_GET['student_id']) || !isset($_GET['course_code'])) {
    echo json_encode(["error" => "Student ID and Course Code are required."]);
    exit;
}

$student_id = $_GET['student_id'];
$course_code = $_GET['course_code'];

// Fetch Certificate Data from API
$certificate_api_url = $api_url . "/ecertificate-verification?studentNumber=" . urlencode($student_id) . "&courseCode=" . urlencode($course_code);
$certificate_response = file_get_contents($certificate_api_url);

if ($certificate_response === FALSE) {
    echo json_encode(["error" => "Unable to fetch certificate data."]);
    exit;
}

$certificate_data = json_decode($certificate_response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Failed to decode certificate JSON response."]);
    exit;
}

// If certificate already exists, return the details
if (!empty($certificate_data) && isset($certificate_data[0])) {
    echo json_encode([
        "message" => "Certificate already generated.",
        "certificate_image" => $certificate_data[0]['generated_image_name']
    ]);
    exit;
}

// Fetch Student Data
$student_api_url = $api_url . "/certificate-verification?studentNumber=" . urlencode($student_id);
$student_response = file_get_contents($student_api_url);

if ($student_response === FALSE) {
    echo json_encode(["error" => "Unable to fetch student data."]);
    exit;
}

$student_data = json_decode($student_response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Failed to decode student JSON response."]);
    exit;
}

// Extract Name for Certificate
$studentInfo = $student_data['studentInfo'] ?? [];
$name_on_certificate = $studentInfo['name_on_certificate'] ?? 'Unknown Name';

// Certificate Template
$img_path = "images/e-certificate.jpg";
$font_path = realpath("font/Roboto-Black.ttf");

if (!file_exists($img_path) || !file_exists($font_path)) {
    echo json_encode(["error" => "Required files are missing."]);
    exit;
}

// Load Image
$image = imagecreatefromjpeg($img_path);
if (!$image) {
    echo json_encode(["error" => "Unable to create image from file."]);
    exit;
}

// Set Text Properties
$text_color = imagecolorallocate($image, 0, 0, 0);
$font_size = 40;

// Calculate Text Dimensions and Center It Horizontally
$text_dimensions = imagettfbbox($font_size, 0, $font_path, $name_on_certificate);
if (!$text_dimensions) {
    echo json_encode(["error" => "Failed to calculate text dimensions."]);
    exit;
}

$text_width = $text_dimensions[4] - $text_dimensions[0]; // Width of the text
$text_x = intval((imagesx($image) - $text_width) / 2); // Center the text horizontally
$text_y = 570; // Fixed Y-coordinate

// Add Student Name to Certificate
imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font_path, $name_on_certificate);

// Generate Unique Number
$unique_number = time();

// Generate QR Code
$qr_text = "https://pharmacollege.lk/result-view.php?LoggedUser=" . $student_id . "&CourseCode=" . $course_code;
$options = new QROptions;
$options->outputType = QRCode::OUTPUT_IMAGE_JPG;
$options->eccLevel = QRCode::ECC_H;
$options->scale = 5;

// Create QR code image
$qrCode = (new QRCode($options))->render($qr_text);
$qrImage = imagecreatefromstring(base64_decode(str_replace('data:image/jpg;base64,', '', $qrCode)));

if (!$qrImage) {
    echo json_encode(["error" => "Failed to generate QR code."]);
    exit;
}

// Merge QR Code into Certificate
imagecopy($image, $qrImage, 50, 980, 0, 0, imagesx($qrImage), imagesy($qrImage));

// Define filename and save path
$file_name = "eCertificate-{$course_code}-{$student_id}-{$unique_number}.jpg";
$folder_path = "certificates/" . str_replace(" ", "_", $student_id);

if (!is_dir($folder_path)) {
    mkdir($folder_path, 0777, true);
}

$save_path = $folder_path . "/" . $file_name;

// Save Certificate with QR Code
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

$ch = curl_init($api_url . "/ecertificates");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$response_data = json_decode($response, true);

// Send Final Response
if ($http_code == 200 || $http_code == 201 || (isset($response_data['message']) && $response_data['message'] === "Certificate created successfully")) {
    echo json_encode([
        "success" => "Certificate generated and saved!",
        "image_name" => $file_name
    ]);
} else {
    echo json_encode(["error" => "Failed to save certificate details.", "response" => $response_data]);
}

?>
