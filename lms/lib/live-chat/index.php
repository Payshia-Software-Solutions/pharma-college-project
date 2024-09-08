<?php
require_once '../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];

use Symfony\Component\HttpClient\HttpClient;

$client = HttpClient::create();
$recentChats = [];


try {
    // Make a GET request to fetch chat data
    $response = $client->request('GET', 'https://api.pharmacollege.lk/get-recent-chats/' . $senderId);
    $recentChats = $response->toArray();
} catch (\Exception $e) {
    // Handle any errors that might occur during the request
    echo 'Error: ' . $e->getMessage();
    exit;
}


?>
<div class="bg-success p-3">
    <h1 class="text-white mb-0">Live Chat</h1>
    <p class="text-white mb-0">Chat with us live for instant support and real-time assistance!</p>
</div>


<div class="container-fluid">
    <div class="row">
        <?php foreach ($recentChats as $index => $chat) :
        ?>
            <div onclick="OpenChat('<?= $chat['chat_id'] ?>')" class="chat-card d-flex align-items-center p-3 <?= ($index < count($recentChats) - 1) ? 'border-bottom' : '' ?>">
                <div class="chat-img position-relative">
                    <img src="https://eu.ui-avatars.com/api/?name=<?= urlencode($chat['user_name']) ?>&size=50" alt="<?= $chat['user_name']; ?>" class="rounded-circle" width="50" height="50">
                    <!-- Online Status Indicator -->
                    <?php if ($chat['online_status']) : ?>
                        <span class="online-status"></span>
                    <?php endif; ?>
                </div>
                <div class="chat-details flex-grow-1 mx-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 <?= $chat['unread_count'] > 0 ? 'font-weight-bold' : '' ?>"><?= $chat['user_name']; ?></h5>
                        <span class="text-muted small"><?= $chat['last_message_time']; ?></span>
                    </div>
                    <p class="mb-0 text-muted <?= $chat['unread_count'] > 0 ? 'font-weight-bold' : '' ?> chat-last-message">
                        <?= $chat['last_message']; ?>
                    </p>
                </div>

            </div>

        <?php endforeach; ?>
    </div>
</div>

<!-- Floating Button for New Chat -->
<button class="floating-btn" onclick="createNewChat()">
    <i class="fas fa-comment-alt"></i>
</button>