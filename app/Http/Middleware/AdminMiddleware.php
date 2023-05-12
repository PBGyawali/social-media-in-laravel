<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Guard;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use App\Models\OfflineMessage;
use App\Models\Alert;
use Illuminate\Support\Facades\Route;

class AdminMiddleware
{


     /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    public function handle($request, Closure $next, ...$guards)
    {
           if (!auth()->user()->is_editor()) {
                if ($request->ajax()) {
                    return response()->json(array('error'=>
                    'You must be an admin to perform this action'));
                }
                return back()->with('error','You must be an admin to view this page!');
            }

            if (!request()->ajax()){
                $page=explode('.',Route::currentRouteName())[0];
                $support_active=$dashboard_active=$user_active=$tickets_active=$posts_active =$topics_active=
                $manage_article='inactive_class';
                ${$page."_active"} = 'active_class';
                if($page== 'posts'|| $page =='topics')$manage_article='active_class' ;
                $side='';
                // sharing values to all pages in group
                view()->share(compact('page',
                'dashboard_active','user_active','tickets_active','posts_active','topics_active',
                'manage_article','side','support_active'
            ));
            }

        return $next($request);
    }
}
