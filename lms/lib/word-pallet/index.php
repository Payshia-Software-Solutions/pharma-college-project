<?php
require_once '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../')->load();
$client = HttpClient::create();
$LoggedUser = $_POST["LoggedUser"];

// Get New Word for Student
$selectedWord = $client->request('GET', $_ENV["SERVER_URL"] . '/word-list/get-word-for-game/' . $LoggedUser)->toArray();
?>

<!-- Floating Background Elements -->
<div class="floating-elements">
    <div class="floating-element">📚</div>
    <div class="floating-element">🎯</div>
    <div class="floating-element">💭</div>
    <div class="floating-element">⭐</div>
</div>

<div class="">
    <div class="game-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="game-logo">
                <img src="./lib/home/assets/images/rumor.gif" style="width: 60px; height: 60px; border-radius: 50%;"
                    alt="Game Logo">
            </div>
            <h1 class="game-title">Word Pallet</h1>
            <p class="mb-0 opacity-75">Test Your Vocabulary Skills</p>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <div class="row g-4">
                <!-- Image Section -->
                <div class="col-12 col-lg-7">
                    <div class="image-container">
                        <img class="word-image"
                            src="https://content-provider.pharmacollege.lk/<?= $selectedWord['word_img'] ?>"
                            alt="Image of <?= $selectedWord['question'] ?>">
                        <div class="image-overlay">
                            <h5><i class="fas fa-eye me-2"></i>Study the image carefully</h5>
                            <p class="mb-0">What word best describes what you see?</p>
                        </div>
                    </div>
                </div>

                <!-- Question Section -->
                <div class="col-12 col-lg-5">
                    <div class="question-section">
                        <h6 class="section-title">
                            <i class="fas fa-question-circle"></i>
                            Choose the Correct Answer!
                        </h6>

                        <!-- Tip Card -->
                        <?php if (!empty($selectedWord['word_tip'])): ?>
                            <div class="tip-card">
                                <h4 class="tip-title">💡 Helpful Tip</h4>
                                <p class="mb-0"><?= htmlspecialchars($selectedWord['word_tip']) ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Answer Options -->
                        <div class="answers-container">
                            <?php foreach ($selectedWord['options'] as $index => $option): ?>
                                <div class="answer-card" data-answer="<?= htmlspecialchars($option['text']) ?>"
                                    onclick="selectAnswer(this, '<?= htmlspecialchars($option['text']) ?>')">
                                    <div class="card-body">
                                        <h4 class="answer-text">
                                            <?= htmlspecialchars($option['text']) ?>
                                            <i class="fas fa-arrow-right answer-icon"></i>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Button -->
            <div class="row mt-4">
                <div class="col-12">
                    <button type="button" class="next-button w-100" id="nextButton" onclick="proceedToNext()">
                        <i class="fas fa-forward me-2"></i>
                        Continue to Next Word
                        <i class="fas fa-forward ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    var selectedAnswer = null;
    var wordId = '<?= $selectedWord['word_id'] ?>';

    function selectAnswer(element, answer) {
        // Remove previous selection
        document.querySelectorAll('.answer-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Highlight selected answer
        element.classList.add('selected');
        selectedAnswer = answer;

        // Add success animation
        element.style.transform = 'translateY(-8px) scale(1.05)';
        setTimeout(() => {
            element.style.transform = 'translateY(-5px) scale(1.02)';
        }, 200);

        // Update button state
        updateNextButton();
    }

    function updateNextButton() {
        const button = document.getElementById('nextButton');
        if (selectedAnswer) {
            button.innerHTML = `
                    <i class="fas fa-check me-2"></i>
                    Great Choice! Continue
                    <i class="fas fa-arrow-right ms-2"></i>
                `;
            button.style.background = 'var(--success-gradient)';
        }
    }

    function proceedToNext() {
        if (!selectedAnswer) {
            // Show shake animation for unselected state
            const answers = document.querySelector('.answers-container');
            answers.classList.add('shake');

            setTimeout(() => {
                answers.classList.remove('shake');
            }, 500);

            // Show alert or toast notification
            showNotification('Please select an answer first!', 'warning');
            return;
        }

        // Show loading state
        const button = document.getElementById('nextButton');
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner spinner me-2"></i>Processing...';
        button.disabled = true;

        // Call your original PHP function
        SubmitWordAnswer(wordId, selectedAnswer);
    }



    function resetButton() {
        const button = document.getElementById('nextButton');
        button.innerHTML = `
                <i class="fas fa-forward me-2"></i>
                Continue to Next Word
                <i class="fas fa-forward ms-2"></i>
            `;
        button.disabled = false;
        button.style.background = 'var(--primary-gradient)';
    }

    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className =
            `alert alert-${type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'danger'} position-fixed`;
        notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                animation: slideIn 0.3s ease-out;
            `;
        notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'times-circle'} me-2"></i>
                ${message}
            `;

        // Add slide-in animation
        const style = document.createElement('style');
        style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
        document.head.appendChild(style);

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideIn 0.3s ease-out reverse';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Add keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.key >= '1' && e.key <= '4') {
            const index = parseInt(e.key) - 1;
            const cards = document.querySelectorAll('.answer-card');
            if (cards[index]) {
                const answer = cards[index].getAttribute('data-answer');
                selectAnswer(cards[index], answer);
            }
        } else if (e.key === 'Enter' && selectedAnswer) {
            proceedToNext();
        }
    });

    // Preload next image for better performance
    window.addEventListener('load', function() {
        // Add any initialization code here
        console.log('Word Pallet Game loaded successfully');
    });
</script>