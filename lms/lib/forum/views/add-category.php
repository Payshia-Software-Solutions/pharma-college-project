<?php
$categoryId = $_POST['categoryId'];
?>
<div class="row">
    <div class="col-md-12">
        <h3 class="mb-2 pb-2 border-bottom card-title fw-bold">Categories</h3>

        <form action="post" id="category_form">
            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control rounded-0 h-75" name="category_name" id="category_name" placeholder="Enter Category Name" required>
                </div>

                <div class="col-md-6">
                    <label for="category_color">Pick Label Color</label>
                    <input type="color" class="form-control rounded-0 h-75" name="label_color" id="label_color" required>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-primary rounded-0" type="button" onclick="SaveCategory('<?= $categoryId ?>')">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>