<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\Helper;

class FollowerController extends Controller
{

    public function index()
    {
        //
    }

    public function create($receiver_id,$sender_id,$action)
    {
        $username=User::find($sender_id)->username;
        $this->store($receiver_id,$sender_id,$action,$username);
    }

    public function store($receiver_id,$sender_id,$action,$username)
    {
        Helper::activitylogs($sender_id, 'You '.$action.'ed ',$action,'user',$receiver_id,$username,$receiver_id);
            Alert::create(array_combine(array('user_id','alert','type'),
            array($receiver_id,$username.' '.$action.'ed you ',$action)));
    }


    public function show()
    {
        return response()->json(array('error'=>"Sorry, You cannot follow yourself"));
    }


    public function edit(Follower $follower)
    {
         return response()->json($follower);
    }


    public function update(Request $request)
    {

        $action = $request->result;
        $receiver_id =$request->receiver_id;
        $sender_id=auth()->id();
        $fields['user_id']=$sender_id;
        if ($receiver_id==$sender_id){
      return $this->show();
    }
    else{
          switch ($action)
           {
                case 'follow':
                    Follower::create(array_combine(array('sender_id', 'receiver_id'),array($sender_id,$receiver_id)));
                    break;
                case 'unfollow':
                    $this->destroy($sender_id,$receiver_id);
                    break;
           }
    }
    $this->create($receiver_id,$sender_id,$action);
    return response()->json(array('response'=>"The user has been ".$action.'ed'));
   }


    public function destroy($sender_id,$receiver_id)
    {
        Follower::where('sender_id',$sender_id)->where('receiver_id',$receiver_id)->delete();
    }
}
