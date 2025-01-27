<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the content type for output
header("Content-type: image/jpeg");

// Set headers for download
header('Content-Disposition: attachment; filename="custom_certificate.jpg"');

// Define paths for the base image and font
$img_path = "images/e-certificate.jpg"; // Ensure this path is correct
$font_path = realpath("font/Roboto-Black.ttf"); // Ensure the font file exists

// Check if the image file exists
if (!file_exists($img_path)) {
    die("Error: Image file not found.");
}

// Check if the font file exists
if (!file_exists($font_path)) {
    die("Error: Font file not found.");
}

// Create an image from the base image
$jpg_img = imagecreatefromjpeg($img_path);
if (!$jpg_img) {
    die("Error: Unable to create image from file.");
}

// Reduce image size
$scaled_width = 1200; // New width for the image
$scaled_height = 800; // New height for the image
$jpg_img = imagescale($jpg_img, $scaled_width, $scaled_height);

// Set text color (black) and font size
$text_color = imagecolorallocate($jpg_img, 0, 0, 0);
$font_size = 20; // Adjusted font size for smaller image

// Define text to overlay
$user_name = isset($_GET['user']) ? $_GET['user'] : 'Guest User';
$text = " " . $user_name;

// Define position for the text (adjust for scaled image)
$x = 500; // Horizontal position
$y = 365; // Vertical position

// Add the text to the image
imagettftext($jpg_img, $font_size, 0, $x, $y, $text_color, $font_path, $text);

// Output the image to the browser for download
imagejpeg($jpg_img);

// Free up memory
imagedestroy($jpg_img);
?>
