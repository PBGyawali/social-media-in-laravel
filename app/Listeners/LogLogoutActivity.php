<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Helper\Helper;
use App\Models\ActivityLog;
use App\Models\UserLog;
class LogLogoutActivity implements ShouldQueue
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
        if (auth()->user()){
            $id=auth()->id();
            $userlog=UserLog::find($id);
            if(!empty($userlog))
            $userlog->update(['last_logout'=>now()]);
            Helper:: activitylog($id,'logout','profile');
            //delete old activity logs
           ActivityLog::user_id($id)->old()->delete();
        }
        
    }

}
