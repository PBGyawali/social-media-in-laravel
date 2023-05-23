<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->greeting(__('Hello :name', ['name' => $notifiable->username]))
                ->line('Please Click the button below to verify your email address.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create this account please ignore this email then,
                no further action would be required.');
        });


        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            return (new MailMessage)
                ->subject('Reset Password Request Notofication')
                ->greeting(__('Hello :name', ['name' => $notifiable->username]))
                ->line('You are receiving this email because we received
                 a password reset request for your account.')
                ->line('Please Click the button below to reset your Password.')
                ->action('Reset Password', $url)
                ->line(__('This password reset link will expire in :count minutes.',
                ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line('If you did not make this reset request please ignore
                this email then, no further action would be required.');

        });
    }
}
