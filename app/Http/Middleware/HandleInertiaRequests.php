<?php

namespace App\Http\Middleware;

use App\Models\Chatbot;
use App\Models\College;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Verified;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    { {
            $authUser = $request->user();

            return array_merge(parent::share($request), [
                'permission' => function () use ($authUser) {
                    if (!$authUser) return;

                    return [
                        'applicants' => [
                            'viewAny' => $authUser->can('viewAny', Applicant::class),
                            'view' => $authUser->can('view', Applicant::class),
                            'create' => $authUser->can('create', Applicant::class),
                            'update' => $authUser->can('update', Applicant::class),
                            'delete' => $authUser->can('delete', Applicant::class),
                            'editRole' => $authUser->hasRole('admin'),
                        ],

                        'chatbot' => [
                            'viewAny' => $authUser->can('viewAny', Chatbot::class),
                            'view' => $authUser->can('view', Chatbot::class),
                            'create' => $authUser->can('create', Chatbot::class),
                            'update' => $authUser->can('update', Chatbot::class),
                            'delete' => $authUser->can('delete', Chatbot::class),
                        ],

                        'colleges' => [
                            'viewAny' => $authUser->can('viewAny', College::class),
                            'view' => $authUser->can('view', College::class),
                            'create' => $authUser->can('create', College::class),
                            'update' => $authUser->can('update', College::class),
                            'delete' => $authUser->can('delete', College::class),
                        ],

                        'courses' => [
                            'viewAny' => $authUser->can('viewAny', Course::class),
                            'view' => $authUser->can('view', Course::class),
                            'create' => $authUser->can('create', Course::class),
                            'update' => $authUser->can('update', Course::class),
                            'delete' => $authUser->can('delete', Course::class),
                        ],

                        'exams' => [
                            'viewAny' => $authUser->can('viewAny', Exam::class),
                            'view' => $authUser->can('view', Exam::class),
                            'create' => $authUser->can('create', Exam::class),
                            'update' => $authUser->can('update', Exam::class),
                            'delete' => $authUser->can('delete', Exam::class),
                        ],

                        'schedules' => [
                            'viewAny' => $authUser->can('viewAny', Schedule::class),
                            'view' => $authUser->can('view', Schedule::class),
                            'create' => $authUser->can('create', Schedule::class),
                            'update' => $authUser->can('update', Schedule::class),
                            'delete' => $authUser->can('delete', Schedule::class),
                        ],

                        'results' => [
                            'viewAny' => $authUser->can('viewAny', Result::class),
                            'view' => $authUser->can('view', Result::class),
                            'create' => $authUser->can('create', Result::class),
                            'update' => $authUser->can('update', Result::class),
                            'delete' => $authUser->can('delete', Result::class),
                        ],

                        'users' => [
                            'viewAny' => $authUser->can('viewAny', User::class),
                            'view' => $authUser->can('view', User::class),
                            'create' => $authUser->can('create', User::class),
                            'update' => $authUser->can('update', User::class),
                            'delete' => $authUser->can('delete', User::class),
                        ],

                        'verifieds' => [
                            'viewAny' => $authUser->can('viewAny', Verified::class),
                            'view' => $authUser->can('view', Verified::class),
                            'create' => $authUser->can('create', Verified::class),
                            'update' => $authUser->can('update', Verified::class),
                            'delete' => $authUser->can('delete', Verified::class),
                        ],
                    ];
                },
            ]);
        }
    }
}
