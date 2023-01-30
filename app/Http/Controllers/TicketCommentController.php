<?php

namespace App\Http\Controllers;

use App\Models\TicketComment;
use Illuminate\Http\Request;

class TicketCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $comment=TicketComment::create($request->all());
        $message=
        '<div id="newticketcomment_'.$comment->id.'">
            <div>
                <i class="fas fa-comment fa-2x "></i>
                <button type="button"class="btn btn-danger delete btn-sm float-right p-0 px-1"
         data-id="'.$comment->id.'"><i class="fas fa-trash"></i></button>
            </div>
            <span class="ticketcomments">'.
                $comment->msg.'&nbsp;&nbsp;<i class="fas fa-check text-success resolved commenticon"></i>
            </span>
            <p>
                <span class="ticketcommentdate">'.
                    $comment->created_at.'
                </span>
            </p>
        </div>';
        return response()->json(array('response'=>$message));

    }


    public function show(TicketComment $ticketComment)
    {
        //
    }

    public function edit(TicketComment $ticketComment)
    {
        return response()->json($ticketComment);

    }


    public function update(Request $request, TicketComment $ticketComment)
    {
        $ticketComment->update($request->all());
    }


    public function destroy(TicketComment $ticketComment)
    {
        $ticketComment->delete();
    }
}
