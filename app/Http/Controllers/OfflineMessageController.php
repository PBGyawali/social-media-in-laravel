<?php

namespace App\Http\Controllers;
use App\Models\Alert;
use App\Models\OfflineMessage;
use App\Models\MessageLog;
use App\Models\Topic;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Events\ChatMessage;
use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class OfflineMessageController extends Controller
{

    public function index(Request $request)
    {
        $id=auth()->id();
        $messageid=$request->id??$id;
        $logged_username=$usermessages='';
        if($messageid!=$id){
            $logged_user=User::find($messageid);
            if($logged_user){
                $logged_username= 'for '.$logged_user->username;
            }
        }

        $page='messages';
        $view='admin.allmessages';
        if($request->route()->named('user.messages')){
            $view=$page;
            $messageid=$id;
        }
        $logged_message=Helper::messages($messageid);
        return view($view,compact('page',
       'logged_message','logged_username'));
    }


    public function create(Request $request)
    {
        $id=auth()->id();
        $user_id=$request->message_id??$id;
        $user=User::find($user_id);
        $chat_data=Helper::all_chat_data($user_id,$id);
        $conversation_id=optional(Conversation::where(function ($query) use ($id, $user_id) {
            $query->where('user_id',$user_id)
                  ->where('sender_id',$id);
        })->orWhere(function ($query) use ($id, $user_id) {
            $query->where('user_id',  $id)
                  ->where('sender_id', $user_id);
        })->first())->getKey();
        if($request->ajax()){
            $chatview='';
            foreach ($chat_data as $key => $chat){
                $float=$row_class='';
                $background_class =' mb-0 ';
                if( $id!=$chat->sender_id){
                    $row_class = ' flex-row-reverse ';
                    $float=' float-right ';
                }
                $chatview.= view('chat_message',compact('chat','float','background_class','row_class','id'))->render();
            } 
            return response()->json(compact('conversation_id','chatview'));
        }
        $page=$view='conversation';
        $topics=Topic::all();
        $user_data=User::all();
        return view($view,compact('page','user_data','chat_data','topics','id','user','conversation_id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => ['filled']
         ]);
       if($request->conversation_id){
        $chat=OfflineMessage::create($request->all());
       }       
       else{
        $user_id=$request->user_id;
        $sender_id=auth()->id();
        $conversation=Conversation::create(compact('user_id','sender_id'));
        $return_data['conversation_id']=$conversation->getKey();
        $chat=OfflineMessage::create(array_filter($request->all())+$return_data);
       }
       $float=$row_class='';
       $background_class =' alert-success mb-0';
       $id=auth()->id();
       $float=$row_class='';
       $chat_msg=view('chat_message',compact('id','float','row_class','background_class','chat'))->render();
       $row_class = ' flex-row-reverse ';
       $float=' float-right ';
       $background_class =' mb-0';
       $receiver_msg='';
       if($request->user_id!=auth()->id())
       $receiver_msg=view('chat_message',compact('id','float','row_class','background_class','chat'))->render();
       $receiver_id=$request->sender_id;
       try {
        $pusher = $this->get_pusher();

        $response = $pusher->trigger('chat-message'.$receiver_id, 'ChatMessage', 
        ['update' => $receiver_msg,'scroll'=>true,'id'=>$receiver_id]);
        if($response){
            $return_data['update']=$chat_msg;
            $return_data['id']=$request->user_id;
            $return_data['scroll']=true;
        }
    } catch (\Exception $e) {
        $return_data['error'] = $e->getMessage();
    }
   
    return response()->json($return_data);

       
    }

    public function typing(Request $request)
    {
       try {
        $pusher = $this->get_pusher();

        $response = $pusher->trigger('chat-message'.$request->sender_id, 'ChatMessage', 
        ['typing' => $request->message]);
        if($response){
            $return_data['status']=true;
        }
    } catch (\Exception $e) {
        $return_data['error'] = $e->getMessage();
    }
   
    return response()->json($return_data);

       
    }

    public function get_pusher()
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        return $pusher = new Pusher(env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
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
        return response()->json(array('messagecount'=>$count));

    }


    public function destroy(Request $request)
    {
        $return_data=[];
        switch($request->action){
            case 'delete':
                OfflineMessage::destroy($request->id);
                $return_data['delete']=$request->id;
           break;
           case 'delete_all':
            OfflineMessage::where(function ($query) use ($request) {
                                $query->user_id(auth()->id())
                                    ->sender_id($request->sender_id);
                            })
                            ->orWhere(function ($query) use ($request) {
                                $query->user_id($request->sender_id)
                                    ->sender_id(auth()->id());
                            })
                            ->delete();
            $return_data['delete_all']='#chatbox';
            $return_data['delete_id']=$request->id;
           break;
           case 'delete_for_all':
            OfflineMessage::destroy($request->id);
            $pusher = $this->get_pusher();
            $delete_message=view('deleted_message')->render();
            $response = $pusher->trigger('chat-message'.$request->sender_id, 
                                'ChatMessage', [
                                                'replace_id'=>$request->id,
                                                'replace'=>$delete_message,
                                                ]
                                );
            $return_data['delete']=$request->id;
            break;
          default:
            OfflineMessage::destroy($request->id);
           break;
       }
        $count=$this->show();
        $return_data['messagecount']=$count;
        return response()->json($return_data);
      
    }
}
