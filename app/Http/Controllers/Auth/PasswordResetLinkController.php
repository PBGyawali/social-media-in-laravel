<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\WebsiteInfo;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function update(Request $request)
    {
        $email=User::find($request->id)->email;
        $status = Password::sendResetLink(['email'=>$email]);
        $messagestatus=($status == Password::RESET_LINK_SENT? 'success': 'danger');
        return response()->json(array('response'=>'<div class="alert alert-'.$messagestatus.'">'.__($status).'</div>'));
    }
    public function store(Request $request)
    {
        $email=$request->validate(['email' => 'required|email']);
        // We will send the password reset link to this user and
        //  examine the response then  send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if($status == Password::RESET_LINK_SENT){
            $email=$request->email;
            $info=WebsiteInfo::first();
            return  view('confirmation.pending',compact('email','info'))    ;
        }
       else {
            return back()->withInput($request->only('email'))
                    ->withErrors(['email' => __($status)]);
        }

    }
}
