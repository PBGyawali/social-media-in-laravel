<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserDeactivated;

use App\Notifications\AccountDeactivatedNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDeactivationEmail implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  UserDeactivated  $event
     * @return void
     */
    public function handle(UserDeactivated $event)
    {
        $user = $event->user;

        $user->notify(new AccountDeactivatedNotification);
    }

}
