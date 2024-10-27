<?php
require_once '../../vendor/autoload.php';

$loggedUser = $_POST['LoggedUser'];
$ticketId = $_POST['ticketId'];

use Symfony\Component\HttpClient\HttpClient;
use Dotenv\Dotenv; //for use env file data

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$client = HttpClient::create();

// Get Ticket by Ticket Id
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/tickets/' . $ticketId);
$ticketInfo = $response->toArray();

// Get Ticket Replies
$response = $client->request('GET', $_ENV["SERVER_URL"] . '/tickets/replies/' . $ticketId);
$ticketReplies = $response->toArray();

$ticketStatus = $ticketInfo['is_active'];
$attachments = explode(', ', $ticketInfo['attachments']);
?>


<div class="row">
    <div class="col-12">

        <!-- Sender Info -->
        <div class="row">
            <div class="col-12">
                <h6 class="mb-0 text-secondary"><?= $ticketInfo['index_number'] ?></h6>
                <h3 class="mb-0"><?= $ticketInfo['subject'] ?></h3>
            </div>

        </div>
        <div class="border-bottom my-1"></div>

        <div class="card bg-light border-0 rounded-1">
            <div class="card-body ticket-body"><?= $ticketInfo['ticket'] ?></div>
        </div>
        <?php
        if (!empty($attachments)) {
        ?>
            <h6 class="mt-3">Attachments</h6>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <?php
                foreach ($attachments as $attachment) {
                    // Check if the file is an image based on its extension
                    $file_extension = pathinfo($attachment, PATHINFO_EXTENSION);
                    $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array(strtolower($file_extension), $image_extensions)) {
                        // Display image thumbnail if it's an image file
                ?>
                        <div style="text-align: center;">
                            <a href="./uploads/ticket_img/<?= $attachment ?>" download="<?= $attachment ?>" target="_blank">
                                <img src="./uploads/ticket_img/<?= $attachment ?>" alt="<?= $attachment ?>" style="width: auto; height: 80px;" />
                            </a>

                        </div>
                    <?php
                    } else {
                        // Display as a link if it's not an image file
                    ?>
                        <div>
                            <p class="mb-0">
                                <a href="./uploads/ticket_img/<?= $attachment ?>" download="<?= $attachment ?>" target="_blank"><?= $attachment ?></a>
                            </p>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>



        <div class="border-bottom my-2"></div>
        <?php
        if (!empty($ticketReplies)) {
            foreach ($ticketReplies as $replyArray) {

                $rateValue = $replyArray['rating_value'];
        ?>
                <div class="card <?= ($replyArray['index_number'] != $loggedUser) ? 'bg-light' : 'bg-white' ?> shadow border-0 rounded-3 my-3">
                    <div class="card-body ticket-body <?= ($replyArray['index_number'] != $loggedUser) ? 'text-end' : '' ?>">
                        <p class="border-bottom mb-2 text-muted"><?= $replyArray['index_number'] ?></p>
                        <p class="mb-0"><?= $replyArray['ticket'] ?></p>

                        <?php
                        if ($replyArray['index_number'] != $loggedUser && 1 == 2) {
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

<div class="row">
    <div class="col-12">
        <form action="#" id="ticket-reply-form" method="post" enctype="multipart/form-data">

            <div class="row g-2">

                <div class="col-12">
                    <label for="ticketText">Ticket Reply</label>
                    <textarea class="form-control" rows="4" name="ticketReply" id="ticketReply"></textarea>
                </div>


                <div class="col-12 text-end my-3">
                    <button type="button" class="btn btn-dark w-100 rounded-3" onclick="SendReply('<?= $ticketId ?>')"><i class="fa fa-mail-bulk"></i> Send Reply</button>
                </div>
            </div>
        </form>


    </div>
</div>

<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea#ticketReply',
        height: 200,
        menubar: false,
        content_css: 'assets/css/custom_editor.css',
        plugins: 'image fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'image fullscreen undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        /*
          URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
          images_upload_url: 'postAcceptor.php',
          here we add custom filepicker only to Image dialog
        */
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>