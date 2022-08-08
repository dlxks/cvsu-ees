<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OptionConversation extends Conversation
{
    // Variables
    protected $firstname;
    protected $email;

    // Boot function
    public function startup()
    {
        $question = Question::create("Hello! Good day! Choose topic related to your concern:")
            ->fallback('Unable to ask question')
            ->callbackId('ask_option')
            ->addButtons([
                Button::create('Requirements')->value('requirements'),
                Button::create('Admission Process')->value('admission'),
                Button::create('Choice of Course Concerns')->value('course'),
                Button::create('Contact Information')->value('contact'),
                Button::create('Don\'t see any topic related to your concern?')->value('other'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $value = $answer->getValue();

                switch ($value) {
                    case 'requirements':
                        $this->bot->startConversation(new RequirementConversation());
                        break;
                    case 'admission':
                        $this->bot->startConversation(new AdmissionConversation());
                        break;
                    case 'course':
                        $this->bot->startConversation(new CourseConversation());
                        break;
                    case 'contact':
                        $this->bot->startConversation(new ContactConversation());
                        break;
                    case 'other':
                        $this->bot->startConversation(new OtherConversation());
                        break;
                }
            }
        });
    }

    public function run()
    {
        // This will be called immediately
        $this->startup();
    }
}
