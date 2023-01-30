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
class ActivityLogController extends Controller
{
    public function index(Request $request)
    {

        $id=auth()->id();
        $logid=$request->id?$request->id:auth()->id();
        $info=$page='activitylog';
        $view='admin.activitylog';
        if($request->route()->named('user.activitylog')){
            $view=$page;
            $info=WebsiteInfo::first();
            $logid=$id;
        }
        $logged_username='';
        if($logid!=$id){
            $logged_user=User::find($logid);
            if($logged_user)
            $logged_username= $logged_user->username;
        }
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        $logs=ActivityLog::user_id($logid)->latest()->cursorPaginate();
        return view($view,compact('logs','page','messages','messagecount',
        'alertcount','alerts','info','logged_username'));
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
        if(!session()->has('page='.$post_id))
        {
            session(['page='.$post_id =>"yes"]);
            $counter_table =DB::table('posts')->find($post_id);
            $counter_value =$counter_table->views;
            $counter_value++;
            DB::table('posts')->where('id',$post_id)->update(['views'=>$counter_value]);
            $this->store($post_id,$userid,$browser);
        }
    }
    public function store($post_id,$user_id,$browser)
    {
        if(session()->has('page='.$post_id))
        {
            $attr=array($browser=>DB::raw($browser.'+1'));
           return DB::table('visitor_log')
            ->upsert(array_combine(array($browser, 'post_id', 'owner_id'),
            array(1,$post_id,$user_id)),
            ['post_id,owner_id'],$attr);
        }
    }

    public function destroy(Request $request)
    {
        if($request->action=='delete_similar')
            ActivityLog::type($request->type)->user_id($request->id)->delete();
        else
        ActivityLog::destroy($request->id);
        return response()->json('');
    }
}
