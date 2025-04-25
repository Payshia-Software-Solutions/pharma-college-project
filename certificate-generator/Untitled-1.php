<?php
header("Content-Type: application/json");

// Load dependencies
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/ftp.php';

use Dotenv\Dotenv;
use chillerlan\QRCode\{QRCode, QROptions};

// Initialize environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$api_url = $_ENV['API_URL'];
$ftp_config = require __DIR__ . '/config/ftp.php';

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
imagecopy($image, $qrImage, 50, 850, 0, 0, imagesx($qrImage), imagesy($qrImage));

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

// Load FTP credentials
$ftp_server = $ftp_config['ftp_server'];
$ftp_username = $ftp_config['ftp_username'];
$ftp_password = $ftp_config['ftp_password'];
$ftp_port = $ftp_config['ftp_port'];

// Define FTP target path
$ftp_target_dir = '/content-provider/certificates/e-certificate/' . $student_id . '/';
$ftp_target_file = $ftp_target_dir . $file_name;

// Establish FTP connection
$conn_id = ftp_connect($ftp_server, $ftp_port);
if (!$conn_id) {
    echo json_encode(["error" => "Could not connect to FTP server."]);
    exit;
}

// Login to FTP
if (!ftp_login($conn_id, $ftp_username, $ftp_password)) {
    echo json_encode(["error" => "FTP login failed."]);
    ftp_close($conn_id);
    exit;
}

// Enable passive mode
ftp_pasv($conn_id, true);

// Ensure FTP directory exists
function ensureFtpDirExists($conn_id, $ftp_target_dir) {
    $dirs = explode('/', trim($ftp_target_dir, '/'));
    $path = '';
    foreach ($dirs as $dir) {
        $path .= '/' . $dir;
        if (!@ftp_chdir($conn_id, $path)) {
            ftp_mkdir($conn_id, $path);
        }
    }
    ftp_chdir($conn_id, '/'); // Reset to root
}
ensureFtpDirExists($conn_id, $ftp_target_dir);

// Upload the file
$ftp_upload_success = ftp_put($conn_id, $ftp_target_file, $save_path, FTP_BINARY);

if ($ftp_upload_success) {
    echo json_encode(["success" => "Certificate uploaded to FTP!", "ftp_path" => $ftp_target_file]);
} else {
    echo json_encode(["error" => "FTP upload failed."]);
}

// Close FTP connection
ftp_close($conn_id);

// --- POST Certificate Details to Database ---
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

// Send Final Response
if ($ftp_upload_success && ($http_code == 200 || $http_code == 201)) {
    echo json_encode(["success" => "Certificate generated, saved, and uploaded!", "image_name" => $file_name]);
} else {
    echo json_encode(["error" => "Failed to upload certificate."]);
}

?>
