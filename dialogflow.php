<?php
 if (session_status() == PHP_SESSION_NONE) {
     session_start();
 }
 include("php/config.php");
 if(!isset($_SESSION['valid'])){
  exit();
 }

require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;

function detectIntent($projectId, $text, $sessionId = '12345') {
    $credentialsPath = __DIR__ . '/config/protean-tooling-452817-p4-04972e916a0e.json';
    putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");

    try {
        $sessionsClient = new SessionsClient();
        $session = $sessionsClient->sessionName($projectId, $sessionId);

        $textInput = (new TextInput())->setText($text)->setLanguageCode('en');
        $queryInput = (new QueryInput())->setText($textInput);

        $response = $sessionsClient->detectIntent($session, $queryInput);
        $queryResult = $response->getQueryResult();
        $reply = $queryResult->getFulfillmentText();

        // Debugging information
        error_log("Query Text: " . $queryResult->getQueryText());
        error_log("Detected Intent: " . $queryResult->getIntent()->getDisplayName());
        error_log("Fulfillment Text: " . $reply);

        $sessionsClient->close();
        return $reply;
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

// Example usage
$projectId = 'mindmate-452817';
$message = 'Hello, how are you?';
$reply = detectIntent($projectId, $message);
echo $reply;
?>