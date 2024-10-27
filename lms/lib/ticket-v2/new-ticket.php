<?php
$chatId = 0;
$senderId = $_POST['LoggedUser'];
$chatName = 'Ceylon Pharma College';
$chatInfo = [];

?>
<form action="#" id="ticket-form" method="post" enctype="multipart/form-data">
    <div class="row g-3">

        <div class="col-12">
            <h4 class="mb-0">Ticket Info</h4>
            <p class="text-secondary" class="mb-0 text-secondary">Please give the information about the problem occur!</p>
            <div class="border-bottom"></div>
        </div>

        <div class="col-md-6">
            <label class="text-secondary" for="subject">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" value="" placeholder="Enter the Subject of your Issue!">
        </div>

        <div class="col-md-3 col-6">
            <label class="text-secondary" for="department">Department</label>
            <select class="form-control" name="department" id="department">
                <option value="General Inquiries">General Inquiries</option>
                <option value="Payments">Payments</option>
                <option value="Games">Games</option>
            </select>
        </div>

        <div class="col-md-3 col-6">
            <label class="text-secondary" for="department">Related Service</label>
            <select class="form-control" name="relatedService" id="relatedService">
                <option value="Winpharma">Winpharma</option>
                <option value="Pharma Hunter">Pharma Hunter</option>
                <option value="Ceylon Pharmacy">Ceylon Pharmacy</option>
                <option value="Pharma Reader">Pharma Reader</option>
                <option value="Quiz">Quiz</option>
                <option value="Payment">Payment</option>
            </select>
        </div>

        <div class="col-12">
            <label class="text-secondary" for="ticketText">Ticket Description</label>
            <textarea class="form-control" rows="4" name="ticketText" id="ticketText"></textarea>
        </div>

        <div class="col-12">
            <label class="text-secondary" for="imageUploads">Select Attachments</label>
            <input class="form-control" type="file" name="files[]" id="files" multiple>
        </div>

        <div class="col-12 text-end mt-3">
            <button type="button" class="btn btn-dark w-100 rounded-3" onclick="SaveTicket()">Send Message</button>
        </div>
    </div>
</form>

<script>
    tinymce.remove()
    tinymce.init({
        selector: 'textarea#ticketText',
        height: 250,
        menubar: false,
        content_css: 'assets/css/custom_editor.css',
        plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
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