<?php

namespace App\Http\Controllers;

use App\Models\RatingInfo;
use App\Models\Post;
use App\Models\User;
use App\Models\Alert;
use App\Helper\Helper;
use Illuminate\Http\Request;

class RatingInfoController extends Controller
{

    public function index($post_id)
    {
        $rating = [
            'likes' =>RatingInfo::where('post_id',$post_id)->where('rating_action','like')->count(),//needs to be maanaged
            'dislikes' => RatingInfo::where('post_id',$post_id)->where('rating_action','dislike')->count()
        ];
        return $rating;
    }

    public function create($receiver_id,$sender_id,$action,$post_id)
    {
        $username=User::find($sender_id)->username;
        $title=Post::find($post_id)->title;
        $this->store($receiver_id,$sender_id,$action,$post_id,$title,$username);
    }

    public function store($receiver_id,$sender_id,$action,$post_id,$title,$username)
    {
        Helper::activitylogs($sender_id, 'You '.$action.'d ',$action,'post',$post_id,$title);
        if(!in_array($action,array('unlike','undislike')))
            Alert::create(array_combine(array('user_id','alert','type'),
            array($receiver_id,$username.' '.$action.'d your post '.$title,$action)));

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
            RatingInfo::upsert(array_merge($request->only('rating_action','post_id'),$fields),$request->only('user_id,post_id'),$request->only('rating_action'));
               break;
            case 'unlike':
          case 'undislike':
                $this->destroy($post_id,$sender_id);
            break;
        }
        $this->create($receiver_id,$sender_id,$action,$post_id);
        $count=$this->index($post_id);
        return response()->json($count);
    }

    public function destroy($post_id,$sender_id)
    {
        RatingInfo::where('user_id',$sender_id)->where('post_id',$post_id)->delete();
    }
}
