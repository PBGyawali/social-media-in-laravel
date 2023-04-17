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
                    // optional button to display
                    $buttons=['update',auth()->user()->is_admin()?'delete':'',];
                    $actionBtn = view('control-buttons',compact('buttons','id','status','prefix'))->render();
                     return $actionBtn;
                })
             ->editColumn('status', function ($data) {
               $statustypes=array("open","pending","on-hold","resolved","closed");
                $icontype=array("envelope","clock","pause-circle","check","times");
                $class= array('primary ','danger ','warning ','success ','secondary ');
                foreach($statustypes as $key=> $statustype)
                    if($data->status== $statustype)
                            break;
                $status='<i class="fa-2x fas fa-'.$icontype[$key].' '.$statustype.'
                text-'.$class[$key].'" title="'.$statustype.'">
                <span style="display:none;">'.$key.'</span></i>';
                        return $status;
                    })
                ->make(true);
        }
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
       $alerts=Helper::alerts($id);
      $page='tickets';
      return view ('admin.tickets',compact('page','messages','messagecount','alertcount','alerts'));
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
                                    ];
                }
                // batch insertion into comments table
                TicketComment::insert($TicketComments);
            }
            DB::commit();
            return response()->json([
                'response'=>'<div class="alert alert-success">The ticket was stored!</div>',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'response'=>'<div class="alert alert-danger">An error occurred while storing the data'.
                    $e->getMessage()
                .'</div>',
            ]);
        }
    }

     public function edit(Ticket $ticket)
    {
        $data['detail']=$ticket;
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
        $data['comments']=$totalcomments;
        $data['status']=$ticket->status_class;
        return response()->json($data);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        return response()->json(array('response'=>'<div class="alert alert-success">The data was updated!</div>'));
    }

    public function destroy(Ticket $ticket)
    {
        DB::beginTransaction();
        try {
                $ticket->comments->each->delete();
                $ticket->delete();
                DB::commit();
                return response()->json([
                    'response'=>'<div class="alert alert-success">The data was deleted!</div>',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'response'=>'<div class="alert alert-danger">An error occurred while deleting the data'.
                    $e->getMessage()
                .'</div>',
            ]);
        }
    }
}
