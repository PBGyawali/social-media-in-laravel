<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\Http;

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

    // when password reset request is performed by admin on behalf of user
    public function update(Request $request)
    {
        $email=User::find($request->id)->email;
        $status = Password::sendResetLink(['email'=>$email]);
        $messagestatus=($status == Password::RESET_LINK_SENT? 'success': 'danger');
        return response()->json(array('response'=>'<div class="alert alert-'.$messagestatus.'">'.__($status).'</div>'));
    }



    // when password reset request is performed by user himself
    public function store(Request $request)
    {
        $email=$request->validate(['email' => 'required|email']);

        // this is a test key. replace with original in production
        $recaptcha_secret_key = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
        $recaptcha_response_token = $request->input('g-recaptcha-response');

        if (!$recaptcha_response_token)
            return back()->withInput($request->only('email'))
            ->withErrors(['reset_email' => 'Recaptcha verification not found']);

        $recaptcha_verify_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptcha_secret_key,
            'response' => $recaptcha_response_token,
        ]);
        $recaptcha_response_data = json_decode($recaptcha_verify_response->body());

        if ($recaptcha_response_data->success) {
            // reCAPTCHA verification passed
        } else {
            // reCAPTCHA verification failed
            return back()->withInput($request->only('email'))
                    ->withErrors(['reset_email' => 'Recaptcha verification failed']);
        }


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
                    ->withErrors(['reset_email' => __($status)]);
        }

    }
}
