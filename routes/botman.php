<?php

use BotMan\BotMan\Middleware\Dialogflow;
use Google\Cloud\Dialogflow\V2\Client\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;
use Illuminate\Support\Facades\Log;

$botman = resolve('botman');

$botman->hears('(?i).*\\b(hi|hello|hey|good morning|good afternoon)\\b.*', function ($bot) {
    $response = 'Welcome to Cavite State University! I am your CvSU Admission Assistant. How can I help you today?';
    $bot->reply($response);
    
    \App\Models\ChatLog::create([
        'session_id' => $bot->getUser()->getId() ?: uniqid(),
        'user_message' => $bot->getMessage()->getText(),
        'bot_response' => $response,
    ]);
});

$botman->fallback(function ($bot) {
    $userMessage = $bot->getMessage()->getText();
    $projectId = env('DIALOGFLOW_PROJECT_ID');
    
    if (!$projectId) {
        $bot->reply("Dialogflow Project ID is not configured.");
        return;
    }

    try {
        $sessionsClient = new SessionsClient();
        // Use the Botman user ID as the session ID to maintain conversation context per user
        $sessionId = $bot->getUser()->getId() ?: uniqid();
        $session = $sessionsClient->sessionName($projectId, $sessionId);

        $textInput = new TextInput();
        $textInput->setText($userMessage);
        $textInput->setLanguageCode('en-US');

        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        $request = (new DetectIntentRequest())
            ->setSession($session)
            ->setQueryInput($queryInput);

        $response = $sessionsClient->detectIntent($request);
        $queryResult = $response->getQueryResult();
        $fulfillmentText = $queryResult->getFulfillmentText();

        if ($fulfillmentText) {
            $bot->reply($fulfillmentText);
        } else {
            $fulfillmentText = "I'm sorry, I couldn't understand that. Could you try rephrasing your question?";
            $bot->reply($fulfillmentText);
        }

        \App\Models\ChatLog::create([
            'session_id' => $sessionId,
            'user_message' => $userMessage,
            'bot_response' => $fulfillmentText,
        ]);

        $sessionsClient->close();
    } catch (\Exception $e) {
        Log::error("Dialogflow V2 API Error: " . $e->getMessage());
        $bot->reply("Sorry, I am currently unable to process your request due to an AI service error.");
    }
});
