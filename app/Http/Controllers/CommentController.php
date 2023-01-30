<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Alert;
use App\Models\User;
use App\Helper\Helper;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $fields=array();


    public function store(Request $request)
    {
        $check=auth()->user();
        $user_id=$check->id;
        $this->fields["user_id"]=$user_id;
        $comment=Comment::create(array_merge($request->all(),$this->fields));
	    $inserted_id = $comment->id;
        $comment->username=$username=$comment->user->username;
        $comment->profile_image=basename($comment->user->profile_image);
        $comment_text=$comment->body;
        $receiver_id=$request->receiver_id;
        $title=$comment->post->title;
        $post_id=$request->post_id;
        $display=true;
        $html=view('comments',compact('comment','check','display'))->render();
        $comment_info = array("comment" => $html,"comments_count" => Comment::posts($post_id)->count());
        echo json_encode($comment_info);
        Helper::activitylogs($user_id, "You commented on","comment","post",$request->post_id,$title,$comment_text);
        if(!$check->is_same_user($receiver_id))
            Alert::create(array_combine(array("user_id","alert","type"),array($receiver_id,$username." commented on your post ".$title,"comment")));
     }

    public function update(Request $request)
    {
       $check=auth()->user();
       $comment=Comment::withuserdata()->find($request->id);
       $comment->update($request->only('body'));
       $html=view('comment_info',compact('comment','check'))->render();
       return response()->json(array('response'=>$html));
    }

    public function destroy(Request $request)
    {
        $comment=Comment::find($request->id);
        $comment->replies->each->delete();
        $comment->delete();
        Helper::activitylogs(auth()->id(), 'You deleted your '.$request->object.' on a' ,'delete','post',$request->post_id);
        return response()->json(array('response'=>Comment::posts($request->post_id)->count()));
    }
}
