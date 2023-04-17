<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\OfflineMessage;
use App\Models\WebsiteInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\Select;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Userlog;
use App\Helper\Helper;

class WebsiteInfoController extends Controller
{
    public array $fields = [];
    public $websiteInfo = [];
    public $topics=[];
    public $alerts=[];
    public $messages=[];

    public function __construct()
    {
        if(!request()->ajax())
            $this->websiteInfo=WebsiteInfo::first();
    }
 

    public function index(Request $request)
    {
        // Set the page title
        $page = 'Welcome';

        // Get the website information from the model
        $info = $this->websiteInfo;

        // If there is no website information, redirect to the create page
        if(!$info)
            return $this->create($request);

        // Clear the setup and guest session variables
        session(['setup' => null, 'guest' => null]);
        
        // Render the view and pass the website information and page title as variables
        return view('index', ['info' => $this->websiteInfo, 'page' => $page]);
    }

    public function show()
    {
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        $page='about';
        $topics=Topic::all();
        $info=$this->websiteInfo;
        return view('about',compact('info','page','topics','messages',
        'messagecount','alertcount','alerts'));
    }
    public function create(Request $request)
    {
        $info=$this->websiteInfo;
        if($info)
         return $this->edit($request);
        session(['setup' =>true]);
        $page='settings';//check if this page name makes any difference in the page load
        $timezonelist=Select::instance()->Timezone_list();
        $currencylist=Select::instance()->Currency_list();
        return view('admin.settings',compact('timezonelist','currencylist','info','page'));
    }

    public function edit(Request $request)
    {
        $info=$this->websiteInfo;
        if(!$info)
            return redirect()->route('settings_create');
        session(['setup' =>null]);
        $page='settings';
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        $Timezone_list=Select::instance()->Timezone_list($info->website_timezone);
        $Country_list=Select::instance()->Country_list($info->owner_country);
        $logs=Userlog::find($id);
        $view='admin.settings';
        if($request->route()->named('user.settings')){
            $view=$page;
        }
        return view($view,compact(
        'info','Timezone_list','Country_list','page','messages',
        'messagecount','alertcount','alerts','logs'));
    }

    /*
    Store the website information and create a master user account if an email is provided.
    @param \Illuminate\Http\Request $request
    @return \Illuminate\Http\JsonResponse
    */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
        'website_timezone' => ['required','timezone'],
        'website_address' => ['required'],
        'website_email' => ['required','email'],
        'website_name'=>['required'],
        'website_contact_no' => ['required','numeric'],
        'user_target' => ['required','numeric'],
        'username' => ['sometimes','required', 'string', 'max:255'],
        'email' => ['sometimes','required', 'email', 'max:255', 'unique:users'],
        'password'=>['sometimes','required'],
        'website_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
        'owner_photo'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
        ]);

        // Create the WebsiteInfo model instance with the request data and save it to the database
        WebsiteInfo::create($request->all());

        // Set the user_type to 'master' and create a new User model instance 
        // if an email is provided in the request data
        if ($request->has('email')) {
            $fields['user_type']='master';
            User::create(array_merge(array_filter($request->all()), $fields));
        }

        // Clear the 'setup' session variable and 
        // set the 'website_name' session variable to the website name
        session(['setup' =>null]);
        session(['website_name' => $request->website_name]);

        // Log out the current user and return a JSON response with a success message and a redirect URL
        Auth::logout();
        return response()->json(array('redirect'=>route("heading").'#login','response'=>'<div class="alert alert-success">Details Created Successfully. Please login </div>'));
    }

  

    public function update(Request $request, WebsiteInfo $website_info)
    {
        // Validate the incoming request
        $this->validate($request, [
            'website_timezone' => ['sometimes','required','timezone'],
            'website_name'=>['sometimes','required'],
            'website_email' => ['sometimes','required','email'],
            'website_address' => ['sometimes','required'],
            'user_target' => ['sometimes','required','numeric'],
            'owner_name' => ['sometimes','required'],
            'owner_contact_no' => ['sometimes','required','numeric'],
            'owner_address' => ['sometimes','required'],
            'owner_country' => ['sometimes','required'],
            'owner_email' => ['sometimes','required','email'],
            'owner_postal_code' => ['sometimes','required',],
            'website_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
            'owner_photo'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
        ]);

        // Check if owner photo was uploaded and store it
        if($request->hasFile('owner_photo')){
            $storepath=$request->file('owner_photo')->store('public/images/user_images/');
            $this->fields['owner_image']=basename($storepath);
        }

        // Check if website image was uploaded and store it
        if($request->hasFile('website_image')){
            $image=$request->file('website_image');
            $imagename=$image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
            $request->file('website_image')->move(config('app.logo_path'),$imagename);
            $this->fields['website_logo']=basename($imagename);
        }

        // Update the WebsiteInfo object by removing any empty fields from the request and uploaded images
        $website_info->update(array_merge(array_filter($request->all()), $this->fields));

        // Update the session with the website name
        session(['website_name' => ucwords($request->website_name)]);

        // Return a JSON response indicating success
        return response()->json(array('response'=>'<div class="alert alert-success">Details Updated Successfully</div>'));
    }



}
