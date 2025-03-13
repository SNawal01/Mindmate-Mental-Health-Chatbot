<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindMate - Chatbot</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/chatbox.css">
</head>
<body>

    <div class="mind-health-text">Welcome to MindMate <br>Your Peaceful Mind Health Companion</div>

    <div class="chat-container">
        <div class="chat-header">
            MindMate <br>
            Your Mental Health Assistant
            <button onclick="window.location.href='homepage.php'">Go to Homepage</button>
        </div>
        <div class="chat-box" id="chat-box">
            <!-- Messages will be dynamically loaded here -->
        </div>
        <div class="chat-input">
            <input type="text" id="user-message" placeholder="Type a message..." autocomplete="off">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <div id="chatbox"></div>
    <input type="text" id="userInput" placeholder="Type your message...">
    <button onclick="sendMessageAlt()">Send</button>

    <script>
        function sendMessage() {
            var userMessage = document.getElementById("user-message").value.trim();
            if (userMessage === "") return; 

            // Display user message in chat
            var chatBox = document.getElementById("chat-box");
            var userDiv = document.createElement("div");
            userDiv.className = "chat-message user";
            userDiv.innerHTML = userMessage;
            chatBox.appendChild(userDiv);
            chatBox.scrollTop = chatBox.scrollHeight;

            // Send message to chatbot
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chatbot.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var botDiv = document.createElement("div");
                    botDiv.className = "chat-message bot";
                    botDiv.innerHTML = xhr.responseText;
                    chatBox.appendChild(botDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            };
            xhr.send("message=" + encodeURIComponent(userMessage));

            // Clear input field
            document.getElementById("user-message").value = "";
        }
    </script>

    <script>
        function sendMessageAlt() {
            var userMessage = document.getElementById("userInput").value;
            document.getElementById("chatbox").innerHTML += "<p><b>You:</b> " + userMessage + "</p>";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chatbot.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("chatbox").innerHTML += "<p><b>Bot:</b> " + xhr.responseText + "</p>";
                }
            };
            xhr.send("message=" + encodeURIComponent(userMessage));
        }
    </script>

</body>
</html>