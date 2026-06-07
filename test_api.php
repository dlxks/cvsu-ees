<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $sessionsClient = new Google\Cloud\Dialogflow\V2\Client\SessionsClient();
    $session = $sessionsClient->sessionName(env('DIALOGFLOW_PROJECT_ID'), '1234');
    $textInput = new Google\Cloud\Dialogflow\V2\TextInput();
    $textInput->setText('hello');
    $textInput->setLanguageCode('en-US');
    $queryInput = new Google\Cloud\Dialogflow\V2\QueryInput();
    $queryInput->setText($textInput);
    $request = (new Google\Cloud\Dialogflow\V2\DetectIntentRequest())
        ->setSession($session)
        ->setQueryInput($queryInput);
    $sessionsClient->detectIntent($request);
    echo "API_SUCCESS\n";
} catch (\Exception $e) {
    echo "API_ERROR: " . $e->getMessage() . "\n";
}
