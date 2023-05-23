<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\WebsiteInfo;

class ConfirmablePasswordController extends Controller
{
    public function show()
    {
        $info=WebsiteInfo::first();
        if(!$info)
            return redirect()->route('settings_create');
        return view('auth.confirm-password',compact('info'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'secret_password' => ['sometimes','required'],
            'password' => ['required','current_password:web'],
        ]);
        $path=session()->get('url.intended', RouteServiceProvider::ADMINDASHBOARD);
        if($path==route('settings')){
            $secret_password =WebsiteInfo::first()->secret_password;
            if (!Hash::check($request->secret_password, $secret_password)) {
                throw ValidationException::withMessages([
                    'secret_password' =>__('auth.secret_password'),
                ]);
            }
        }
       $request->session()->put('auth.password_confirmed_at', time());
        return redirect()->intended($path);
    }
}
