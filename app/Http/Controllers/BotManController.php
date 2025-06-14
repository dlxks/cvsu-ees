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

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */

    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new OptionConversation());
    }
}
