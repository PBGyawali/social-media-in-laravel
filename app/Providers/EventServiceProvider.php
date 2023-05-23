<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use App\Events\UserDeactivated;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\LogVerifiedUser;
use App\Listeners\SendDeactivationEmail;
use App\Listeners\LogLoginActivity;
use App\Listeners\LogLogoutActivity;
use App\Listeners\LogPasswordReset;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserDeactivated::class => [
            SendDeactivationEmail::class,
        ],
        Login::class => [
                  LogLoginActivity::class,
        ], 
        Logout::class => [
            LogLogoutActivity::class,
        ],
        PasswordReset::class => [
            LogPasswordReset::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
