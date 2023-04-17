<?php

namespace App\Http\Controllers\Auth;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Models\Alert;
use App\Models\WebsiteInfo;

class NewPasswordController extends Controller
{

    public $user_id;

    /**
     * show new password change page.
     */
    public function create(Request $request)
    {
        $info=WebsiteInfo::first();
        return view('new_password', compact('request','info'));
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $this->user_id=$user->id;
                $user->forceFill([
                    'password' => $request->password,
                    'remember_token' => Str::random(60),
                ])->save();

             event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if($status == Password::PASSWORD_RESET){
            Helper::activitylogs($this->user_id, 'You performed reset of your ','reset','password');
            
           Alert::create([
            'user_id' => $this->user_id,
            'alert' => trans('alert.password_reset'),
            'type' => 'info',
        ]);

                return  redirect()->route('login')->with('success', __($status)) ;
        }
        else
        return  back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)])->with('error', __($status));

    }
}
