<?php
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';
include '../../../../include/lms-functions.php';

require __DIR__ . '/../../../../vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load();

$client = HttpClient::create();

$userThemeInput = $_POST['userTheme'] ?? null;
$UserLevel = $_POST['UserLevel'] ?? 'Officer';
$userTheme = getUserTheme($userThemeInput);

$wordId = $_POST['wordId'] ?? null;
$wordInfo = [
    'word_name' => '',
    'word_tip' => '',
    'word_img' => '',
    'word_type' => '',
    'word_status' => 1,
];

if (!empty($wordId)) {
    try {
        $wordInfo = $client->request('GET', $_ENV["SERVER_URL"] . '/word-list/' . $wordId)->toArray();
    } catch (\Exception $e) {
        // Optional: Handle error
    }
}
?>

<div class="loading-popup-content <?= htmlspecialchars($userTheme) ?>">
    <div class="row">
        <div class="col-6">
            <h4 class="mb-0"><?= $wordId ? 'Edit Word' : 'Add Word' ?></h4>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-dark btn-sm" onclick="AddWord('<?= $wordId ?>')" type="button">
                <i class="fa solid fa-rotate-left"></i> Reload
            </button>
            <button class="btn btn-light btn-sm" onclick="ClosePopUP(0)" type="button">
                <i class="fa solid fa-xmark"></i> Close
            </button>
        </div>
        <div class="col-12">
            <div class="border-bottom border-2 my-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form name="word-form" action="#" method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="word_name">Word Name</label>
                        <input class="form-control" type="text" name="word_name" id="word_name" placeholder="Word Name"
                            value="<?= htmlspecialchars($wordInfo['word_name']) ?>" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="word_tip">Word Tip</label>
                        <input class="form-control" type="text" name="word_tip" id="word_tip" placeholder="Word Tip"
                            value="<?= htmlspecialchars($wordInfo['word_tip']) ?>" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="word_file">Word Image</label>
                        <input class="form-control" type="file" name="word_file" id="word_file"
                            <?= empty($wordId) ? 'required' : '' ?>>
                        <?php if (!empty($wordInfo['word_img'])): ?>
                            <small class="d-block mt-1">Current Image:</small>
                            <img src="https://content-provider.pharmacollege.lk/<?= htmlspecialchars($wordInfo['word_img']) ?>"
                                alt="Word Image" class="img-thumbnail" style="max-height: 100px;">
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="word_type">Word Type</label>
                        <select class="form-control" name="word_type" id="word_type" required>
                            <option value="">-- Select Word Type --</option>
                            <option value="Basic" <?= $wordInfo['word_type'] === 'Basic' ? 'selected' : '' ?>>Basic
                            </option>
                            <option value="Intermediate"
                                <?= $wordInfo['word_type'] === 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
                            <option value="Advanced" <?= $wordInfo['word_type'] === 'Advanced' ? 'selected' : '' ?>>
                                Advanced</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="word_status" class="form-label d-block">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="word_status" name="word_status"
                                value="1" <?= $wordInfo['word_status'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="word_status">Active</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn btn-dark" type="button" onclick="SaveWord('<?= $wordId ?>')">
                            <?= $wordId ? 'Update' : 'Save' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>