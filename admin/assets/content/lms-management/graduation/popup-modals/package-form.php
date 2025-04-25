<?php
require __DIR__ . '/../../../../../vendor/autoload.php';

// For use env file data
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
$dotenv->load();

// Get the POST Variables
$packageId = $_POST['packageId'];

// Initialize HTTP client
$client = HttpClient::create();

if (isset($packageId) && $packageId != 0) {
    // Load environment variables
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 5));
    $dotenv->load();

    // Fetch certificate order data from API
    $response = $client->request('GET', $_ENV["SERVER_URL"] . '/packages/' . $packageId);
    $graduationPackage = $response->toArray();
}

// Get all courses from the API and decode the response
$courseResponse = $client->request('GET', "{$_ENV["SERVER_URL"]}/parent-main-course");
$courseData = $courseResponse->toArray();

// Assume the package already includes selected course IDs if provided (e.g. from $graduationPackage['courses'])
$selectedCourses = isset($graduationPackage['courses'])
    ? explode(',', $graduationPackage['courses'])
    : [];


?>

<div class="loading-popup-content">
    <div class="row">
        <div class="col-12 w-100 text-end">
            <button class="btn btn-sm btn-dark" onclick="ClosePopUP()"><i
                    class="fa-regular fa-circle-xmark"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="mb-3 border-bottom pb-2">Package Info</h4>
            <form action="#" method="POST" enctype="multipart/form-data">

                <div class="row">
                    <!-- Left column -->
                    <div class="col-md-6 mb-3">
                        <label for="package_name" class="form-label">Package Name</label>
                        <input type="text" class="form-control" id="package_name" name="package_name"
                            value="<?= isset($graduationPackage['package_name']) ? htmlspecialchars($graduationPackage['package_name']) : '' ?>"
                            required>
                    </div>

                    <!-- Right column -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price"
                            value="<?= isset($graduationPackage['price']) ? htmlspecialchars($graduationPackage['price']) : '' ?>"
                            required>
                    </div>
                </div>

                <div class="row">
                    <!-- Left column -->
                    <div class="col-md-6 mb-3">
                        <label for="parent_seat_count" class="form-label">Parent Seat Count</label>
                        <input type="number" class="form-control" id="parent_seat_count" name="parent_seat_count"
                            value="<?= isset($graduationPackage['parent_seat_count']) ? htmlspecialchars($graduationPackage['parent_seat_count']) : '' ?>"
                            required>
                    </div>

                    <!-- Right column -->
                    <div class="col-md-6 mb-3">
                        <label for="photo_package" class="form-label">Photo Package</label>
                        <input type="number" class="form-control" id="photo_package" name="photo_package"
                            value="<?= isset($graduationPackage['photo_package']) ? htmlspecialchars($graduationPackage['photo_package']) : '' ?>"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 d-flex justify-content-start gap-4">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="graduation_cloth"
                                name="graduation_cloth" value="1"
                                <?= isset($graduationPackage['graduation_cloth']) && $graduationPackage['graduation_cloth'] == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="graduation_cloth">Graduation Cloth</label>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="garland" name="garland" value="1"
                                <?= isset($graduationPackage['garland']) && $graduationPackage['garland'] == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="garland">Garland</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cover_image" class="form-label">Package Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Available Courses</label>
                        <div class="d-flex flex-wrap gap-3">
                            <?php foreach ($courseData as $course): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="courses[]"
                                        id="course_<?= $course['id'] ?>" value="<?= $course['id'] ?>"
                                        <?= in_array($course['id'], $selectedCourses) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="course_<?= $course['id'] ?>">
                                        <?= htmlspecialchars($course['course_name']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-dark btn-sm" type="button" onclick="SavePackage(<?= $packageId ?>)"
                            class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>