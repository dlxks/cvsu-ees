<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use App\Conversations\OptionConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    // NLP handling is done natively via fallback logic in routes/botman.php
}
