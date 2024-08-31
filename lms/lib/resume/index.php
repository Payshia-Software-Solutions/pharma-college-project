<?php
$overallGrade = 9.5;
?>

<div class="row mt-2 mb-5">
    <div class="col-12">
        <div class="card border-0 rounded-bottom-4 rounded-top-3" id="bubbleCard">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button onclick="redirectToURL('./')" type="button" class="btn btn-light back-button">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </button>
                    </div>

                    <div class="col-6">
                        <div class="profile-image profile-image-mini" style="background-image : url('./assets/images/user.png')"></div>
                    </div>


                    <div class="col-12 text-center">
                        <div class="p-2 text-light mt-3 fw-bold rounded-4 mb-3">CV Rating</div>
                        <div class="grade-value-container">
                            <div class="grade-value-overlay-1 mx-2">
                                <div class="grade-value-overlay-2">
                                    <input type="hidden" id="gradeValue" value="<?= $overallGrade ?>">
                                    <div class="grade-value" id="counter"><?= number_format($overallGrade, 1) ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card quiz-card border-0">
            <div class="card-body">
                <div class="quiz-img-box">
                    <img src="./lib/resume/assets/images/recruitment.gif" class="quiz-img rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">CV Generator</h1>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <h1>Create CV</h1>
    </div>

    <div class="col-6">
        <label for=""></label>
    </div>
</div>


<!-- Script to add random bubbles -->
<script>
    var card = document.getElementById("bubbleCard");
    var positionPoints = [
        ['20%', '60%', '60px'],
        ['50%', '0%', '40px'],
        ['-10%', '20%', '100px'],
        ['80%', '65%', '50px'],
        ['75%', '30%', '90px'],
        ['10%', '65%', '15px']
    ];

    for (let i = 0; i < positionPoints.length; i++) {
        xPos = positionPoints[i][0];
        yPos = positionPoints[i][1];
        widthVal = positionPoints[i][2];
        createBubble(card, xPos, yPos, widthVal);
    }


    var gradeValueInput = document.getElementById('gradeValue');
    var overallDpadGrade = parseFloat(gradeValueInput.value);
    var counterElement = document.getElementById('counter');

    function updateCounter(element, value) {
        // alert(element.textContent)
        element.textContent = value.toFixed(1);
    }

    function loadCounter(element, targetValue) {
        let currentCounterValue = 0.0;
        const interval = 25; // Adjust the interval as needed
        const step = targetValue / (1000 / interval);

        const counterInterval = setInterval(function() {
            currentCounterValue += step;
            updateCounter(element, currentCounterValue);

            if (currentCounterValue >= targetValue) {
                clearInterval(counterInterval);
                updateCounter(element, targetValue);
            }
        }, interval);
    }

    // Call the function to start loading the counter for counterElement
    loadCounter(counterElement, overallDpadGrade);



    var answerCards = document.querySelectorAll('.answer-card');

    // Add a click event listener to each '.answer-card' element
    answerCards.forEach(function(card) {
        card.addEventListener('click', function() {
            var radioInput = card.querySelector('input[type="radio"]');
            radioInput.checked = !radioInput.checked;
        });
    });
</script>