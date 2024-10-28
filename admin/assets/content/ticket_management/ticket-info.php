<?php
require_once('../../../include/config.php');
include '../../../include/function-update.php';
include '../../../include/lms-functions.php';

include './methods/functions.php'; //Ticket Methods


$accountList =  GetAccounts($link);

$ticketId = $_POST['ticketId'];
$ticketInfo = GetTicketsById($ticketId);

$stateCode = $ticketInfo['is_active'];
$stateArray = GetTicketStatus($stateCode);

$ticketReplies = GetReplyByTicketASC($ticketId);
$attachments = explode(', ', $ticketInfo['attachments']);
$studentInfo = GetLmsStudentsByUserName($ticketInfo['index_number']);
$ticketAssignments = GetTicketAssignment($ticketId);
?>
<style>
    .ticket-body img {
        max-width: 50% !important;
    }

    .ticket-body p {
        margin: 0
    }

    .ticket-body h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 3px 0 3px 0;
    }
</style>

<div class="loading-popup-content-right">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUPRight()"><i class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="mb-0">Ticket Details</h5>
            <span class="badge bg-<?= $stateArray['bgColor'] ?>"><?= $stateArray['stateValue'] ?></span>
            <h4><?= $ticketInfo['subject'] ?></h4>
            <p class="border-bottom pb-2"></p>


            <div class="bg-light rounded-3 p-3 text-end my-2">

                Assign To :
                <select onchange="TicketAssignmentUpdate(this.value, '<?= $ticketId; ?>', 1)" class="" name="userAccount" id="userAccount">
                    <option value="">Select User</option>
                    <?php
                    if (!empty($accountList)) {
                        foreach ($accountList as $userAccount) {
                    ?>
                            <option <?php if (isset($ticketAssignments[0])) {
                                        echo ($ticketAssignments[0]['user_name'] == $userAccount['user_name']) ? 'selected' : '';
                                    }  ?> value="<?= $userAccount['user_name']; ?>">
                                <?= $userAccount['user_name']; ?> - <?= $userAccount['first_name']; ?> <?= $userAccount['last_name']; ?>
                            </option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <button onclick="ChangeTicketReadStatus('<?= $ticketId ?>', 'unread', 1)" class="btn btn-secondary "><i class="fa-solid fa-eye"></i> Mark As Unread</button>
                <button onclick="ChangeTicketStatus('<?= $ticketId ?>', 1)" class="btn btn-primary "><i class="fa-solid fa-check"></i> Active</button>
                <button onclick="ChangeTicketStatus('<?= $ticketId ?>', 3)" class="btn btn-danger "><i class="fa-solid fa-trash"></i> Delete</button>
                <button onclick="ChangeTicketStatus('<?= $ticketId ?>', 2)" class="btn btn-warning "><i class="fa-solid fa-xmark"></i> Close</button>
            </div>

            <div class="bg-light p-3 rounded-3 my-2">
                <div class="row g-2">
                    <div class="col-4">
                        Student
                    </div>
                    <div class="col-8">
                        <?= $studentInfo['name_on_certificate'] ?>
                    </div>

                    <div class="col-4">
                        Telephone
                    </div>
                    <div class="col-8">
                        <a href="tel:<?= $studentInfo['telephone_1'] ?>"><?= $studentInfo['telephone_1'] ?></a> / <a href="tel:<?= $studentInfo['telephone_2'] ?>"><?= $studentInfo['telephone_2'] ?></a>
                    </div>
                </div>

            </div>


            <div class="ticket-body mt-2">
                <?= $ticketInfo['ticket'] ?>
            </div>

            <div class="border-bottom my-2"></div>
            <?php
            if (!empty($attachments[0])) {
            ?>
                <h6 class="mt-3">Attachments</h6>
                <?php
                foreach ($attachments as $attachment) {
                ?>
                    <p class="mb-0"><a href="http://web.pharmacollege.lk/lib/ticket/assets/ticket_img/<?= $attachment ?>" target="_blank"><?= $attachment ?></a></p>
            <?php
                }
            }
            ?>

            <?php
            if (!empty($ticketReplies)) {
                foreach ($ticketReplies as $replyArray) {
            ?>
                    <div class="p-3 shadow-sm bg-white border-0 rounded-3 my-2">
                        <div class="card-body ticket-body">
                            <h6 class="border-bottom mb-2"><?= $replyArray['index_number'] ?></h6>
                            <?= $replyArray['ticket'] ?>
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
                <div class="row">
                    <div class="col-md-12">
                        <p class="border-bottom pb-2"></p>
                        <textarea class="form-control" rows="4" name="ticketReply" id="ticketReply"></textarea>

                        <div class="text-end mt-2">
                            <button type="button" onclick="SendReply('<?= $ticketId ?>')" class="btn btn-dark"><i class="fa-solid fa-reply"></i> Send Reply</button>
                            <button type="button" onclick="SendReplyClose('<?= $ticketId ?>')" class="btn btn-dark"><i class="fa-solid fa-xmark"></i> Send Reply & Close</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('userAccount').select2()
</script>
<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea#ticketReply',
        height: 300,
        menubar: false,
        content_css: 'assets/css/custom_editor.css',
        plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'fullscreen undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
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