<?php

namespace App\Http\Controllers;
use App\Models\Alert;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\OfflineMessage;
use App\Models\TicketComment;
use App\Helper\Helper;

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
                $actionBtn = '
                <button type="button"class="btn btn-primary mb-1 btn-sm update" data-prefix="Ticket" data-id="'.$data->id.'">
                 <i class="fas fa-eye"></i></button>';
                 if(auth()->user()->is_admin()){
                    $actionBtn .= '
                    <button type="button"class="btn btn-danger btn-sm delete" data-id="'.$data->id.'">
                     <i class="fas fa-trash"></i></button>';

                 }
                
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


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $ticket=Ticket::create($request->all());
        if($request->has('ticket_comments'))
        {
            foreach (array_filter($request->ticket_comments) as $msg)
              {
                $data['ticket_id']=$ticket->id;
                $data['msg']=$msg;
                TicketComment::create($data);
            }
        }
        return response()->json(array('response'=>'<div class="alert alert-success">The data was stored!</div>'));
    }

    public function show(Ticket $ticket)
    {
        //
    }

    public function edit(Ticket $ticket)
    {
        $data['detail']=$ticket;
        $comments=$ticket->comments;      
        $totalcomment='';
        foreach($comments as $key=> $comment)
        $totalcomment.= '<div><i class="fas fa-comment fa-2x"></i><button type="button"class="btn btn-danger delete btn-sm float-right p-0 px-1"
         data-id="'.$comment->id.'"><i class="fas fa-trash"></i></button></div>'.
                '<span class="ticketcomments">'.$comment->msg.'</span>'.
                '<p><span class="ticketcommentdate">'.$comment->created_at.'</span></p>';
        $data['comments']=$totalcomment;
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
        $ticket->comments->each->delete();
        $ticket->delete();
        return response()->json(array('response'=>'<div class="alert alert-success">The data was deleted!</div>'));
    }
}
