<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsApplicant;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'isAdmin' => IsAdmin::class,
            'isApplicant' => IsApplicant::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('applicant.login'));

        $middleware->validateCsrfTokens(except: [
            'botman',
        ]);

        $middleware->trimStrings(except: [
            'current_password',
            'password',
            'password_confirmation',
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('schedule:active')->everyTenMinutes();
        $schedule->command('schedule:ended')->everyTenMinutes();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
