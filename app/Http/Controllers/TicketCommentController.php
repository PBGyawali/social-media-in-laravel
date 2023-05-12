<?php

namespace App\Http\Controllers;

use App\Models\TicketComment;
use Illuminate\Http\Request;

class TicketCommentController extends Controller
{


    /*     Store and show the stored ticket comment     */

    public function store(Request $request)
    {
        $comment=TicketComment::create($request->all());
        $message=$comment->msg;
        $created_at=$comment->created_at;
        $id=$comment->id;
        $username=$comment->user ? $comment->user->username : '';
        $profile_image=$comment->user ? $comment->user->profile_image: '';
        $status=true;
        $ticketComment=view('ticket_comment',
        compact('message','id','created_at','status','username','profile_image'))
        ->render();
        return response()->json(['response'=>$ticketComment]);
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
        return response()->json(['delete'=>$ticketComment->getKey()]);
    }
}
