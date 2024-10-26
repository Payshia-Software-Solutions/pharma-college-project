<?php
require_once '../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];
$ticketId = $_POST['ticketId'];

use Symfony\Component\HttpClient\HttpClient;
use Dotenv\Dotenv; //for use env file data

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$client = HttpClient::create();

$response = $client->request('GET', $_ENV["SERVER_URL"] . '/tickets/' . $ticketId);
$ticketInfo = $response->toArray();


$ticketStatus = $ticketInfo['is_active'];
$attachments = explode(', ', $ticketInfo['attachments']);
?>


<div class="row">
    <div class="col-12">

        <!-- Sender Info -->
        <div class="row">
            <div class="col-6">
                <h6 class="mb-0"><?= $ticketInfo['index_number'] ?></h6>
                <p class="mb-0"><?= $ticketInfo['subject'] ?></p>
            </div>
            <div class="col-12 col-md-6 text-end">
                <div class="btn-group" role="group" aria-label="Basic outlined example">

                    <?php
                    if ($ticketStatus == 1) {
                    ?>
                        <!-- <button onclick="ChangeTicketStatus('<?= $ticketId ?>', '<?= $deleteStatus ?>')" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button> -->
                        <button onclick="ChangeTicketStatus('<?= $ticketId ?>', '<?= $closeStatus ?>')" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-xmark"></i> Close</button>

                        <button onclick="CreateSupportTicketReplyBox('<?= $ticketId ?>')" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-reply"></i> Reply</button>
                    <?php
                    } else if ($ticketStatus == 2) {

                    ?>
                        <button onclick="ChangeTicketStatus('<?= $ticketId ?>', '<?= $activeStatus ?>')" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i> Active</button>
                        <!-- <button onclick="ChangeTicketStatus('<?= $ticketId ?>', '<?= $deleteStatus ?>')" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button> -->
                    <?php
                    } else if ($ticketStatus == 3) {
                    ?>
                        <button onclick="ChangeTicketStatus('<?= $ticketId ?>', '<?= $activeStatus ?>')" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i> Active</button>

                    <?php
                    }

                    ?>

                </div>
            </div>
        </div>
        <div class="border-bottom my-2"></div>

        <div class="card bg-light border-0 rounded-3">
            <div class="card-body ticket-body"><?= $ticketInfo['ticket'] ?></div>
        </div>
        <?php
        if (!empty($attachments)) {
        ?>
            <h6 class="mt-3">Attachments</h6>
            <?php
            foreach ($attachments as $attachment) {
            ?>
                <p class="mb-0"><a href="./lib/ticket/assets/ticket_img/<?= $attachment ?>" target="_blank"><?= $attachment ?></a></p>
        <?php
            }
        }
        ?>
        <div class="border-bottom my-2"></div>
        <?php
        if (!empty($ticketReplies)) {
            foreach ($ticketReplies as $replyArray) {

                $rateValue = $replyArray['rating_value'];
        ?>
                <div class="card bg-light border-0 rounded-3 my-3">
                    <div class="card-body ticket-body">
                        <p class="border-bottom mb-2 text-muted"><?= $replyArray['index_number'] ?></p>
                        <?= $replyArray['ticket'] ?>

                        <?php
                        if ($replyArray['index_number'] != $loggedUser) {
                        ?>
                            <div class="bg-white rounded-3 p-2 mt-2 text-center">
                                <label class="mb-0 text-muted border-bottom pb-1" for="">Rate Reply</label>
                                <div class="rating text-center">

                                    <?php

                                    for ($i = 5; $i > 0; $i--) { ?>

                                        <input onclick="RateValue('<?= $ticketId ?>', '<?= $replyArray['ticket_id'] ?>', '<?= $i ?>')" type="radio" id="star<?= $i ?>-<?= $replyArray['ticket_id'] ?>" name="rating-<?= $replyArray['ticket_id'] ?>" value="<?= $i ?>" <?= ($rateValue == $i) ? 'checked' : '' ?> />

                                        <label for="star<?= $i ?>-<?= $replyArray['ticket_id'] ?>" title="<?= $i ?> stars" class="star">&#9733;</label>
                                    <?php
                                    } ?>



                                </div>
                                <p class="text-muted">Please rate this reply as you prefer! this will help to rate your instructor.</p>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>