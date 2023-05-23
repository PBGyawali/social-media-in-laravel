<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Guard;
use App\Models\WebsiteInfo;
use App\Helper\Helper;
use App\Models\OfflineMessage;
use App\Models\Alert;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }


    public function handle($request, Closure $next, ...$guards)
    {

            if (!request()->ajax()){
                $page=explode('.',Route::currentRouteName())[0];
                $user_id=$id=auth()->id()??0;
                $messages=Helper::messages($user_id);
                $messagecount=OfflineMessage::user_id($user_id)->read()->count();
                $alerts=Helper::alerts($user_id);
                $alertcount=Alert::user_id($user_id)->read()->count();
                $info=WebsiteInfo::first();
                $alertcount=$alertcount??0;
                $messagecount=$messagecount??0;
                $check=auth()->user()??'';
                $username=$check->username??'newuser';
                $profileimage=$check->profile_image??'no_image';
                $request->merge(compact('info','messagecount','alertcount','alerts','messages'));
                $welcome_active=$dashboard_active=$about_active=$manage_article=$home_active=$topics_active='inactive_page';
                ${$page."_active"} = 'active_page';
                if($page == 'posts'|| $page =='post')$manage_article='active_page';
                if($page == 'filtered posts')$topics_active='active_page';
                $side='user.';
                if(!session()->has('website_name')||session()->missing('website_name')||!session()->has('website_logo')||session()->missing('website_logo')){
                    session(['website_name'=>$info->website_name]);
                    session(['website_logo'=>$info->website_logo]);
                    session(['website_icon'=>$info->website_logo]);
                }
                $website_name=session()->has('website_name')?session('website_name'):'';
                $website_logo=session()->has('website_logo')?session('website_logo'):'';
                // sharing values to all pages in group
                view()->share(compact('info','messages','alerts','alertcount','messagecount','page',
                'user_id','side','username','profileimage','username','check','welcome_active','dashboard_active','about_active','manage_article',
                'home_active','topics_active','website_name','website_logo'
            ));
            }

            return parent::handle($request, $next);
    }






}
