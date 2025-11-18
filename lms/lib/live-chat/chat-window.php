<?php
require_once '../../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

$chatId = $_POST['chatId'];
$senderId = $_POST['LoggedUser'];

$client = HttpClient::create();
$chatInfo = [];
try {
    // Make a GET request to fetch chat data
    $response = $client->request('GET', 'https://api.pharmacollege.lk/messages/chat/' . $chatId);

    // Decode the response
    $chatInfo = $response->toArray();
} catch (\Exception $e) {
    // Handle any errors that might occur during the request
    // echo 'Error: ' . $e->getMessage();
    // exit;
}

$chatName = 'Ceylon Pharma College';

?>
<div class="chat-container">
    <!-- Chat Header -->
    <div class="chat-header">
        <i onclick="OpenIndex()" class="fas fa-arrow-left back-btn"></i>
        <div class="user-info mx-2">
            <img src="https://eu.ui-avatars.com/api/?name=<?= $chatName ?>&size=50" alt="User Profile">
            <div>
                <h5 class="mb-0"><?= $chatName ?></h5>
                <span class="user-status">Online</span>
            </div>
        </div>
        <i class="fas fa-ellipsis-v"></i>
    </div>

    <!-- Chat Body -->
    <div class="chat-body" id="chatBody" style="background-image: url('https://support.delta.chat/uploads/default/optimized/1X/768ded5ffbef90faa338761be1c5633d91cc35e3_2_654x1024.jpeg');">
        <?php foreach ($chatInfo as $message) :
            $messageClass = ($message['sender_id'] === $senderId) ? 'sent' : 'received';
            $messageText = htmlspecialchars($message['message_text'], ENT_QUOTES, 'UTF-8');
            $messageTime = date('h:i A', strtotime($message['created_at'])); // Format time as needed

        ?>
            <div class="message <?= $messageClass ?>">
                <?= nl2br($messageText) ?>
                <span class="time"><?= $messageTime ?></span>
            </div>
        <?php endforeach ?>

    </div>

    <!-- Chat Input -->
    <div class="chat-input d-flex align-items-center p-2 border-top bg-white">
        <input type="file" id="fileInput" accept="image/*" class="d-none">
        <label for="fileInput" class="btn btn-outline-secondary">
            <i class="fas fa-image"></i>
        </label>
        <textarea rows="1" placeholder="Type a message..." id="messageInput" class="form-control mx-2"></textarea>
        <button class="btn btn-primary" onclick="sendMessage('<?= $chatId ?>', '<?= $senderId ?>') ">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

</div>

<script>
    document.querySelector('label[for="fileInput"]').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.classList.add('w-100');
                img.src = e.target.result;
                img.classList.add('sent'); // Add class for sent message
                var message = document.createElement('div');
                message.classList.add('message', 'sent', 'w-100');
                message.appendChild(img);
                var time = document.createElement('span');
                time.classList.add('time');
                time.textContent = new Date().toLocaleTimeString().slice(0, 5);
                message.appendChild(time);
                document.getElementById('chatBody').appendChild(message);
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelector('.chat-input button').addEventListener('click', function() {
        var input = document.getElementById('messageInput');
        var text = input.value.trim();
        if (text) {
            var message = document.createElement('div');
            message.classList.add('message', 'sent');
            message.textContent = text;
            var time = document.createElement('span');
            time.classList.add('time');
            time.textContent = new Date().toLocaleTimeString().slice(0, 5);
            message.appendChild(time);
            document.getElementById('chatBody').appendChild(message);
            input.value = '';
            document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight;
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>