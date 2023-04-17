<?php

namespace App\Http\Controllers;

use App\Models\RatingInfo;
use App\Models\Post;
use App\Models\User;
use App\Models\Alert;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RatingInfoController extends Controller
{
    /**
     * This function retrieves the number of likes and dislikes for a given post.
     * @param int $post_id - The ID of the post.
     * @return array - An associative array containing the number of likes and dislikes.
     */
    public function index($post_id)
    {
        // Get the number of distinct user likes for the post
        $likes = RatingInfo::select('user_id')->distinct()
                            ->posts($post_id)->rated('like')
                            ->count('user_id');
        
        // Get the number of distinct user dislikes for the post
        $dislikes = RatingInfo::select('user_id')->distinct()
                                ->posts($post_id)->rated('dislike')
                                ->count('user_id');
        
        // Return an associative array containing the number of likes and dislikes
        return ['likes' => $likes, 'dislikes' => $dislikes];
    }




    public function createlogdata($receiver_id,$sender_id,$action,$post_id)
    {
        $username=User::find($sender_id)->username;
        $title=Post::find($post_id)->title;
        $this->storeActivity($receiver_id,$sender_id,$action,$post_id,$title,$username);
    }

    public function storeActivity($receiver_id,$sender_id,$action,$post_id,$title,$username)
    {
        Helper::activitylog($sender_id,$action,'post',$post_id,$title);

        if(!in_array($action,array('unlike','undislike')))
            // Use model mass assignment to create a new alert
            Alert::create([
                'user_id' => (int) $receiver_id,
                'alert_name'=>$username,
                'alert_value'=>$title,
                'type' => $action,
            ]);
    }


    public function update(Request $request)
    {

        $post_id = $request->post_id;
        $action = $request->rating_action;
        $receiver_id =$request->receiver_id;
        $sender_id=auth()->id();
        $fields['user_id']=$sender_id;
        switch ($action) {
          case 'like':
          case 'dislike':
            // update if the user has already liked or disliked the post else create a new entry
            RatingInfo::updateOrCreate(
                $fields + $request->only('post_id'),
                $request->only('rating_action')
            );
               break;
            case 'unlike':
          case 'undislike':
                $this->destroy($post_id,$sender_id);
            break;
        }
        $this->createlogdata($receiver_id,$sender_id,$action,$post_id);
        $count=$this->index($post_id);

        return response()->json($count);

    }

    public function destroy($post_id,$sender_id)
    {
        RatingInfo::user_id($sender_id)->posts($post_id)->delete();
    }
}
