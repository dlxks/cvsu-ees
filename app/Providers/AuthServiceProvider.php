<?php

namespace App\Providers;

use App\Models\Chatbot;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Schedule;
use App\Models\Verified;
use App\Policies\ChatbotPolicy;
use App\Policies\ExamPolicy;
use App\Policies\ResultPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\VerifiedPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Applicant::class => ApplicantPolicy::class,
        Chatbot::class => ChatbotPolicy::class,
        College::class => CollegePolicy::class,
        Course::class => CoursePolicy::class,
        Exam::class => ExamPolicy::class,
        Result::class => ResultPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Subject::class => SubjectPolicy::class,
        Verified::class => VerifiedPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
