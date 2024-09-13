<?php

require '../../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();

$response = $client->request('GET', 'http://localhost:8000/appointment-category/');

// Get the response body as an array (if it's JSON)
$categories = $response->toArray();
//print_r($categories);
?>

<style>
.category-card {
    width: 153px;
    height: 153px;
    background-color: #eeeeee;
    border-radius: 3px;
    margin-bottom: 30px;
    cursor: pointer;
    /* Change cursor to pointer on hover */
    transition: background-color 0.3s, transform 0.3s;
    /* Smooth transition */
}

.category-card:hover {
    background-color: #dcdcdc;
    /* Lighter background on hover */
    transform: scale(1.05);
    /* Slight zoom effect */
}


.cat-text {
    font-family: 'Lexend Deca', sans-serif;
    font-weight: 600;
    font-size: 20px;
    color: #0EBE7F;
}

.sub-text {
    font-family: 'Lexend Deca', sans-serif;
    font-weight: 500;
    font-size: 14px;
    color: #020202;
}

.fix-bottom {
    height: 100px;
}
</style>


<div class="container">
    <div class="row">
        <?php foreach ($categories as $category) : ?>
        <div class="col-6">
            <div class="category-card" onclick="clickCategory('<?= $category['category_name']; ?>')">
                <img class="img-fluid m-3" src="./assets/images/category-img.png" alt="image">
                <h5 class="text-center cat-text"><?= $category['category_name']; ?></h5>
                <!-- <h5 class="text-center sub-text"><?= $category['subtext']; ?></h5> -->
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="fix-bottom"></div>