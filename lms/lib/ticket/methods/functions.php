<?php

include __DIR__ . '../../../../include/configuration.php'; // Database Configuration

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function truncateText($text, $maxLength = 150)
{
    // Check if the text length exceeds the maximum length
    if (strlen($text) > $maxLength) {
        // Truncate the text to the maximum length
        $shortText = substr($text, 0, $maxLength);
        // Find the last space within the truncated text
        $lastSpace = strrpos($shortText, ' ');
        // Create the short text by removing any incomplete words
        $shortText = substr($shortText, 0, $lastSpace) . '...';
        // Return the short text with a "Read more" link
        return "$shortText";
    } else {
        // If the text is already shorter than the maximum length, return it as is
        return $text;
    }
}


function SaveTicket($ticketId, $indexNumber, $ticketSubject, $ticketDepartment, $relatedService, $ticketInfo, $attachmentList, $isActive, $toIndexNumber, $readStatus, $parentId)
{
    global $pdo;

    try {
        $current_time = date("Y-m-d H:i:s");

        if ($ticketId == 0) {
            $stmt = $pdo->prepare("INSERT INTO `support_ticket` (`index_number`, `subject`, `department`, `related_service`, `ticket`, `attachments`, `created_at`, `is_active`, `to_index_number`, `read_status`, `parent_id`) VALUES (:index_number, :ticket_subject, :department, :related_service, :ticket, :attachments, :created_at, :is_active, :to_index_number,:read_status, :parent_id)");
        } else {
            $stmt = $pdo->prepare("UPDATE `support_ticket`  SET `index_number`= :pres_name, `subject`= :pres_name, `department`= :pres_name, `related_service`= :pres_name, `ticket`= :pres_name, `attachments`= :pres_name, `created_at`= :pres_name, `is_active`= :pres_name WHERE `ticket_id ` = :ticket_id");
        }

        $stmt->bindParam(':index_number', $indexNumber);
        $stmt->bindParam(':ticket_subject', $ticketSubject);
        $stmt->bindParam(':department', $ticketDepartment);
        $stmt->bindParam(':related_service', $relatedService);
        $stmt->bindParam(':ticket', $ticketInfo);
        $stmt->bindParam(':attachments', $attachmentList);
        $stmt->bindParam(':created_at', $current_time);
        $stmt->bindParam(':is_active', $isActive);
        $stmt->bindParam(':to_index_number', $toIndexNumber);
        $stmt->bindParam(':read_status', $readStatus);
        $stmt->bindParam(':parent_id', $parentId);



        $stmt->execute();

        // SMS Send
        $messageText = 'Dear ' . $indexNumber . '
Your Ticket Submitted Successfully.';

        $studentInfo = GetLmsStudentsByUserName($indexNumber);
        SentSMS($studentInfo['telephone_1'], 'Pharma C.', $messageText);

        return array('status' => 'success', 'message' => 'Ticket Saved successfully');
    } catch (PDOException $e) {
        return array('status' => 'error', 'message' => 'Something went wrong: ' . $e->getMessage());
    }
}


function GetTickets()
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `support_ticket` WHERE `parent_id` LIKE 0 ORDER BY `ticket_id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['ticket_id']] = $row;
        }
    }
    return $ArrayResult;
}

function GetTicketsByUser($indexNumber)
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `support_ticket` WHERE `index_number` LIKE '$indexNumber' ORDER BY `ticket_id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['ticket_id']] = $row;
        }
    }
    return $ArrayResult;
}



function GetTicketsByUserByStatus($indexNumber, $ticketStatus)
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `support_ticket` WHERE `index_number` LIKE '$indexNumber' AND `is_active` LIKE '$ticketStatus' AND `parent_id` LIKE 0 ORDER BY `ticket_id` DESC";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['ticket_id']] = $row;
        }
    }
    return $ArrayResult;
}


function GetTicketsById($ticketId)
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `support_ticket` WHERE `ticket_id` LIKE '$ticketId'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['ticket_id']] = $row;
        }
    }
    return $ArrayResult[$ticketId];
}



function GetReplyByTicket($ticketId)
{
    global $link;

    $ArrayResult = array();
    $sql = "SELECT * FROM `support_ticket` WHERE `parent_id` LIKE '$ticketId'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ArrayResult[$row['ticket_id']] = $row;
        }
    }
    return $ArrayResult;
}


function UpdateTicketStatus($ticketId, $ticketStatus)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE `support_ticket` SET `is_active`= :is_active WHERE `ticket_id` = :ticket_id");

        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->bindParam(':is_active', $ticketStatus);

        $stmt->execute();

        return array('status' => 'success', 'message' => 'Ticket Status Updated successfully');
    } catch (PDOException $e) {
        return array('status' => 'error', 'message' => 'Something went wrong: ' . $e->getMessage());
    }
}


function RateReply($ticketId, $rateValue)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE `support_ticket` SET `rating_value`= :rating_value WHERE `ticket_id` = :ticket_id");

        $stmt->bindParam(':ticket_id', $ticketId);
        $stmt->bindParam(':rating_value', $rateValue);

        $stmt->execute();

        return array('status' => 'success', 'message' => 'Thank you for your Rating!');
    } catch (PDOException $e) {
        return array('status' => 'error', 'message' => 'Something went wrong: ' . $e->getMessage());
    }
}
