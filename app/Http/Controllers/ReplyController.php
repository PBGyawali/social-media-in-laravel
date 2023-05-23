<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Helper\Helper;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\Comment;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
            $reply_text = $request->body;
            $comment_id =  $request->comment_id;
            $receiver_id =  $request->receiver_id;
            $check=auth()->user();
            $user_id=$check->id;
            $reply=Reply::create(array_combine(array('user_id','comment_id','body'),array($user_id,$comment_id,$reply_text)));
            $reply->username=$reply->user->username;
            $reply->profile_image=basename($reply->user->profile_image);
            $html=view('replies',compact('reply','check'))->render();
            $comments=Comment::find($comment_id)->body;
            Helper::activitylog($user_id,'reply','comment',$comment_id,$comments,$reply->body);
            if(!$check->is_same_user($receiver_id))
                Alert::create(array_combine(array('user_id','alert','type'),array($receiver_id,$reply->username.' replied on your comment '.$comments,'reply')));
            return response()->json(array('comments'=>$html));
}

    public function update(Request $request)
    {
       $check=auth()->user();
       $user_id=$check->id;
       $reply=Reply::withuserdata()->find($request->id);
       $reply->update($request->only('body'));
       $html=view('reply_info',compact('reply','check'))->render();
       return response()->json(array('comments'=>$html));
    }

    public function destroy(Request $request,Reply $reply)
    {
        Reply::destroy($request->id);
        Helper::activitylog(auth()->id(),'delete','reply',$request->post_id);
        return response()->json(array('reply'=>''));
    }
}
