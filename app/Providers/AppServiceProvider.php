<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade Component
        Blade::component('layouts.components.card', 'card');

        // Authorization Gates
        $this->defineGates();

        // Custom Blade Directives
        $this->registerBladeDirectives();

        // Custom Email Verification Notification (OPTIONAL)
        $this->customizeEmailVerification();
    }

    /**
     * Define authorization gates.
     */
    protected function defineGates(): void
    {
        Gate::define('is-technician', function (User $user) {
            return $user->role === 'technician' && $user->status === 'active';
        });

        Gate::define('is-client', function (User $user) {
            return $user->role === 'client';
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('is-pending-technician', function (User $user) {
            return $user->role === 'technician' && $user->status === 'pending';
        });
    }

    /**
     * Register custom Blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        Blade::if('technician', function () {
            return auth()->check() && auth()->user()->role === 'technician';
        });

        Blade::if('client', function () {
            return auth()->check() && auth()->user()->role === 'client';
        });

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role === 'admin';
        });

        Blade::if('pendingTechnician', function () {
            return auth()->check() && 
                   auth()->user()->role === 'technician' && 
                   auth()->user()->status === 'pending';
        });
    }

    /**
     * Customize the email verification notification (OPTIONAL).
     */
    protected function customizeEmailVerification(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Your Email Address')
                ->greeting("Hello {$notifiable->name}!")
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email', $url)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}