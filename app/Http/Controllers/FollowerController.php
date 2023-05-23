<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\Helper;

class FollowerController extends Controller
{

    public function create($receiver_id,$sender_id,$action)
    {
        $username=User::find($sender_id)->username;
        $this->store($receiver_id,$sender_id,$action,$username);
    }

    public function store($receiver_id,$sender_id,$action,$username)
    {
        Helper::activitylog($sender_id,$action,'user',$receiver_id,$username,$receiver_id);
            $alertData = [
                'user_id' => (int) $receiver_id,
                'alert_name'=>$username,
                'type' => $action,
            ];
            Alert::create($alertData);
    }


    public function show()
    {
        return response()->json(array('error'=>__('auth.follow')));
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
                        Follower::create([
                            'sender_id' => $sender_id,
                            'receiver_id' => $receiver_id,
                        ]);
                        break;
                    case 'unfollow':
                        $this->destroy($sender_id,$receiver_id);
                        break;
            }
        }
        $this->create($receiver_id,$sender_id,$action);
        return response()->json(array('response'=>__('message.follow',['action'=>$action.'ed'])));
    }


    public function destroy($sender_id,$receiver_id)
    {
        Follower::where('sender_id',$sender_id)->where('receiver_id',$receiver_id)->delete();
    }
}
