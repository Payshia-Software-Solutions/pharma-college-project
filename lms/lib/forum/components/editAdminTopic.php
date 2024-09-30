<!-- new_topic_component.php -->

<?php
require '../../../vendor/autoload.php';

$posId = $_POST['postId'];

//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

//get post from server
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-knowledgebase/' . $posId);
$postDetail = $response->toArray();

// get categories from server
$response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-post-category/');
$postCategoryList = $response->toArray();

?>
<div class="row">
    <div class="col-12">
        <form action="post" id="admin-update-topic-form">
            <div class="row g-2"><br /><b>Warning</b>: Trying to access array offset on value of
                type<br /><b>Warning</b>: Trying to access array offset on value of type
                <div class="col-12 col-md-8">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" value="<?= $postDetail['title'] ?>" name="topic_title"
                        id="topic_title" placeholder="Type Title, or paste Link Here" style="height: 44px;" required>
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
                            selector: '#editThreadContent'
                        });
                        </script>


                        <textarea id="editThreadContent" placeholder="What do you think about this?">
                            <?= $postDetail['content'] ?>
                        </textarea>


                    </div>
                </div>
                <div class="col-12 text-end mt-2">
                    <button type="button" onclick="ClosePopUP()" class="btn btn-light btn-sm"><i
                            class="fa-solid fa-xmark"></i> Close</button>
                    <button type="button" onclick="UpdateAdminTopic(<?= $posId ?>)" class="btn btn-dark btn-sm"><i
                            class="fa-solid fa-floppy-disk"></i> Update Topic</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$('#topic_category').select2()
</script>