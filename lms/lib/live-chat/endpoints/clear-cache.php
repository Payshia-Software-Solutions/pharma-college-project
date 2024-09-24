<?php
require_once '../../../vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$senderId = $_POST['senderId'];
$cacheKey = 'recent_chats_' . $senderId;

$cache = new FilesystemAdapter();

try {
    // Clear the specific cache item
    $cache->deleteItem($cacheKey);
    echo json_encode(['status' => 'success']);
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
