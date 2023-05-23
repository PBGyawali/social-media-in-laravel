<?php

namespace App\Http\Controllers;
use App\Models\Alert;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\OfflineMessage;
use App\Models\TicketComment;
use App\Helper\Helper;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{

    public function  index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::orderby('created_at');
            if($request->from_date!=''&& $request->to_date!='')
                $query->whereBetween('created_at',[$request->from_date, $request->to_date]);
             $data=$query->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    // primary key of the row
                    $id=$data->id;
                    // status of the row
                    $status=$data->status;
                    // data to display on modal, tables
                    $prefix="ticket";
                    $target='#detailModal';
                    // optional button to display
                    $buttons=['update',auth()->user()->is_admin()?'delete':'',];
                    $actionBtn = view('control-buttons',compact('buttons','id','status','prefix','target'))->render();
                     return $actionBtn;
                })
                ->addColumn('status_icon', function($data){
                    return $data->status_icon;
                })
                ->make(true);
        }
      $page='tickets';
      return view ('admin.tickets',compact('page'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:255|email|string',
            'msg' => 'required|string',
            'title' => 'required|max:255|string',
        ]);

        DB::beginTransaction();
        try {
            $ticket = Ticket::create($request->all());

            if ($request->has('ticket_comments')) {
                $TicketComments = [];
                foreach (array_filter($request->ticket_comments) as $msg) {
                    $TicketComments[] = [
                                        'ticket_id' => $ticket->id,
                                        'msg' => $msg,
                                        'user_id'=>auth()->id()
                                    ];
                }
                // batch insertion into comments table
                TicketComment::insert($TicketComments);
            }
            DB::commit();
            if ($request->ajax()){
                return response()->json(['response'=>__('message.create',['name'=>'ticket'])]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()){
                return response()->json(['response'=>__('message.error.delete',['reason'=>$e->getMessage()])]);
            }
        }
    }

     public function edit(Ticket $ticket)
    {
        
        // Get the comments for the ticket and their related user's profile images and usernames
        $comments = $ticket->comments()->with('user')->get();
        $totalcomments='';
        foreach($comments as $key=> $comment){
            $message=$comment->msg;
            $created_at=$comment->created_at;
            $id=$comment->id;
            $username=$comment->user->username;
            $profile_image=$comment->user->profile_image;
            $ticketComment=view('ticket_comment',
            compact('message','id','created_at','username','profile_image'))->render();
            $totalcomments.= $ticketComment;
        }
        $ticket->comments=$totalcomments;
        return response()->json($ticket);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        if ($request->ajax()){
            return response()->json(['response'=>__('message.update',['name'=>'ticket'])]);
        }
    }

    public function destroy(Ticket $ticket)
    {
        DB::beginTransaction();
        try {
                $ticket->comments()->delete();
                $ticket->delete();
                DB::commit();
                if (request()->ajax()){
                    return response()->json(['response'=>__('message.delete',['name'=>'ticket'])]);
                }               ;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['response'=>__('message.error.delete',['reason'=>$e->getMessage()])]);
        }
    }
}
