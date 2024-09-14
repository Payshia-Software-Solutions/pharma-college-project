var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var UserLevel = document.getElementById("UserLevel").value;
var company_id = document.getElementById("company_id").value;
var CourseCode = document.getElementById("defaultCourseCode").value;

$(document).ready(function () {
  OpenIndex();
});

function OpenPopup() {
  document.getElementById("loading-popup").style.display = "flex";
}

function ClosePopUP() {
  document.getElementById("loading-popup").style.display = "none";
}

// JavaScript to show the overlay
function showOverlay() {
  var overlay = document.querySelector(".overlay");
  overlay.style.display = "block";
}

// JavaScript to hide the overlay
function hideOverlay() {
  const overlay = document.querySelector(".overlay");
  overlay.style.display = "none";
}

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/live-chat/index.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
      },
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}

function OpenChat(chatId) {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/live-chat/chat-window.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
        chatId: chatId,
      },
      success: function (data) {
        $("#root").html(data);
        scrollToBottom();
      },
    });
  }

  // Function to scroll to the bottom of the chat
  function scrollToBottom() {
    const chatWindow = document.getElementById("chatBody"); // Assuming your chat content has an id like 'chat-window'
    if (chatWindow) {
      chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to the bottom
    }
  }
  fetch_data();
}

function createNewChat() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/live-chat/new-chat.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
      },
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}

// Api

const API_URL = "https://api.pharmacollege.lk/";

function sendMessage(chatId, sender_id) {
  const messageInput = document.querySelector("#messageInput");
  const messageText = messageInput.value.trim();

  if (!messageText) {
    showNotification("Message cannot be empty!", "error", "Oops!");
    return; // Stop execution if the message is empty
  }
  sendMessageAndClearCache(sender_id);

  if (chatId != 0) {
    axios
      .post(
        API_URL + "/messages/",
        {
          chat_id: chatId,
          sender_id: sender_id, // Set this to the current user ID
          message_text: messageText,
          message_type: "text",
          message_status: "sent",
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )

      .then((response) => {
        // Add message to chat window
        const chatWindow = document.querySelector(".chat-window");
        const messageElement = document.createElement("div");
        messageElement.className = "message sent";
        const formattedMessageText = messageText.replace(/\n/g, "<br>");
        messageElement.innerHTML = `<p class="mb-0">${formattedMessageText}</p>`;
        chatWindow.appendChild(messageElement);
        messageInput.value = "";
      })
      .catch((error) => console.error("Error sending message:", error));
  } else {
    const topicInput = document.querySelector("#topicInput");
    const TopicText = topicInput.value.trim();

    if (!TopicText) {
      showNotification("Title cannot be empty!", "error", "Oops!");
      return; // Stop execution if the message is empty
    }

    axios
      .post(
        API_URL + "/chats/",
        {
          name: TopicText,
          created_by: sender_id,
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )

      .then((response) => {
        const return_chat_id = response.data.return_chat_id;
        // alert(return_chat_id);
        axios
          .post(
            API_URL + "/messages/",
            {
              chat_id: return_chat_id,
              sender_id: sender_id, // Set this to the current user ID
              message_text: messageText,
              message_type: "text",
              message_status: "sent",
            },
            {
              headers: {
                "Content-Type": "application/json",
              },
            }
          )

          .then((response) => {
            // Add message to chat window
            const chatWindow = document.querySelector(".chat-window");
            const messageElement = document.createElement("div");
            messageElement.className = "message sent";
            const formattedMessageText = messageText.replace(/\n/g, "<br>");
            messageElement.innerHTML = `<p class="mb-0">${formattedMessageText}</p>`;
            chatWindow.appendChild(messageElement);
            messageInput.value = "";
          })
          .catch((error) => console.error("Error sending message:", error));
      })
      .catch((error) => console.error("Error sending message:", error));
  }
}

function sendImage() {
  const fileInput = document.querySelector("#fileInput");
  const file = fileInput.files[0];
  const chatId = currentChatId; // Set this to the current chat ID

  const formData = new FormData();
  formData.append("chat_id", chatId);
  formData.append("sender_id", currentUserId); // Set this to the current user ID
  formData.append("file", file);

  axios
    .post(API_URL + "/attachments/", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((response) => {
      // Add image message to chat window
      const chatWindow = document.querySelector(".chat-window");
      const attachment = response.data;
      const messageElement = document.createElement("div");
      messageElement.className = "message sent";
      messageElement.innerHTML = `<img src="${attachment.file_path}" alt="Image" />`;
      chatWindow.appendChild(messageElement);
    })
    .catch((error) => console.error("Error sending image:", error));
}

function sendMessageAndClearCache(senderId) {
  // Send the message (you might already have this function)

  // Clear the cache
  fetch("lib/live-chat/endpoints/clear-cache.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      senderId: senderId,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        console.log("Cache cleared successfully.");
      } else {
        console.error("Error clearing cache:", data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
}
