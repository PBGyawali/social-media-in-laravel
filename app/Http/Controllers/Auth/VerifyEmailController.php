<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Models\WebsiteInfo;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
     public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->is_email_verified()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()){
            event(new Verified($request->user()));
        }
        $info=WebsiteInfo::first();
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');

    }
}
