<?php


// Set CORS headers for every response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("X-Page-Title: API Service");
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

// Access environment variables
$authToken = $_ENV['SMS_AUTH_TOKEN'];
$senderId = $_ENV['SMS_SENDER_ID'];

// Define the path to the template file
$templatePath = __DIR__ . '/../templates/welcome_sms_template.txt';


// Include route files
$assignmentRoutes = require './routes/Assignment/AssignmentRoutes.php';
$submissionRoutes = require './routes/Assignment/submissionRoutes.php';
$appointmentRoutes = require './routes/OtherRoutes/appointmentRoutes.php';
// $eCertificateRoutes = require './routes/OtherRoutes/eCertificateRoutes.php';
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
$certificateEvaluationRoutes = require './routes/CertificationCenter/ccEvaluationRoutes.php';
$parentMainCourseRoutes = require './routes/Course/ParentMainCourseRoutes.php';
$courseModuleRoutes = require './routes/Course/CourseModuleRoutes.php';
$courseOutcomeRoutes = require './routes/Course/CourseOutcomeRoutes.php';
$courseOverviewRoutes = require './routes/Course/courseOverviewRoutes.php';
$tempLmsUserRoutes = require './routes/UserRoutes/tempLmsUserRoutes.php';
$CityRoutes = require './routes/CityRoutes.php';
$StudentValuesRoutes = require './routes/Student/StudentValuesRoutes.php';
$CertificateVerificationRoutes = require './routes/CertificationCenter/CertificateVerificationRoutes.php';
$CeylonPharmacyCriteria = require './routes/CertificateCenter/certificateRoutes.php';
$DeliveryOrdersRoutes = require './routes/Orders/DeliveryOrdersRoutes.php';
$UserCertificatePrintStatusRoutes = require './routes/UserCertificatePrintStatusRoutes/UserCertificatePrintStatusRoutes.php';
$ContactRoutes = require './routes/Contact/ContactRoutes.php';
$EventsPageRoutes = require './routes/EventsPageRoutes.php';
$EmailRoutes = require './routes/EmailRoutes.php';
$TestimonialRoutes = require './routes/TestimonialRoutes.php';
$DistrictsRoutes = require './routes/District/DistrictsRoutes.php';
$ECertificateRoutes = require './routes/ecertificates/ECertificateRoutes.php';
$paymentRequestRoutes = require './routes/PaymentRequests/paymentRequestRoutes.php';

// if (!is_array($paymentRequestRoutes)) { CertificateVerificationRoutes ecertificates  ContactRoutes.php

$DpadRoutes = require './routes/Dpad/DpadRoutes.php';
$SMSRoutes = require './routes/SMSRoutes.php';
$bankRoutes = require './routes/bankRoutes.php';
$ConvocationRegistrationRoutes  = require './routes/ConvocationRegistrationRoutes.php';
$PackageRoutes  = require './routes/PackageRoutes.php';
$CertificateOrderRoutes = require './routes/CertificateOrderRoutes.php';
$convocationRoutes = require './routes/convocationRoutes.php';
$transactionPaymentRoutes = require './routes/transactionPaymentRoutes.php';
// if (!is_array($paymentRequestRoutes)) { CertificateVerificationRoutes ecertificates  ECertificateRoutes


//      throw new Exception("paymentRequestRoutes is not an array");
// }

// Combine all routes

$routes = array_merge(
    $userRoutes,
    $transactionPaymentRoutes,
    $assignmentRoutes,
    $submissionRoutes,
    $appointmentRoutes,
    // $eCertificateRoutes,
    $courseAssignmentRoutes,
    $courseAssignmentSubmissionRoutes,
    $hpSaveAnswerRoutes,
    $reportRoutes,
    $courseRoutes,
    $UserCertificatePrintStatusRoutes,
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
    $certificateEvaluationRoutes,
    $parentMainCourseRoutes,
    $courseModuleRoutes,
    $courseOutcomeRoutes,
    $courseOverviewRoutes,
    $tempLmsUserRoutes,
    $CityRoutes,
    $StudentValuesRoutes,
    $CertificateVerificationRoutes,
    $DeliveryOrdersRoutes,
    $DistrictsRoutes,
    $ECertificateRoutes,
    $ContactRoutes,
    $paymentRequestRoutes,
    $DpadRoutes,
    $SMSRoutes,
    $bankRoutes,
    $studentCourseRoutes,
    $EventsPageRoutes,
    $EmailRoutes,
    $TestimonialRoutes,
    $EventsPageRoutes,
    $ConvocationRegistrationRoutes,
    $PackageRoutes,
    $CertificateOrderRoutes,
    $convocationRoutes
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

    // Convert route URI to regex (without query parameters){trackingNumber} student_number
    $routeRegex = str_replace(

        ['{id}', '{reply_id}', '{post_id}', '{created_by}', '{username}', '{role}', '{assignment_id}', '{course_code}', '{offset}', '{limit}', '{setting_name}', '{course_code}', '{loggedUser}', '{title_id}', '{slug}', '{module_code}', '{value}', '{course_code}', '{studentId}', '{tracking_number}', '{index_number}', '{provinceId}', '{student_number}'],
        ['(\d+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '(\d+)', '(\d+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)', '([a-zA-Z0-9_\-\/]+)',],


        $routeUri
    );

    // Ensure route regex matches the path only, not query parameters
    $routeRegex = "#^" . rtrim($routeRegex, '/') . "/?$#";

    // Debugging output
    // echo ("Checking route: $routeRegex <br>");
    // echo ("Uri : $uri<br>");

    // Check if the method and path match
    if ($method === $routeMethod && preg_match($routeRegex, $uri, $matches)) {

        header("X-Page-Title: API Service");
        // Remove the full match
        array_shift($matches);

        // Debugging output
        error_log("Route matched: $route");

        // Call the handler with matched parameters
        call_user_func_array($handler, $matches);
        exit;
    }
}

// Default 404 response if no match is found
header("HTTP/1.1 404 Not Found");
echo json_encode(['error' => 'Route not found']);
