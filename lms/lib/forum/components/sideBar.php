<!-- sidebar_template.php -->
<?php
require __DIR__ . '/../../../vendor/autoload.php';

include_once './classes/Database.php';
include_once './classes/Categories.php';

// Create a new Database object with the path to the configuration file
$config_file = '../../include/env.txt';
$database = new Database($config_file);
$db = $database->getConnection();

$Categories = new Categories($database);
$categoryList = $Categories->fetchAll();

// Read the JSON file
$jsonData = file_get_contents('./constants/constants.json');

// Decode the JSON data
$data = json_decode($jsonData, true);

// Access sidebar links
$sideBarLinks = $data['sideBarLinks'];
?>
<style>
    .rectangle {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin-right: 5px;
    }
</style>


<ul class="nav flex-column">
    <?php foreach ($sideBarLinks as $pageId => $selectArray) : ?>
        <li class="nav-item my-2">
            <a href="<?= htmlspecialchars($selectArray['link_url']) ?>" class="nav-link <?= ($currentPage == $pageId) ? 'active text-white' : 'text-dark' ?>" aria-current="page">
                <i class="fa-solid <?= htmlspecialchars($selectArray['link_icon']) ?>"></i> <?= htmlspecialchars($selectArray['link_title']) ?>
            </a>
        </li>
    <?php endforeach ?>
    <?php if ($userLevel != 'student') : ?>
        <li class="nav-item my-2">
            <a href="./community-categories" class="nav-link <?= ($currentPage == 'categories') ? 'active text-white' : 'text-dark' ?>" aria-current="page">
                <i class="fa-solid fa-tags"></i> Categories
            </a>
        </li>
    <?php endif ?>
</ul>

<hr>
<ul class="nav flex-column">
    <?php foreach ($categoryList as $tagId => $selectArray) : ?>
        <li class="nav-item my-1">
            <a href="#<?= htmlspecialchars($selectArray['category_name']) ?>" class="nav-link text-dark" aria-current="page">
                <span class="rectangle" style="background-color: <?= $selectArray['bg_color'] ?>;"></span>
                <?= htmlspecialchars($selectArray['category_name']) ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>