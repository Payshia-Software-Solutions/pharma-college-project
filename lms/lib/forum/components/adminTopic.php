<!-- new_topic_component.php -->

<?php
require '../../../vendor/autoload.php';

$postId = $_POST['postId'];

//for use env file data
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../../');
$dotenv->load();

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

if (!$postId == 0) {
    //get post from server
    $response = $client->request('GET', $_ENV["SERVER_URL"] .'/community-knowledgebase/' . $postId);
    $postDetail = $response->toArray();
}

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
                    <?php if (!$postId == 0) { ?>
                    <input class="form-control" type="text" value="<?= $postDetail['title'] ?>" name="topic_title"
                        id="topic_title" placeholder="Type Title, or paste Link Here" style="height: 44px;" required>
                    <?php } else { ?>
                    <input class="form-control" type="text" name="topic_title" id="topic_title"
                        placeholder="Type Title, or paste Link Here" style="height: 44px;" required>

                    <?php } ?>
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
                            selector: '#threadContent'
                        });
                        </script>

                        <?php if (!$postId == 0) { ?>
                        <textarea id="threadContent"
                            placeholder="What do you think about this?"><?= $postDetail['content'] ?></textarea>
                        <?php } else { ?>
                        <textarea id="threadContent" placeholder="What do you think about this?"></textarea>
                        <?php } ?>


                    </div>
                </div>
                <div class="col-12 text-end mt-2">
                    <button type="button" onclick="ClosePopUP()" class="btn btn-light btn-sm"><i
                            class="fa-solid fa-xmark"></i> Close</button>
                    <button type="button" onclick="SaveAdminTopic(<?= $postId ?>)" class="btn btn-dark btn-sm"><i
                            class="fa-solid fa-floppy-disk"></i>
                        <?php if (!$postId == 0) { ?>Update Topic<?php } else { ?>Save Topic<?php }
                        ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$('#topic_category').select2()
</script>