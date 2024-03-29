<?php

namespace App\Http\Controllers;

use App\Models\Userlog;
use Illuminate\Http\Request;

class UserlogController extends Controller
{

 
    public function edit(Userlog $userlog)
    {
        return response()->json($userlog);
    }

    public function update(Request $request, Userlog $userlog)
    {
        $userlog->update($request->all());
        return response()->json(['response'=>__('message.update',['name'=>'user'])]);
       
    }


}
