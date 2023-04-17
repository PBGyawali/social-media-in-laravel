<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Alert;
use App\Models\User;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public array $fields = [];

    public function store(Request $request)
    {
        $check=auth()->user();
        $comment=Comment::create($request->all());
	    $inserted_id = $comment->id;
        $comment->username=$username=$comment->user->username;
        $comment->profile_image=basename($comment->user->profile_image);
        $comment_text=$comment->body;
        $receiver_id=$request->receiver_id;
        $title=$comment->post->title;
        $post_id=$request->post_id;
        $display=true;
        $commentsCount=Comment::posts($post_id)->count();
        $html=view('comments',compact('comment','check','display'))->render();
        $comment_info = array("comment" => $html,"comments_count" => $commentsCount);
        // use eco instead return so that user gets response while we do our task in background
        echo json_encode($comment_info);
        Helper::activitylog($user_id, "comment","post",$request->post_id,$title,$comment_text);
        if(!$check->is_same_user($receiver_id)){
            $alertData = [
                'user_id' => (int) $receiver_id,
                'alert_name'=>$username,
                'alert_value'=>$title,
                'type' => 'comment',
            ];
            Alert::create($alertData);
        }            
     }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',], ['body.required' => 'The message field cannot be empty.',
        ]);
       $check=auth()->user();
       $comment=Comment::withuserdata()->find($request->id);
       $comment->update($request->only('body'));
       $html=view('comment_info',compact('comment','check'))->render();
       return response()->json(['response'=>$html]);
    }


    /**
     * Deletes a comment object from the database along with its replies based on the given request parameter.
     * Logs the deletion of the comment in the activity log table.
     * Returns the count of remaining comments related to the post with the given ID as a JSON response.
     *
     * @param Request $request The HTTP request object containing the comment ID and post ID.
     * @return JsonResponse The JSON response containing the count of remaining comments related to the post.
     */
    public function destroy(Request $request)
    {
        // Find the comment with the given ID
        $comment = Comment::find($request->id);

        // Delete all associated replies to the comment
        $comment->replies->each->delete();

        // Delete the comment itself
        $comment->delete();

        // Log the deletion of the comment in the activity log
        Helper::activitylog(auth()->id(),'delete','comment',$request->post_id);

        // get the count of remaining comments related to the post with the given post ID
        $commentsCount=Comment::posts($request->post_id)->count();

        // Return the count of remaining comments as a JSON response
        return response()->json(array('response'=>$commentsCount));
    }
   
}
