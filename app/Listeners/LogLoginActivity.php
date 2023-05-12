<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Helper\Helper;
use App\Models\ActivityLog;
use App\Models\UserLog;
class LogLoginActivity implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        $id=auth()->id();
            $userlog=UserLog::find($id);
            if(!empty($userlog->user_id))
            $userlog->update(['last_login_attempt'=>now()]);
            Helper:: activitylog($id,'login','profile');

        
    }

}
