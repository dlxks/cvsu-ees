<?php

namespace App\Conversations;

use App\Models\Chatbot;
use App\Models\Message;
use App\Repositories\ChatbotRepositoryInterface;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OtherConversation extends Conversation
{

    protected $repo;

    public function __construct()
    {
        $this->repo = app(ChatbotRepositoryInterface::class);
    }

    public function run()
    {
        $this->askQuestion();
    }

    public function askQuestion()
    {
        return $this->ask('Do you have any other concerns or inquiries? Please leave a message below.', function (Answer $answer) {
            $this->concern = $answer->getText();
            $this->askName($this->concern);
        });
    }
    public function askName()
    {
        return $this->ask('Can you please enter your name?', function (Answer $answer) {
            $this->name = $answer->getText();
            $this->askContact($this->name);
        });
    }

    public function askContact($name)
    {
        return $this->ask('Your concern/inquiry was saved! Please leave also your contact information(email or contact number).', function (Answer $answer) {
            $this->contact = $answer->getText();

            Message::create([
                'name' => $this->name,
                'inquiry' => $this->concern,
                'contact' => $this->contact,
            ]);

            $this->bot->reply("Hi ".$this->name.". Your inquiry and your contact information '" . $this->contact . "' was saved.");
            $this->bot->reply("Thank you. Type 'Hi' to start new conversation.");
        });

        $question = Question::create("Do you have other concern?")
            ->fallback('Can not fetch question')
            ->callbackId('ask_question')
            ->addButtons([
                Button::create("Yes")->value("yes")->name('yes_chat'),
                Button::create("No")->value("no")->name('no_chat'),
            ]);

        $this->ask($question, function (Answer $answer) use ($id) {
            if ($answer->getValue() == 'yes') {
                $this->bot->startConversation(new OptionConversation());
            } elseif ($answer->getValue() == 'no') {
                $this->bot->reply("Thank you. Type 'Hi' to start new conversation.");
            }
        });
    }
}
