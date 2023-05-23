<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Helper\Helper;
use App\Models\ActivityLog;
use App\Models\UserLog;
use App\Models\Alert;
class LogPasswordReset
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        Helper::activitylog($user->getKey(),'reset','password');
            
        Alert::create([
         'user_id' => $user->getKey(),
         'alert' => trans('alert.password_reset'),
         'type' => 'info',
     ]);
    }
}
