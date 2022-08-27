<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\ChatbotRepository;
use App\Repositories\ChatbotRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChatbotRepositoryInterface::class, ChatbotRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bypass Policy
        Gate::before(function (User $user) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        $this->app['request']->server->set('HTTPS', 'on');
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
