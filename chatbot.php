<?php
session_start();
header("Content-Type: text/plain");

require 'dialogflow.php'; // Include the Dialogflow connection file

// Check if the message is sent via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userMessage = trim($_POST["message"]);
    $projectId = 'YOUR_PROJECT_ID'; // Replace with your actual project ID

    // Get the response from Dialogflow
    $botResponse = detectIntent($projectId, $userMessage);
    echo $botResponse; // Return the bot's reply
} else {
    echo "Invalid request.";
}
?>