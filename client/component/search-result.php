<div class="results-out">
    <?php
    require_once "../include/configuration.php"; // Include config file   

    // Retrieve search suggestions from the database
    if (isset($_POST['query'])) {
        $query = $_POST['query'];
        $sql = "SELECT `id`, `status_id`, `userid`, `fname`, `lname`, CONCAT(`fname`, ' ', `lname`) AS `fullname`, `batch_id`, `username`, `phone`, `email`, `password`, `userlevel`, `status`, `created_by`, `created_at`, `batch_lock` FROM `users` WHERE `username` LIKE '%$query%' OR CONCAT(`fname`, ' ', `lname`) LIKE '%$query%' ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($link, $sql);

        // Generate HTML for the search suggestions
        $suggestions = '';
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $fname = $row['fname'];
                $lname = $row['lname'];
                $query_username = $row['username'];
    ?>
                <div class="search-item" onclick="GetCourse ('<?= $query_username ?>')">
                    <div class="row">
                        <div class="col-1"><img src="./assets/images/testimonials/no-profile.png"></div>
                        <div class="col-11"><?= $query_username ?> | <?= $fname ?> <?= $lname ?></div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>

            <div class="search-item">
                <div class="row">
                    <div class="col-12 text-center">Sorry! We have no user like <?= $query ?>. Try Again with correct index number or Name</div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>