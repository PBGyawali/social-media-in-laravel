<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
use App\Models\ActivityLog;
use App\Models\UserLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        return view('welcome');
    }

    public function store(LoginRequest $request)
    {

        // guest do not have accounts so simply login
        if(!$request->login_guest)
            $request->authenticate();
        else {
            session(['guest'=>'true']);
        }
        $request->session()->regenerate();
        // determine the page to redirect to if the user is logged in with accounts or not
        $login=auth()->user()?auth()->user()->userlog->login:'welcome';
        $usertype=auth()->user()?auth()->user()->user_type:'guest';
        switch ($login)
        {
              case 'home':
                $redirect=RouteServiceProvider::HOME;
              break;
              case 'dashboard':
                    switch ($usertype)
                    {
                          case 'user':
                            $redirect=RouteServiceProvider::DASHBOARD;
                            break;
                            case 'admin':
                            case 'editor':
                            case 'owner':
                            case 'master':
                                $redirect=RouteServiceProvider::ADMINDASHBOARD;
                            break;
                      }
                break;
                default:
                // redirect to welcome screen with no accounts login
              $redirect=RouteServiceProvider::WELCOME;
              break;
        }
      if ($request->ajax()) {
            return response()->json(array('redirect'=>$redirect));
        }
        return redirect($redirect);
    }

    public function destroy(Request $request)
    {
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'.'#login');
    }
}
