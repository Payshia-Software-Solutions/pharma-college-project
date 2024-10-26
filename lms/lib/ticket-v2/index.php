<?php

?>
<?php
require_once '../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
//for use env file data
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$client = HttpClient::create();
$cache = new FilesystemAdapter(); // Using filesystem cache
$cacheKey = 'recent_chats_' . $senderId;
$recentChats = [];

$response = $client->request('GET', $_ENV["SERVER_URL"] . '/tickets/username/' . $senderId);
$recentChats = $response->toArray();
?>
<!-- Main Page Title -->
<div class="bg-success d-flex align-items-center p-3 shadow position-fixed w-100 start-0 top-0" style="z-index: 999; height:80px">
    <h1 class="mb-0 text-light">Support Chats</h1>
</div>

<div class="row g-2" style="margin-top: 80px;">
    <?php foreach ($recentChats as $ticketInfo) :
        $statusColors = [
            'Closed' => 'success',
            'Open' => 'warning',
        ];
        $badgeColor = $statusColors[$ticketInfo['status']] ?? 'primary'; // Default to 'primary'
    ?>
        <!-- Chat Item -->
        <div class="col-12">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="left">
                            <h5 class="mb-0"><?= $ticketInfo['related_service'] ?></h5>
                            <p class="text-secondary mb-0">10mins Ago</p>
                        </div>
                        <div class="right">
                            <div class="badge bg-<?= $badgeColor ?>"><?= $ticketInfo['status'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Chat Item -->
    <?php endforeach; ?>
</div>

<!-- Add New Chat Button -->
<button type="button" onclick="OpenNewChat()" class="btn btn-primary chat-button">+</button>
<!-- End of New Chat Button -->