<?php
require_once('../../../include/config.php');
include '../../../include/function-update.php';
include '../../../include/lms-functions.php';

include './methods/functions.php'; //Ticket Methods

$FilterKey = $_POST['FilterKey'];
$LoggedUser = $_POST['LoggedUser'];
$studentBatch = $_POST['studentBatch'];

$ticketList = GetTickets();
$CourseBatches = getLmsBatches();
$Locations = GetLocations($link);
$accountDetails = GetAccounts($link);

$ticketCount = count($ticketList);
$ActiveStatus = 0;
?>

<div class="row g-3">

    <?php
    $ticketId = 0;
    if (!empty($ticketList)) {
        foreach ($ticketList as $ticket) {

            $ticketId = $ticket['ticket_id'];
            $ticketAssignments = GetTicketAssignment($ticketId);
            $assignedUser = 'None';
            if (isset($ticketAssignments[0])) {
                if ($ticketAssignments[0]['user_name'] != $LoggedUser && $FilterKey == 'MyTickets') {
                    continue;
                }
                $assignedUser = $ticketAssignments[0]['user_name'];
            }

            if ($assignedUser == 'None' && $FilterKey == 'MyTickets') {
                continue;
            }


            if ($ticket['parent_id'] != 0) {
                $ticketId = $ticket['parent_id'];
                continue;
            }

            $stateCode = $ticket['is_active'];
            $stateArray = GetTicketStatus($stateCode);
            $ticketReplies = GetReplyByTicket($ticketId);
    ?>
            <div class="col-md-4 d-flex ticket-card" data-subject="<?= htmlspecialchars(strtolower($ticket['subject'])) ?>" data-department="<?= htmlspecialchars(strtolower($ticket['department'])) ?>" data-index="<?= htmlspecialchars(strtolower($ticket['index_number'])) ?>">
                <div class="card flex-fill clickable" <?= ($stateCode == 1 || $assignedUser == $LoggedUser) ? "onclick=\"OpenTicket('$ticketId')\"" : '' ?>>

                    <div class="card-body">
                        <h4><?= $ticket['subject'] ?></h4>
                        <div class="d-flex justify-content-between">
                            <div class="left">
                                <div class="">TK<?= str_pad($ticketId, 4, '0', STR_PAD_LEFT); ?></div>
                                <h6><?= $ticket['index_number'] ?></h6>
                            </div>
                            <div class="right">
                                <div class="badge bg-<?= $stateArray['bgColor'] ?>"><?= $stateArray['stateValue'] ?></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="left badge bg-danger">
                                <?= $ticket['department'] ?>
                            </div>
                            <div class="right badge bg-success">
                                <?= $ticket['related_service'] ?>
                            </div>
                        </div>

                        <div class="">
                            <?php
                            if (!empty($ticketReplies)) {
                                echo date("Y-m-d H:i", strtotime($ticketReplies[0]['created_at']));
                            } else {
                                echo date("Y-m-d H:i", strtotime($ticket['created_at']));
                            }
                            ?>

                        </div>
                        <?php
                        if (!empty($ticketReplies)) {
                            $replyText = strip_tags($ticketReplies[0]['ticket']);
                            $readStatus = $ticketReplies[0]['read_status'];

                            if ($readStatus === 'unread') {
                                $readBadgeColor = 'success';
                            } else if ($readStatus === 'read') {
                                $readBadgeColor = 'info';
                            } else if ($readStatus === 'replied') {
                                $readBadgeColor = 'dark';
                            }

                        ?>
                            <span class="text-muted">
                                <?php if ($ticketReplies[0]['index_number'] != $LoggedUser) { ?>
                                    <div class="badge bg-<?= $readBadgeColor ?>"><?= ucwords($readStatus) ?></div>
                                <?php }
                                ?>

                                Replied by <?= $ticketReplies[0]['index_number'] ?>
                            </span>
                            <span class="<?= ($readStatus === 'unread') ? 'fw-bolder' : '' ?>"> <?= truncateText($replyText, 100) ?></span>
                        <?php
                        } else {
                            $readStatus = $ticket['read_status'];

                            if ($readStatus === 'unread') {
                                $readBadgeColor = 'success';
                            } else if ($readStatus === 'read') {
                                $readBadgeColor = 'info';
                            } else if ($readStatus === 'replied') {
                                $readBadgeColor = 'dark';
                            }

                        ?>
                            <p class="<?= ($readStatus === 'unread') ? 'fw-bolder' : '' ?>">
                            <div class="badge bg-<?= $readBadgeColor ?>"><?= ucwords($readStatus) ?></div> <?= truncateText(strip_tags($ticket['ticket']), 100) ?>
                            </p>
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($ticketAssignments[0])) { ?>
                            <div class="badge bg-success"><?= $accountDetails[$assignedUser]['first_name'] ?> <?= $accountDetails[$assignedUser]['last_name'] ?></div>
                        <?php } else {
                            echo "None";
                        } ?>


                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

</div>