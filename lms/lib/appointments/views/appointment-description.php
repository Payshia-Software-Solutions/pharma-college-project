<?php
// Initialize variables
$date = $time = $selection = $description = null;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['appointmentDate'], $_POST['time3'], $_POST['selectionBox'], $_POST['description3'])) {
        $date = htmlspecialchars($_POST['appointmentDate']);
        $time = htmlspecialchars($_POST['time3']);
        $selection = htmlspecialchars($_POST['selectionBox']);
        $description = htmlspecialchars($_POST['description3']);
        
        // Define the variable to control button state
        $bookingStatus = 1; // 1 = available, 0 = not available
        
        // Convert the data to JSON format
        $formData = json_encode([
            'date' => $date,
            'time' => $time,
            'selection' => $selection,
            'description' => $description
        ]);
    } else {
        echo '<p class="alert alert-danger">Error: Missing form data.</p>';
    }
} else {
    echo '<p class="alert alert-danger">Error: Invalid request method.</p>';
}
?>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Left Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Date & Time</h5>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
                    <p><strong>Time:</strong> <?= htmlspecialchars($time) ?></p>
                </div>
            </div>
        </div>

        <!-- Right Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Selected Option:</strong> <?= htmlspecialchars($selection) ?></p>
                    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($description)) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-start mt-3">
        <?php if (isset($bookingStatus) && $bookingStatus === 0): ?>
            <button class="btn btn-primary" disabled>Book Now</button>
        <?php else: ?>
            <!-- Pass the JSON-encoded data to the SucceedMessage function -->
            <button class="btn btn-primary" onclick='SucceedMessage(<?= json_encode($formData) ?>)'>Book Now</button>
        <?php endif; ?>
        <button class="btn btn-secondary ms-2" onclick="GetAppointment()">Back</button>
    </div>
</div>
