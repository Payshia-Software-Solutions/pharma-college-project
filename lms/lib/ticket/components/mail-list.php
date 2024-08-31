<?php
require_once '../../../include/configuration.php';
include '../../../php_handler/function_handler.php';
include '../methods/functions.php';

$boxTitle = "Tickets Box";
$indexNumber = $_POST['LoggedUser'];
$boxType = $_POST['boxType'];

if ($boxType == 1) {
    $boxTitle = "Tickets Box";
    $ticketList = GetTicketsByUserByStatus($indexNumber, 1);
} else if ($boxType == 2) {
    $boxTitle = "Closed Tickets";
    $ticketList = GetTicketsByUserByStatus($indexNumber, 2);
} else if ($boxType == 3) {
    $boxTitle = "Deleted Tickets";
    $ticketList = GetTicketsByUserByStatus($indexNumber, 3);
}

?>

<div class="row">
    <div class="col-12">
        <h2 class="mt-2 fw-bold"><?= $boxTitle ?></h2>
        <div class="border-bottom mb-3"></div>

        <?php
        if (!empty($ticketList)) {
            foreach ($ticketList as $ticket) {

                $replyText = strip_tags($ticket['ticket']);
        ?>
                <div class="card border-0 shadow-sm rounded-4 mb-3 clickable ticket-mail" onclick="GetMailBody('<?= $ticket['ticket_id'] ?>')">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="profile-image mail-box-profile-img-mini" style="background-image : url('./assets/images/user.png');"></div>
                            </div>
                            <div class="col-10">
                                <h6 class="mb-0"><?= $ticket['subject'] ?></h6>
                                <p class="mb-0 mail-card-text-mini"><?= truncateText($replyText, 100); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
        } else {
            ?>
            <p>No Tickets</p>
        <?php
        }
        ?>

    </div>
</div>