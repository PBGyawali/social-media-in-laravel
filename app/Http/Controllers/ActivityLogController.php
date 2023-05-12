<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\OfflineMessage;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class ActivityLogController extends Controller
{

    /**
    *This method displays the activity log for the currently logged in user or for the user whose ID is passed in the request.
    *@param Request $request The incoming request containing the user ID to display activity log for (optional).
    *@return \Illuminate\Contracts\View\View Returns the view containing the activity log for the specified user or the currently logged in user.
    */
    public function index(Request $request)
    {
        // Get the ID of the currently logged in user.
        $id = auth()->id();

        // Check if a user ID was passed in the request.
        $logid = $request->id ?? $id;

        // Set the default view and page title.
        $page = 'activitylog';
        $view = 'admin.activitylog';

        // If the route is for a user's activity log, set the view and page title accordingly.
        if ($request->route()->named('user.activitylog')) {
            $view = 'activitylog';
            $logid = $id;
        }

        // Initialize the logged in username variable.
        $logged_username = '';

        // If the user ID is not the same as the currently logged in user ID, get the username of the specified user.
        if ($logid != $id) {
            $logged_user = User::find($logid);
            if ($logged_user) {
                $logged_username ='for '. $logged_user->username;
            }
        }

        // Get the activity logs for the specified user or the currently logged in user and paginate the results.
        $logs = ActivityLog::user_id($logid)->latest()->cursorPaginate();

        // Return the view containing the activity logs and relevant data.
        return view($view, compact('logs', 'logged_username'));
    }


    public function show(Request $request)
    {
        $post_id=$request->post_id;
        $userid=$request->user_id;
        $browser=$request->browser;
        $this->update($post_id,$userid,$browser);
    }
    public function update($post_id,$userid,$browser)
    {
        //update the visit only if the session has not recorded the page view
        if(!session()->has('page='.$post_id))
        {
            //record the visit
            session(['page='.$post_id =>"yes"]);
            //update the visit for current post
            // $counter_table =DB::table('posts')->find($post_id);
            // $counter_value =$counter_table->views;
            // $counter_value++;
            // DB::table('posts')->where('id',$post_id)->update(['views'=>$counter_value]);
            Post::find($post_id)->increment('views');
            //store the total visit and browser visit for the user
            $this->store($post_id,$userid,$browser);
        }
    }
    public function store($post_id,$user_id,$browser)
    {
        //dont update the visit if the session has alread recorded the page view
        if(session()->has('page='.$post_id))
        {
            //browser name is recognized and sent by javascript
            $attr = [$browser => DB::raw($browser.'+1')];

            //browser value is 1 since it is being visited for the first time
            $data = [
                        $browser => 1,
                        'post_id' => $post_id,
                        'owner_id' => $user_id,
                    ];

            $updateColumns = ['post_id', 'owner_id'];
            //update row if value exist, or insert a new row if value doesn't exist
           // return DB::table('visitor_log')->upsert($data, $updateColumns, $attr);
           return DB::table('visitor_log')->updateOrInsert(
                            ['post_id' => $post_id,'owner_id' => $user_id],
                            $attr
                        );
        }
    }

    public function destroy(Request $request)
    {
        //deleting similar aactivity log type only
        if($request->action=='delete_similar')
            ActivityLog::type($request->type)->user_id($request->id)->delete();
        else
        ActivityLog::destroy($request->id);
        //return empty response so that javascript doesn't throw exception
        return response()->json('');
    }
}
