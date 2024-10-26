<?php
$chatId = 0;
$senderId = $_POST['LoggedUser'];
$chatName = 'Ceylon Pharma College';
$chatInfo = [];

?>
<div class="chat-container">
    <!-- Chat Header -->
    <div class="chat-header">
        <i onclick="ClosePopUP()" class="fas fa-arrow-left back-btn"></i>
        <div class="user-info mx-2">
            <img src="https://eu.ui-avatars.com/api/?name=<?= $chatName ?>&size=50" alt="User Profile">
            <div>
                <h5 class="mb-0"><?= $chatName ?></h5>
                <span class="user-status">Online</span>
            </div>
        </div>
        <!-- <i class="fas fa-ellipsis-v"></i> -->
    </div>

    <!-- Chat Body -->
    <div class="chat-body" id="chatBody" style="background-image: url('https://support.delta.chat/uploads/default/optimized/1X/768ded5ffbef90faa338761be1c5633d91cc35e3_2_654x1024.jpeg');">
        <div class="d-flex align-items-center p-2">
            <input type="text" id="topicInput" class="topic-box p-3 w-100 shadow-sm" placeholder="Enter topic">
        </div>
    </div>


    <!-- Chat Input -->
    <div class="chat-input d-flex align-items-center p-2 border-top bg-white">
        <input type="file" id="fileInput" accept="image/*" class="d-none">
        <label for="fileInput" class="btn btn-outline-secondary">
            <i class="fas fa-image"></i>
        </label>
        <textarea rows="1" placeholder="Type a message..." id="messageInput" class="form-control mx-2" oninput="autoResize(this)"></textarea>
        <button class="btn btn-primary" onclick="sendMessage('<?= $chatId ?>', '<?= $senderId ?>')">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>


</div>

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto'; // Reset height to auto to calculate scrollHeight properly
        textarea.style.height = textarea.scrollHeight + 'px'; // Adjust height based on scrollHeight
    }

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
            // Clear the input and reset its height
            input.value = '';
            input.style.height = 'auto'; // Reset height
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>