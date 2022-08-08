<?php

namespace App\Conversations;

use App\Models\Chatbot;
use App\Models\Message;
use App\Repositories\ChatbotRepositoryInterface;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class AdmissionConversation extends Conversation
{

    protected $repo;

    public function __construct()
    {
        $this->repo = app(ChatbotRepositoryInterface::class);
    }

    public function run()
    {
        $concerns = $this->repo->all()->where('category', 'Admission');

        $buttons = [];

        foreach ($concerns as $concern) {
            $buttons[] = Button::create($concern->question)
                ->value($concern->id)
                ->name('concern');
        }
        $buttons[] = Button::create('Didn\'t see any question related to your concern?')
            ->value('other')
            ->name('other_concern');


        $question = Question::create("Find any related question to your concern.")
            ->fallback('Can not fetch all questions')
            ->callbackId('ask_all_questions')
            ->addButtons($buttons);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->handleValue($answer->getValue());
            }
        });
    }

    public function handleValue(string $id)
    {
        $chatbot = Chatbot::find($id);
        $botman = resolve('botman');

        if ($id === "other") {
            $this->askMessage($id);
        } else {
            $this->bot->reply("Question: " . $chatbot->question . "<br>Answer: " . $chatbot->answer);
            $this->askQuestion($id);
        }
    }

    // Ask other concern
    public function askQuestion(string $id)
    {
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

    // Leave Message
    public function askMessage(string $id)
    {
        return $this->ask('Do you have any other concerns or inquiries? Please leave a message below.', function (Answer $answer) {
            $this->concern = $answer->getText();
            $this->askContact($this->concern);
        });
    }
    // Ask Contact
    public function askContact($concern)
    {
        return $this->ask('Your concern/inquiry was saved! Please leave also your contact information(email or contact number).', function (Answer $answer) {
            $this->contact = $answer->getText();

            Message::create([
                'inquiry' => $this->concern,
                'contact' => $this->contact,
            ]);

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
