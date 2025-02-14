<?php
header("Content-Type: application/json");
// Allow from any origin
header("Access-Control-Allow-Origin: *"); // For all domains. Adjust as needed.

// Allow the HTTP methods you want to support (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow the headers you need
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS request (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

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

// Store responses
$response_data = [];

// Check if student_id and course_code are provided
if (!isset($_GET['student_id']) || !isset($_GET['course_code'])) {
    $response_data["error"] = "Student ID and Course Code are required.";
    echo json_encode($response_data);
    exit;
}

$student_id = $_GET['student_id'];
$course_code = $_GET['course_code'];

// Fetch Certificate Data from API
$certificate_api_url = $api_url . "/ecertificate-verification?studentNumber=" . urlencode($student_id) . "&courseCode=" . urlencode($course_code);
$certificate_response = file_get_contents($certificate_api_url);

if ($certificate_response === FALSE) {
    $response_data["error"] = "Unable to fetch certificate data.";
} else {
    $certificate_data = json_decode($certificate_response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $response_data["error"] = "Failed to decode certificate JSON response.";
    } elseif (!empty($certificate_data) && isset($certificate_data[0])) {
        $response_data["message"] = "Certificate already generated.";
        $response_data["certificate_image_name"] = $certificate_data[0]['generated_image_name'];
    }
}

// If certificate already exists, return immediately
if (!empty($response_data)) {
    echo json_encode($response_data);
    exit;
}

// Fetch Student Data
$student_api_url = $api_url . "/certificate-verification?studentNumber=" . urlencode($student_id);
$student_response = file_get_contents($student_api_url);

if ($student_response === FALSE) {
    $response_data["error"] = "Unable to fetch student data.";
} else {
    $student_data = json_decode($student_response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $response_data["error"] = "Failed to decode student JSON response.";
    } else {
        $studentInfo = $student_data['studentInfo'] ?? [];
        $name_on_certificate = $studentInfo['name_on_certificate'] ?? 'Unknown Name';
    }
}

// Certificate Template
$img_path = "images/e-certificate.jpg";
$font_path = realpath("font/Roboto-Black.ttf");

if (!file_exists($img_path) || !file_exists($font_path)) {
    $response_data["error"] = "Required files are missing.";
} else {
    // Load Image
    $image = imagecreatefromjpeg($img_path);
    if (!$image) {
        $response_data["error"] = "Unable to create image from file.";
    } else {
        // Set Text Properties
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $font_size = 40;
        $text_dimensions = imagettfbbox($font_size, 0, $font_path, $name_on_certificate);
        $text_width = $text_dimensions[4] - $text_dimensions[0];
        $text_x = intval((imagesx($image) - $text_width) / 2);
        $text_y = 570;

        imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font_path, $name_on_certificate);

        // Generate Unique Number
        $unique_number = time();

        // Generate QR Code
        $qr_text = "https://pharmacollege.lk/result-view.php?LoggedUser=" . $student_id . "&CourseCode=" . $course_code;
        $options = new QROptions;
        $options->outputType = QRCode::OUTPUT_IMAGE_JPG;
        $options->eccLevel = QRCode::ECC_H;
        $options->scale = 5;

        $qrCode = (new QRCode($options))->render($qr_text);
        $qrImage = imagecreatefromstring(base64_decode(str_replace('data:image/jpg;base64,', '', $qrCode)));

        if (!$qrImage) {
            $response_data["error"] = "Failed to generate QR code.";
        } else {
            imagecopy($image, $qrImage, 50, 850, 0, 0, imagesx($qrImage), imagesy($qrImage));

            // Define filename and save path
            $file_name = "eCertificate-{$course_code}-{$student_id}-{$unique_number}.jpg";
            $folder_path = "certificates/" . str_replace(" ", "_", $student_id);

            if (!is_dir($folder_path)) {
                mkdir($folder_path, 0777, true);
            }

            $save_path = $folder_path . "/" . $file_name;
            imagejpeg($image, $save_path);
            imagedestroy($image);

            $response_data["success"] = "Certificate generated successfully.";
            $response_data["certificate_image_name"] = $file_name;
            $response_data["certificate_path"] = $save_path;
        }
    }
}

// FTP Upload
$conn_id = ftp_connect($ftp_config['ftp_server'], $ftp_config['ftp_port']);
if ($conn_id) {
    if (ftp_login($conn_id, $ftp_config['ftp_username'], $ftp_config['ftp_password'])) {
        ftp_pasv($conn_id, true);

        $ftp_target_dir = '/content-provider/certificates/e-certificate/' . $student_id . '/';
        $ftp_target_file = $ftp_target_dir . $file_name;

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
        $ftp_upload_success = ftp_put($conn_id, $ftp_target_file, $save_path, FTP_BINARY);

        if ($ftp_upload_success) {
            $response_data["ftp_status"] = "Certificate uploaded to FTP.";
            $response_data["ftp_path"] = $ftp_target_file;
        } else {
            $response_data["error"] = "FTP upload failed.";
        }

        ftp_close($conn_id);
    } else {
        $response_data["error"] = "FTP login failed.";
    }
} else {
    $response_data["error"] = "Could not connect to FTP server.";
}

// Post Certificate Details to Database
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

if ($http_code == 200 || $http_code == 201) {
    $response_data["database_status"] = "Certificate details saved in the database.";
} else {
    $response_data["error"] = "Failed to save certificate details in database.";
}

// Return final response
echo json_encode($response_data);
?>
