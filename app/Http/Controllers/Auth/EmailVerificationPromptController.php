<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\WebsiteInfo;

class EmailVerificationPromptController extends Controller
{

    public function __invoke(Request $request)
    {
        if($request->user()->is_email_verified())
        return  redirect()->intended(RouteServiceProvider::HOME);
        else {
            $info=WebsiteInfo::first();
            return view('auth.verify-email',compact('info'));
        }

    }
}
