<?php
require_once '../../include/configuration.php';
include '../../php_handler/function_handler.php';

$UserLevel = $_POST['UserLevel'];
$loggedUser = $_POST['LoggedUser'];
$answerList = GetAnswerListAdmin($link);
$answerID = 0;
if (isset($_POST['answerID'])) {
    $answerID = $_POST['answerID'];
}
$answer = $answerType = "";
if ($answerID != 0) {
    $answerType = $answerList[$answerID]['answer_type'];
    $answer = $answerList[$answerID]['answer'];
}
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    .handwrite {
        font-family: 'Indie Flower', cursive;
        font-size: 20 px;
    }

    .prescription-card {
        background-color: #FFFEFE;
        border: 15px solid #009E60;
        border-radius: 0px !important;
    }

    .prescription-card .mini-text {
        font-size: 10px;
    }

    input {
        box-shadow: none !important;
    }
</style>

<div class="row">
    <div class="col-12 text-end mt-3">
        <button class="btn btn-dark btn-sm rounded-3" onclick="AddAnswers('<?= $answerID ?>')"><i class="fa-solid fa-rotate-right player-icon"></i> Reload</button>
        <button class="btn btn-warning btn-sm rounded-3" onclick="OpenIndex()"><i class="fa-solid fa-home player-icon"></i> Home</button>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body">
                <form method="post" id="answer-form">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Add Answers</h6>
                        </div>
                        <div class="col-md-6">
                            <label>Answer Type</label>
                            <select name="answer_type" id="answer_type" class="form-control mb-3" required>
                                <option <?= ($answerType == "Name") ? 'selected' : '' ?> value="Name">Name</option>
                                <option <?= ($answerType == "DrugName") ? 'selected' : '' ?> value="DrugName">Drug Name</option>
                                <option <?= ($answerType == "DosageForm") ? 'selected' : '' ?> value="DosageForm">Dosage Form</option>
                                <option <?= ($answerType == "Quantity") ? 'selected' : '' ?> value="Quantity">Quantity</option>
                                <option <?= ($answerType == "Additional") ? 'selected' : '' ?> value="Additional">Additional</option>
                                <option <?= ($answerType == "MealType") ? 'selected' : '' ?> value="MealType">Meal Type</option>
                                <option <?= ($answerType == "UsingType") ? 'selected' : '' ?> value="UsingType">Using Type</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Answer</label>
                            <input type="text" required class="form-control mb-3" name="answer" id="answer" placeholder="Add Answer here!" value="<?= $answer ?>">
                        </div>
                        <div class="col-12 text-end mt-3">
                            <button type="button" class="btn btn-light btn-sm rounded-3" onclick="AddAnswers(0)"><i class="fa-solid fa-retweet player-icon"></i> Clear</button>
                            <button type="button" class="btn btn-dark btn-sm rounded-3" onclick="SaveAnswerAdmin('<?= $answerID ?>')"><i class="fa-solid fa-floppy-disk player-icon"></i> Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="col-12 mb-3">
            <input type="text" class="form-control" id="search-key" placeholder="Search Here..">
        </div>
        <div style="max-height: 500px; overflow-y:auto">
            <?php
            if (!empty($answerList)) {
                foreach ($answerList as $selectedArray) {
            ?>
                    <div class="card answer-card border-0 shadow-sm mb-2 clickable" onclick="AddAnswers('<?= $selectedArray['id'] ?>') ">
                        <div class="card-body">
                            <h5 class="answer-text mb-0"><?= $selectedArray['answer'] ?></h5>
                            <p class="mb-0 text-secondary"><?= $selectedArray['answer_type'] ?></p>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
    </div>


    <script>
        document.getElementById("search-key").addEventListener("input", function() {
            const searchText = this.value.toLowerCase();
            const productColumns = document.querySelectorAll(".answer-card");

            productColumns.forEach(function(productColumn) {
                const productName = productColumn.querySelector(".answer-text").textContent.toLowerCase();

                if (productName.includes(searchText)) {
                    productColumn.classList.remove("d-none");
                    productColumn.classList.add("d-block");
                } else {
                    productColumn.classList.remove("d-block");
                    productColumn.classList.add("d-none");
                }
            });
        });
    </script>