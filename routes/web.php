<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\ChoiceController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\ApplicantDashboardController;
use App\Http\Controllers\Applicant\ApplicantExamController;
use App\Http\Controllers\Applicant\ApplicantLoginController;
use App\Http\Controllers\Applicant\ApplicantResultController;
use App\Http\Controllers\Applicant\ApplicantUpdateController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect(route('admin.dashboard.index'));
    } else {
        return Inertia::render('Auth/Login');
    }
});
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {

        // Dashboard
        Route::resource('dashboard', AdminDashboardController::class);

        // Users routes
        Route::resource('users', UserController::class);

        // College routes
        Route::resource('colleges', CollegeController::class);

        // Course routes
        Route::resource('courses', CourseController::class);

        // Applicant routes
        Route::resource('applicants', ApplicantController::class);
        Route::get('/export/applicants', [ApplicantController::class, 'export'])->name('applicants.export'); //Export data
        Route::get('/pdf/applicants', [ApplicantController::class, 'generate_pdf'])->name('applicants.pdf'); //Export pdf

        // Exam routes
        Route::resource('exams', ExamController::class);
        Route::post('status', [ExamController::class, 'statusChange'])->name('exam.status.change');

        // Question routes
        Route::resource('questions', QuestionController::class);

        // Choice routes
        Route::resource('choices', ChoiceController::class);

        // Schedule routes
        Route::resource('schedules', ScheduleController::class);
        Route::get('send-schedule', [ScheduleController::class, 'sendNotification'])->name('send.schedule');

        // Results routes
        Route::resource('results', ResultController::class);
        Route::get('/export/results', [ResultController::class, 'export'])->name('results.export'); //Export data
        Route::get('/pdf/results', [ResultController::class, 'generate_pdf'])->name('results.pdf'); //Export pdf
        Route::get('send-notification', [ResultController::class, 'sendNotification'])->name('send.notif');

        // Chatbot routes
        Route::resource('chatbot', ChatbotController::class);
        Route::post('chatbot-import', [ChatbotController::class, 'import'])->name('chatbot.import');
    });

Route::prefix('applicant')
    ->as('applicant.')
    ->group(function () {
        Route::get('login', [ApplicantLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [ApplicantLoginController::class, 'login'])->name('post.login');
        Route::post('logout', [ApplicantLoginController::class, 'logout'])->name('logout');

        Route::group(['middleware' => ['auth:sanctum', 'verified', 'isApplicant']], function () {
            // Dashboard
            Route::resource('dashboard', ApplicantDashboardController::class);

            // Applicant update
            Route::resource('profile', ApplicantUpdateController::class);
            Route::post('update-personal', [ApplicantUpdateController::class, 'updatePersonal'])->name('update.personal');
            Route::post('update-profile', [ApplicantUpdateController::class, 'updateProfile'])->name('update.profile');

            // Exam
            Route::resource('exams', ApplicantExamController::class);
            Route::post('test',[ApplicantExamController::class, 'postExam'])->name('post.test');

            // Result
            Route::resource('results', ApplicantResultController::class);
            Route::get('/pdf/result', [ApplicantResultController::class, 'export_pdf'])->name('result.pdf'); //Export pdf
            
        });
    });

Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
