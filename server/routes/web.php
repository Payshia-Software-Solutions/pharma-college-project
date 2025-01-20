<?php
// Set CORS headers for every response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Handle OPTIONS requests (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}


ini_set('memory_limit', '256M');

// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the browser (for development)
ini_set('display_errors', 1);
// routes/web.php

// Include route files
$assignmentRoutes = require './routes/OtherRoutes/assignmentRoutes.php';
$appointmentRoutes = require './routes/OtherRoutes/appointmentRoutes.php';
$eCertificateRoutes = require './routes/OtherRoutes/eCertificateRoutes.php';
$courseAssignmentRoutes = require './routes/OtherRoutes/courseAssignmentRoutes.php';
$courseAssignmentSubmissionRoutes = require './routes/OtherRoutes/courseAssignmentSubmissionRoutes.php';
$reportRoutes = require './routes/OtherRoutes/reportRoutes.php';
$studentCourseRoutes = require './routes/OtherRoutes/studentCourseRoutes.php';
$userRoutes = require './routes/UserRoutes/userRoutes.php';
$userFullDetailsRoutes = require './routes/UserRoutes/userFullDetailsRoutes.php';
$companyRoutes = require './routes/OtherRoutes/companyRoutes.php';
$hpSaveAnswerRoutes = require './routes/HunterPro/hpSaveAnswerRoutes.php';
$hpCourseMedicineRoutes = require './routes/HunterPro/hpCourseMedicineRoutes.php';
$hpMedicinesRoutes = require './routes/HunterPro/hpMedicinesRoutes.php';
$hpCategoriesRoutes = require './routes/HunterPro/hpCategoriesRoutes.php';
$hpDosageFormsRoutes = require './routes/HunterPro/hpDosageFormsRoutes.php';
$hpDrugTypesRoutes = require './routes/HunterPro/hpDrugTypesRoutes.php';
$hpRacksRoutes = require './routes/HunterPro/hpRacksRoutes.php';
$appointmentCategoryRoutes = require './routes/OtherRoutes/appointmentCategoryRoutes.php';
$hunterSettingRoutes = require './routes/Hunter/hunterSettingRoutes.php';
$hunterCategoryRoutes = require './routes/Hunter/hunterCategoryRoutes.php';
$hunterCourseRoutes = require './routes/Hunter/hunterCourseRoutes.php';
$hunterDosageRoutes = require './routes/Hunter/hunterDosageRoutes.php';
$hunterDrugGroupRoutes = require './routes/Hunter/hunterDrugGroupRoutes.php';
$hunterMedicineRoutes = require './routes/Hunter/hunterMedicineRoutes.php';
$hunterRacksRoutes = require './routes/Hunter/hunterRacksRoutes.php';
$hunterSaveAnswerRoutes = require './routes/Hunter/hunterSaveAnswerRoutes.php';
$hunterStoreRoutes = require './routes/Hunter/hunterStoreRoutes.php';
$lectureRoutes = require './routes/OtherRoutes/lectureRoutes.php';
$careInstructionRoutes = require './routes/Care/careInstructionRoutes.php';
$careInstructionPreRoutes = require './routes/Care/careInstructionPreRoutes.php';
$chatRoutes = require './routes/Chats/chatRoutes.php';
$chatRoutes = require './routes/Chats/chatRoutes.php';
$attachmentRoutes = require './routes/Chats/attachmentRoutes.php';
$messageRoutes = require './routes/Chats/messageRoutes.php';
$communityPostCategoryRoutes = require './routes/Community/communityPostCategoryRoutes.php';
$communityPostRoutes = require './routes/Community/communityPostRoutes.php';
$communityPostReplyRoutes = require './routes/Community/communityPostReplyRoutes.php';
$communityPostReplyRatingsRoutes = require './routes/Community/communityPostReplyRatingsRoutes.php';
$communityKnowledgebaseRoutes = require './routes/Community/communityKnowledgebaseRoutes.php';
$paymentReasonRoutes = require './routes/Payment/paymentReasonRoutes.php';
$paymentRequestRoutes = require './routes/Payment/paymentRequestRoutes.php';
$courseRoutes = require './routes/Course/courseRoutes.php';
$studentPaymentRoutes = require './routes/Student/studentPaymentRoutes.php';
$supportTicketRoutes = require './routes/TicketRoutes/supportTicketRoutes.php';

$activityLogRoutes = require './routes/OtherRoutes/activitylogsRoutes.php';
$levelRoutes = require './routes/OtherRoutes/levelRoutes.php';
$prescriptionRoutes = require './routes/Prescription/prescriptionRoutes.php';
$prescriptionAnswerRoutes = require './routes/Prescription/prescriptionAnswerRoutes.php';
$prescriptionAnswerSubmissionRoutes = require './routes/Prescription/prescriptionAnswerSubmissionRoutes.php';
$prescriptionContentRoutes = require './routes/Prescription/prescriptionContentRoutes.php';
$winpharmaCommonReasonRoutes = require './routes/Winpharma/winpharmaCommonReasonRoutes.php';
$winPharmaLevelRoutes = require './routes/Winpharma/winPharmaLevelRoutes.php';
$winPharmaLevelResourceRoutes = require './routes/Winpharma/winPharmaLevelResourceRoutes.php';
$winPharmaSubmissionRoutes = require './routes/Winpharma/winPharmaSubmissionRoutes.php';
$qMeterRoutes = require './routes/QMeter/qMeterRoutes.php';
$qMeterOpenRoutes = require './routes/QMeter/qMeterOpenRoutes.php';
$qMeterSubmitRoutes = require './routes/QMeter/qMeterSubmitRoutes.php';
$ccCriteriaGroupRoutes = require './routes/CertificationCenter/ccCriteriaGroupRoutes.php';
$ccCriteriaListRoutes = require './routes/CertificationCenter/ccCriteriaListRoutes.php';
$ccGraduationPackageItemRoutes = require './routes/CertificationCenter/ccGraduationPackageItemRoutes.php';
$ccCertificateListRoutes = require './routes/CertificationCenter/ccCertificateListRoutes.php';
$ccGraduationPackageRoutes = require './routes/CertificationCenter/ccGraduationPackageRoutes.php';
$ccCertificateOrderRoutes = require './routes/CertificationCenter/ccCertificationOrderRoutes.php';
$certtficateUserResultRoutes = require './routes/Certificate/certificateUserResultRoutes.php';
$deliveryOrdersRoutes = require './routes/OtherRoutes/deliveryOrdersRoutes.php';

// if (!is_array($paymentRequestRoutes)) {
//     throw new Exception("paymentRequestRoutes is not an array");
// }
$CeylonPharmacyCriteria = require './routes/CertificateCenter/certificateRoutes.php';

// Combine all routes

$routes = array_merge(
    $userRoutes,
    $assignmentRoutes,
    $appointmentRoutes,
    $eCertificateRoutes,
    $courseAssignmentRoutes,
    $courseAssignmentSubmissionRoutes,
    $hpSaveAnswerRoutes,
    $reportRoutes,
    $courseRoutes,
    $studentCourseRoutes,
    $userFullDetailsRoutes,
    $companyRoutes,
    $hpCourseMedicineRoutes,
    $hpMedicinesRoutes,
    $hpCategoriesRoutes,
    $hpDosageFormsRoutes,
    $hpDrugTypesRoutes,
    $hpRacksRoutes,
    $appointmentCategoryRoutes,
    $hunterSettingRoutes,
    $hunterCategoryRoutes,
    $hunterCourseRoutes,
    $hunterDosageRoutes,
    $hunterDrugGroupRoutes,
    $hunterMedicineRoutes,
    $hunterRacksRoutes,
    $hunterSaveAnswerRoutes,
    $hunterStoreRoutes,
    $lectureRoutes,
    $careInstructionRoutes,
    $careInstructionPreRoutes,
    $chatRoutes,
    $attachmentRoutes,
    $messageRoutes,
    $communityPostCategoryRoutes,
    $communityPostRoutes,
    $communityKnowledgebaseRoutes,
    $communityPostReplyRoutes,
    $communityPostReplyRatingsRoutes,
    $paymentReasonRoutes,
    $paymentRequestRoutes,
    $courseRoutes,
    $studentPaymentRoutes,
    $supportTicketRoutes,
    $activityLogRoutes,
    $levelRoutes,
    $prescriptionRoutes,
    $prescriptionAnswerRoutes,
    $prescriptionAnswerSubmissionRoutes,
    $prescriptionContentRoutes,
    $winpharmaCommonReasonRoutes,
    $winPharmaLevelRoutes,
    $winPharmaLevelResourceRoutes,
    $winPharmaSubmissionRoutes,
    $qMeterRoutes,
    $qMeterOpenRoutes,
    $qMeterSubmitRoutes,
    $ccCriteriaGroupRoutes,
    $ccCriteriaListRoutes,
    $ccGraduationPackageItemRoutes,
    $ccCertificateListRoutes,
    $ccGraduationPackageRoutes,
    $ccCertificateOrderRoutes,
    $CeylonPharmacyCriteria,
    $certtficateUserResultRoutes,
    $deliveryOrdersRoutes
);



// Define the home route with trailing slash
$routes['GET /'] = function () {
    // Serve the index.html file
    readfile('./views/index.html');
};

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/');

// Ensure URI always has a trailing slash
if (substr($uri, -1) !== '/') {
    $uri .= '/';
}

// Determine if the application is running on localhost
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Adjust URI if needed (only on localhost)
    $uri = str_replace('pharma-college-project/server', '', $uri);
} else {
    // Adjust URI if needed (if using a subdirectory)
    $uri = '/' . $uri;
}



// Set the header for JSON responses, except for HTML pages
if ($uri !== '/') {
    header('Content-Type: application/json');
}

// Debugging
error_log("Method: $method");
error_log("URI: $uri");
// echo $uri . '<br>';


// Route matching
foreach ($routes as $route => $handler) {
    list($routeMethod, $routeUri) = explode(' ', $route, 2);

    // Convert route URI to regex
    $routeRegex = str_replace(
        ['{id}', '{reply_id}', '{post_id}', '{created_by}', '{username}', '{role}', '{assignment_id}', '{course_code}', '{offset}', '{limit}', '{setting_name}', '{CourseCode}', '{loggedUser}', '{title_id}'],
        ['(\d+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)'],
        $routeUri
    );

    $routeRegex = "#^" . rtrim($routeRegex, '/') . "/?$#";
    error_log("Checking route: $routeRegex");
    // echo $routeRegex . '<br>';

    if ($method === $routeMethod && preg_match($routeRegex, $uri, $matches)) {
        array_shift($matches); // Remove the full match
        error_log("Route matched: $route");
        call_user_func_array($handler, $matches);
        exit;
    }
}

// Default 404 response
header("HTTP/1.1 404 Not Found");
echo json_encode(['error' => 'Route not found']);
