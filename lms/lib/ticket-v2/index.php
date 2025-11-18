<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../../vendor/autoload.php';

$senderId = $_POST['LoggedUser'];

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Carbon\Carbon;

//for use env file data
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$client = HttpClient::create();
$cache = new FilesystemAdapter(); // Using filesystem cache
$cacheKey = 'recent_chats_' . $senderId;
$recentChats = [];

$response = $client->request('GET', $_ENV["SERVER_URL"] . '/get-main-tickets/username/' . $senderId);
$recentChats = $response->toArray();

?>
<!-- Main Page Title -->
<div class="bg-success d-flex align-items-center p-3 shadow position-fixed w-100 start-0 top-0" style="z-index: 999; height:80px">
    <h1 class="mb-0 text-light">Support Chats</h1>
</div>

<div class="row g-2 mb-3" style="margin-top: 80px;">
    <?php foreach ($recentChats as $ticketInfo) :
        $statusColors = [
            'read' => 'primary',
            'unread' => 'warning',
        ];
        $badgeColor = $statusColors[$ticketInfo['read_status']] ?? 'primary'; // Default to 'primary'

        // Create a Carbon instance from the created_at timestamp
        $createdDateTime = Carbon::createFromFormat('Y-m-d H:i:s.u', $ticketInfo['created_at']);

        // Calculate the time ago in a human-readable format
        $timeAgo = $createdDateTime->diffForHumans();

        $ticketText = strip_tags($ticketInfo['ticket']); // Remove HTML tags
        $shortText = substr($ticketText, 0, 100); // Limit to 100 characters
    ?>
        <!-- Chat Item -->
        <div class="col-12">
            <div class="card border-0 shadow rounded-3 clickable chat-card" onclick="OpenTicket('<?= $ticketInfo['ticket_id'] ?>')">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="left">
                            <h5 class="mb-0"><?= $shortText ?></h5>
                            <div class="badge bg-danger mb-0"><?= $ticketInfo['related_service'] ?></div>
                        </div>
                        <div class="right">
                            <div class="badge bg-<?= $badgeColor ?>"><?= ucfirst($ticketInfo['read_status']) ?></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <p class="text-secondary mb-0"><?= $timeAgo ?></p>
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