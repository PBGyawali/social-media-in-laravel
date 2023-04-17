<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {


        return back()->withErrors(['provider' => ucfirst($provider).' login is not available at the moment']);
        $socialite_user = Socialite::driver($provider)->user();

        // Check if the user already exists in your database
        $user = User::where('email', $socialite_user->email)->first();


        // If the user does not exist in,create a new record to represent the user
        if (!$user) {
            // Create a new user account
            $user = new User();
            $user->username = $socialite_user->getNickname();
            $user->firstname = $socialite_user->getName();
            // $user->profile_image=$socialite_user->getAvatar();
            $user->email = $socialite_user->getEmail();
            $user->password = bcrypt(str_random(16));
            $user->save();
        }

        // Log the user in
        auth()->login($user);

        // Redirect the user to the dashboard
        return redirect('/dashboard');
    }
}
