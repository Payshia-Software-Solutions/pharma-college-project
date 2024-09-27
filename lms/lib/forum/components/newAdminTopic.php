<!-- new_topic_component.php -->

<?php
require '../../../vendor/autoload.php';

//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

// get categories from server
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post-category/');
$postCategoryList = $response->toArray();

?>
<div class="row">
    <div class="col-12">
        <form action="post" id="admin-topic-form">
            <div class="row g-2">
                <div class="col-12 col-md-8">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="topic_title" id="topic_title"
                        placeholder="Type Title, or paste Link Here" style="height: 44px;" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="Category">Category</label>
                    <select class="form-control" name="topic_category" id="topic_category" required>
                        <?php foreach ($postCategoryList as $selectedArray) : ?>
                        <option value="<?= $selectedArray['id'] ?>"><?= $selectedArray['category_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="Content">Content</label>
                    <div class="card border-0">
                        <script>
                        tinymce.remove();
                        tinymce.init({
                            selector: '#newThreadContent'
                        });
                        </script>


                        <textarea id="newThreadContent" placeholder="What do you think about this?"></textarea>


                    </div>
                </div>
                <div class="col-12 text-end mt-2">
                    <button type="button" onclick="ClosePopUP()" class="btn btn-light btn-sm"><i
                            class="fa-solid fa-xmark"></i> Close</button>
                    <button type="button" onclick="SaveAdminTopic()" class="btn btn-dark btn-sm"><i
                            class="fa-solid fa-floppy-disk"></i> Save Topic</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$('#topic_category').select2()
</script>