<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userlog;
use App\Models\Alertlog;
use App\Helper\Helper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function show(Request $request)
    {
        $num_rows =User::where($request->column,$request->data)->count();
        $message= 'available';
        if($num_rows > 0)
            $message= 'exists';
        return response()->json($message);
    }

    public function store(Request $request)
    {

        $request->validate([
            'registered_username' => ['required','max:255','unique:users,username','different:registered_email'],
            'registered_email' => ['required','email','max:255','unique:users,email','confirmed','different:password'],
            'password' => ['required','different:registered_username','confirmed', Rules\Password::defaults()],
        ]);

        $email=$request->registered_email;
        $username=$request->registered_username;
        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => $request->password,
        ]);

        //event(new Registered($user));
        Helper::activitylogs($user->id, 'You registered your ','register','profile');
        Userlog::create(['user_id'=>$user->id]);
        AlertLog::create(['user_id'=>$user->id]);
        $website_name=$request->website_name;
        $website_logo=$request->website_logo;

        return view('confirmation.registration confirmation',compact('email','username','website_name','website_logo'));


    }
}
