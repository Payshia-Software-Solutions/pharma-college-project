<!-- new_topic_component.php -->

<?php
include_once '../classes/Database.php';
include_once '../classes/Categories.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$CategoriesList = $Categories->fetchAll();
?>
<div class="row">
    <div class="col-12">
        <form action="post" id="topic-form">
            <div class="row g-2">
                <div class="col-12 col-md-8">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="topic_title" id="topic_title" placeholder="Type Title, or paste Link Here" style="height: 44px;" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="Category">Category</label>
                    <select class="form-control" name="topic_category" id="topic_category" required>
                        <?php foreach ($CategoriesList as $key => $selectedArray) : ?>
                            <option value="<?= $key ?>"><?= $selectedArray['category_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="Content">Content</label>
                    <div class="card border-0">
                        <div id="summernote"></div>
                        <script>
                            $(document).ready(function() {
                                $('#summernote').summernote({
                                    placeholder: 'What you think about this?',
                                    height: 250,
                                    toolbar: [
                                        ['style', ['style']],
                                        ['font', ['bold', 'underline', 'clear']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'ol', 'paragraph']],
                                        ['table', ['table']],
                                        ['insert', ['link', 'picture', 'video']],
                                        ['view', ['codeview', 'help']]
                                    ]
                                });
                            });
                        </script>

                    </div>
                </div>
                <div class="col-12 text-end mt-2">
                    <button type="button" onclick="ClosePopUP()" class="btn btn-light btn-sm"><i class="fa-solid fa-xmark"></i> Close</button>
                    <button type="button" onclick="SaveTopic()" class="btn btn-dark btn-sm"><i class="fa-solid fa-floppy-disk"></i> Save Topic</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#topic_category').select2()
</script>