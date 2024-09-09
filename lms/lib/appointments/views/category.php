<?php
$categories = [
['title' => 'Category One', 'subtext' => 'Sub Text 1', 'image' => './assets/images/category-img.png'],
['title' => 'Category Two', 'subtext' => 'Sub Text 2', 'image' => './assets/images/category-img.png'],
['title' => 'Category Three', 'subtext' => 'Sub Text 3', 'image' => './assets/images/category-img.png'],
['title' => 'Category Four', 'subtext' => 'Sub Text 4', 'image' => './assets/images/category-img.png'],
['title' => 'Category Five', 'subtext' => 'Sub Text 5', 'image' => './assets/images/category-img.png'],
['title' => 'Category Six', 'subtext' => 'Sub Text 6', 'image' => './assets/images/category-img.png'],
];
?>

<style>
.category-card {
    width: 153px;
    height: 153px;
    background-color: #eeeeee;
    border-radius: 3px;
    /* box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15); */
    margin-bottom: 30px;
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
            <div class="category-card">
                <img class="img-fluid m-3" src="<?= $category['image']; ?>" alt="<?= $category['title']; ?> Image">
                <h5 class="text-center cat-text"><?= $category['title']; ?></h5>
                <h5 class="text-center sub-text"><?= $category['subtext']; ?></h5>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="fix-bottom"></div>