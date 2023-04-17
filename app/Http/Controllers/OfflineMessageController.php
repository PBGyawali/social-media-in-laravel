<?php

namespace App\Http\Controllers;
use App\Models\Alert;
use App\Models\OfflineMessage;
use App\Models\MessageLog;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Events\NewChatMessage;
use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\DB;

class OfflineMessageController extends Controller
{

    public function index(Request $request)
    {
        $id=auth()->id();
        $messageid=$request->id?$request->id:$id;
        $logged_message=$messages=Helper::messages($id);
        $alerts=Helper::alerts($id);
        $log_username=$usermessages=$useralerts='';
        if($messageid!=$id){
           $logged_user=User::find($messageid);
            if($logged_user){
                $log_username= $logged_user->username;
                $logged_message=Helper::messages($messageid);
            }
        }
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $info=$page='messages';
        $view='admin.allmessages';
        if($request->route()->named('user.messages')){
            $view=$page;
            $info=WebsiteInfo::first();
        }
        return view($view,compact('messages','page','alertcount',
        'alerts','messagecount','info','log_username','logged_message'));
    }


    public function create(Request $request)
    {
        $id=auth()->id();
        $user_id=$request->message_id?$request->message_id:$id;
        $user=User::find($user_id);
        $messages=Helper::get_conversation($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
        $chat_data=Helper::all_chat_data($user_id,$id);
        $page=$view='conversation';
        $info=WebsiteInfo::first();
        $topics=Topic::all();
        $user_data=User::all();
        return view($view,compact('messages','page','alertcount','alerts',
        'messagecount','info','user_data','chat_data','topics','id','user'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => ['filled']
         ]);
        //event(new NewChatMessage($request->message, $request->user_id));
       // return response()->json([], 200);
       $chat= $message=OfflineMessage::create($request->all());
        $float=$row_class='';
        $background_class =' alert-success mb-0';
        $id=auth()->id();
        $float=$row_class='';
        $background_class =' alert-success ';
        $chat_msg=view('chat_message',compact('id','float','row_class','background_class','chat'))->render();
        return response()->json(array('update'=>$chat_msg));
    }

    public function show()
    {
       return OfflineMessage::user_id(auth()->id())->read()->count();
    }

    public function edit(OfflineMessage $offlineMessage)
    {
        return response()->json($offlineMessage);
    }

    public function update(Request $request, OfflineMessage $offlineMessage)
    {
        switch($request->action){
             case 'read':
                $key='read_by_user';$value='yes';
            break;
            case 'notification':
                $keys='notification';$values='off';
            break;
            case 'archive':
                $keys='archive';$values='yes';
            break;
        }

        OfflineMessage::find($request->id)->update([$key=>$value]);
        $count=$this->show();
        return response()->json(array('response'=>$count));
    }


    public function destroy(Request $request)
    {
        switch($request->action){
            case 'delete':
                OfflineMessage::destroy($request->id);
           break;
           case 'deleteaall':
            OfflineMessage::user_id(auth()->id())->sender_id($request->sender_id)->delete();
           break;
          default:
            OfflineMessage::destroy($request->id);
           break;
       }
        $count=$this->show();
        return response()->json(array('count'=>$count,'delete'=>$request->id));
    }
}
