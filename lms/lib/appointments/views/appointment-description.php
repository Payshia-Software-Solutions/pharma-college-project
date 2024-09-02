<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date3'], $_POST['time3'], $_POST['selectionBox'], $_POST['description3'])) {
        $date = htmlspecialchars($_POST['date3']);
        $time = htmlspecialchars($_POST['time3']);
        $selection = htmlspecialchars($_POST['selectionBox']);
        $description = htmlspecialchars($_POST['description3']);
        // Define the variable to control button state
        $bookingStatus = 1; // 1 = available, 0 = not available
        // Generate HTML content to return
    } else {
        echo '<p class="alert alert-danger">Error: Missing form data.</p>';
    }
} else {
    echo '<p class="alert alert-danger">Error: Invalid request method.</p>';
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card-title">Date and Time</div>
                    <p><?= $date ?></p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card-title">Details</div>
                    <p><strong>Selected Option:</strong><?= $selection ?></p>
                    <p><strong>Description Option:</strong><?= nl2br($description) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($bookingStatus === 0) : ?>
    <button class="btn btn-primary ms-2" disabled>Get another Time</button>
<?php else : ?>
    <button class="btn btn-secondary ml-4" style="margin-left: 1rem;" onclick="Getappointment()">Back</button>
<?php endif ?>