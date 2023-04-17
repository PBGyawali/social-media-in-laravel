<?php

namespace App\Http\Controllers;
use App\Models\Alert;
use App\Models\OfflineMessage;
use App\Models\WebsiteInfo;
use App\Models\User;
use App\Models\Userlog;
use App\Models\Alertlog;
use App\Models\follower;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public array $fields = [];
    public $websiteInfo = [];
    public string $query = '';
    public string $imageName = '';
    public string $button = '';


    // automatically called function when controller instance is created
    public function __construct()
    {
        if(!request()->ajax())
        $this->websiteInfo=WebsiteInfo::first();
    }

    public function index(Request $request)
    {
        //fetch all users from DB
      if ($request->ajax()) {
            $query = User::leftjoin('userlogs','users.id','userlogs.user_id');
            if($request->from_date!=''&& $request->to_date!='')
                $query->whereBetween('users.created_at',[$request->from_date, $request->to_date]);
            $data=$query->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                        // primary key of the row
                        $id=$data->id;
                        // status of the row
                        $status=$data->user_status;
                        // data to display on modal, tables
                        $prefix="user";
                        // url for reset, alerts and activity logs button
                        $reseturl=route('admin.password.email');
                        $activitylogurl=route('activitylog',$id);
                        $alertsurl=route('alerts',$id);
                        // optional button to display
                        $buttons=['delete','view','verify','edit','status'];
                        $actionBtn = view('control-buttons',compact('buttons','id','status','prefix','reseturl','activitylogurl','alertsurl'))->render();
                        return $actionBtn;
                })
                ->addColumn('fullname', function ($data) {
                    return $data->fullname;
                 })
                ->editColumn('profile_image', '<img src="{{$profile_image}}" class="img img-thumbnail " width="75" >')
                ->setRowClass(function ($data) {
                    return $data->is_active()? 'bg-white' : 'bg-danger text-white';
                })
                ->make(true);
        }
        $info=$this->websiteInfo;
        $page='user';
        $id=auth()->id();
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        return view('admin.userlist',compact('info','page','messages','messagecount','alertcount','alerts' ) );
    }


    public function create(Request $request,User $users)
    {
        $check=$user=auth()->user();
        $info=$this->websiteInfo;
        $id=$check->id;
        $points=$userfollowed=$userdata=$timestamp='';
        $messages=Helper::messages($id);
        $messagecount=OfflineMessage::user_id($id)->read()->count();
        $alertcount=Alert::user_id($id)->read()->count();
        $alerts=Helper::alerts($id);
        $page='profile';
        $view='admin.profile';
        if($request->route()->named('user.profile')){
            $view=$page;
        }
        if($request->route()->named('user.profileview')){
            $view='viewprofile';
            $points=Helper::progress_points($users->id);
            $userfollowed=Follower::receiver($users->id)->sender($id)->count();
            $userdata=User::all();
        }
        if($request->route()->named('user.password')||$request->route()->named('password')){
            $page=$view='password';
            $timestamp = $user->userlog->last_password_change;
        }
        if($request->route()->named('password')){
            $view='admin.change_password';
        }
        return view($view,compact('userfollowed','points','info','user','page',
        'messages','messagecount','alertcount','alerts','info','users','userdata','timestamp','check'));
    }

    public function show(User $user)
    {

        $viewdatas=[
        'image'=>$user->profile_image,
        'username'=>$user->username,
        'email'=>$user->email,
        'Full name'=>$user->full_name,
        'facebook'=>$user->facebook,
        'twitter'=>$user->twitter,
        'Google Plus'=>$user->googleplus,
        'Email status'=>[
            'class'=>$user->is_email_verified()?'success':'danger',
            'value'=>$user->is_email_verified()?'Verified':'Not yet verified',             
            ],
        'Profile Verification status'=>[
            'class'=>$user->is_verified()?'success':'danger',
            'value'=>$user->is_verified()?'Verified':'Not yet verified',          
            ],
        'Status'=>[            
            'class'=>$user->is_active()?'success':'danger',
            'value'=>$user->is_active()?'Active':'Disabled',
            ],
        'Remarks'=>$user->userlog->remarks,
        ];

        $output =view('view-modal',compact('viewdatas'))->render();    
             return response()->json($output);

    }

    public function store(Request $request)
    {

       $this->validate($request, [
            'username' => ['required','max:255','unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password'=>['required','min:6','max:72'],
            'profile_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
        ]);
        if($request->hasFile('profile_image')){
            $this->fields['profile_image']=basename($request->file('profile_image')->store('public/images/user_images/'));
            $this->imageName=config('app.user_images_url').$this->fields['profile_image'];
        }
        $user=User::create(array_merge($request->all(), $this->fields));
        Userlog::create(['user_id'=>$user->id]);
        AlertLog::create(['user_id'=>$user->id]);
       return response()->json(array('response'=>'<div class="alert alert-success">The user data was created!</div>','image'=>$this->imageName));
    }



// function to download database data as csv file
    public function downloadCSV(Request $request,)
    {
        $this->validate($request, [
             'from_date' => ['required','date'],
             'to_date' => ['required','date','after_or_equal:from_date'],
         ]);
               // Define the MySQL table name
                $table = Str::plural('user');
                // Set the file path and name
                $filename=date("Y_m_d").'_'.time().'_data.csv';
                // Get the column names from the MySQL table
                $columns = DB::getSchemaBuilder()->getColumnListing($table);

                // Fetch the data from the MySQL table and cast it to array
                $query = DB::table($table);
                if($request->from_date!=''&& $request->to_date!='')
                $query->whereBetween('users.created_at',[$request->from_date, $request->to_date]);
                $data=$query->get()->toArray();

                // Open the CSV file for writing
                $handle = fopen($filename, 'w+');

                // Write the column names to the CSV file
                fputcsv($handle, $columns);

                // Write the data to the CSV file
                foreach ($data as $row) {
                    fputcsv($handle, (array) $row,$delimiter);
                }
                    // Close the file
                    fclose($handle);

                // get the CSV file contents
                $content = file_get_contents($filename);
                // Set the CSV file content as the response body
                $response = response($content);

            // Set the response headers for downloading the file
            $headers = array('Content-Type' => 'text/csv',
                // declaring as an attachment proceeds to download of file directly
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            );

            // Add the headers to the response
            $response->headers->replace($headers);

            // Return the response
            return $response;
    }

    public function update(Request $request, User $user)
{
    // Validate the input data
    if(!$request->hasAny('user_status','delete_picture','upload_picture','verified')){
        $this->validate($request, [
            'username' => ['sometimes','required', 'string', 'max:255',Rule::unique('users')->ignore($user)],
            'email' => ['sometimes','required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'current_password' => ['sometimes','exclude_if:password,null','required_with:password','current_password:web'],
            'password' => ['nullable','min:6','different:current_password'],
            'password_confirmation' => ['sometimes','exclude_if:password,null','required_with:password','same:password'],
            'profile_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
        ]);
    }

    // Get the user ID of the authenticated user
    $id=auth()->id();

    // Check if the user is authorized to perform the update
    if(!$request->user()->is_editor() && !$user->is_same_user($id)){
        // If not authorized, return without updating
        return;
    }

    // Store the uploaded profile image file and update the image name and button HTML
    if($request->hasFile('profile_image')){
        $storepath=$request->file('profile_image')->store('public/images/user_images/');
        $this->fields['profile_image']=basename($storepath);
        $this->imageName=config('app.storage_url').$storepath;
        $this->button='<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> <span class="d-none d-md-inline-block">Delete</span></button>';
    }

    // Update the user's information and set the last password change date if a new password is provided
    if($request->filled('password')){
        $this->fields['last_password_change']=Helper::get_datetime();
    }
    $user->update(array_merge(array_filter($request->all()), $this->fields));

    // Log the password update if the current user is updating their own password
    if($request->filled('password') && $user->is_same_user($id)){
        Helper:: activitylog($id,'update','password',$id);
    }

    // Delete the profile image if requested and update the image name
    if($request->has('delete_picture')){
        $imagename=basename($request->old_image);
        if($imagename!='user_profile.png')
            File::delete(config('app.user_images_path').$imagename);
        $this->imageName=$user->profile_image;
    }

    // Update the user log with the new information
    $user->userlog->update(array_merge(array_filter($request->all()), $this->fields));

    // Return a JSON response with a success message, the updated image name, and the updated button HTML
    return response()->json(array('response'=>'<div class="alert alert-success">The user data was updated!</div>',
        'image'=>$this->imageName,'button'=>$this->button));
    }


    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        // transaction is needed to rollback any changes if one of the code fails
        DB::beginTransaction();
        try {
            // delete every details of the user before user is deleted to avoid foreign id costraint
            $user->activitylogs->each->delete();
            $user->alerts->each->delete();
            $user->alertlogs->each->delete();
            if($user->ratings)
                $user->ratings->each->delete();
            $user->followers->each->delete();
            $user->messages->each->delete();
            if($user->messagelog)
                $user->messagelog->delete();
            $user->comments->each->delete();
            $user->replies->each->delete();
            $user->posts->each->delete();
            $user->userlog->delete();
            $user->delete();
            DB::commit();
            return response()->json(array('response'=>'<div class="alert alert-success">The user was deleted!</div>'));
        } catch (\Exception $e) {
            DB::rollBack();
              //Handle the exception
            return response()->json(array(
                'error'=>'<div class="alert alert-danger">An error occurred while deleting the data.'.
                                $e->getMessage()
                        .'</div>'));
        }

    }
}
