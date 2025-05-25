<?php
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
require __DIR__ . '/../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load();

$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

$wordList = $client->request('GET', $_ENV["SERVER_URL"] . '/word-list')->toArray();
$wordSubmissions = $client->request('GET', $_ENV["SERVER_URL"] . '/en-word-submissions')->toArray();
?>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-brands fa-creative-commons-nd icon-card"></i>
            </div>
            <div class="card-body">
                <p>No of Words</p>
                <h1><?= count($wordList) ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-file-contract icon-card"></i>
            </div>
            <div class="card-body">
                <p>No of Submissions</p>
                <h1><?= count($wordSubmissions) ?></h1>
            </div>
        </div>
    </div>
</div>


<div class="row g-3">
    <div class="col-12">
        <h5 class="table-title ">Words</h5>
        <div class="col-12 text-end">
            <button onclick="AddWord(0)" class="btn btn-dark" type="button">+ Add New Word</button>
        </div>
        <div class="row mt-2 g-2">
            <?php foreach ($wordList as $word) { ?>
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="mb-0"><?= $word['word_name'] ?></h4>
                                <p class="mb-0"><?= $word['word_tip'] ?></p>

                                <div class="mt-2 border-top pt-2">
                                    <button onclick="DeleteWord('<?= $word['id'] ?>')"
                                        class="btn btn-danger rounded-3 btn-sm"><i class="fa fa-trash"
                                            aria-hidden="true"></i>
                                    </button>
                                    <button onclick="AddWord('<?= $word['id'] ?>')"
                                        class="btn btn-info rounded-3 btn-sm"><i class="fa fa-pencil"
                                            aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="position-relative overflow-hidden" style="width: 100%; height: 100px;">
                                    <img src="https://content-provider.pharmacollege.lk/<?= $word['word_img'] ?>"
                                        alt="Image of <?= $word['word_name'] ?>" class="w-100 object-cover">
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>