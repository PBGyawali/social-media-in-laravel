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
class UserController extends Controller
{
    var $fields=array();
    public $websiteInfo=array();
    public $query='';
    public $imageName='';
    public $button='';

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
                $query->whereBetween('created_at',[$request->from_date, $request->to_date]);
            $data=$query->get();
            return DataTables::of($data)
                ->addColumn('action', function($data){
                $actionBtn = '
                <div align="center">
                <button type="button" class="btn btn-info btn-sm view" title="View user data"data-id="'.$data->id.'"><i class="fas fa-eye"></i></button>
                <button type="button"  class="btn btn-danger btn-sm delete"title="Delete user data" data-id="'.$data->id.'"><i class="fas fa-times"></i></button>
                <button type="button"  data-prefix="User" class="btn btn-secondary btn-sm update"title="Edit user data" data-id="'.$data->id.'"><i class="fas fa-edit"></i></button>
                <button type="button"  class="btn btn-primary btn-sm reset" title="Reset user password"data-url="'.route('admin.password.email').'" data-id="'.$data->id.'"><i class="fas fa-sync"></i></button>
                <button type="button"  class="btn btn-success btn-sm verify" data-id="'.$data->id.'" title="Verify user"><i class="fas fa-check"></i></button>
                <a  href="'.route('alerts',$data->id).'" class="btn btn-success btn-sm" title="Show all user alerts" target="_blank"><i class="fas fa-bell"></i></a>
                <a  href="'.route('activitylog',$data->id).'" class="btn btn-success btn-sm" title="Show all user activity" target="_blank"><i class="fas fa-list"></i></a>
                <button type="button" data-prefix="user" class="btn '. ($data->is_active()?'btn-warning ':'btn-success') .' btn-sm  status " data-status="'.($data->is_active()?'inactive':'active').'" data-id="'.$data->id.'"><i class="fas '.(($data->is_active())?' fas fa-ban ':' fas fa-unlock-alt').'"></i></button>
                </div>';
                    return $actionBtn;
                })
                ->addColumn('fullname', function ($data) {
                    return $data->fullname;
                 })
                ->editColumn('profile_image', '<img src="{{$profile_image}}" class="img img-thumbnail " width="75" >')
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
        $output = '<div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td>Image</td>
                <td><img id="profile_image" src="'.$user->profile_image.'" class="rounded-circle mb-0 mt-0 img-fluid" width="200" alt="thumbnail"></td>
            </tr>
            <tr> <td>Username</td>
                <td>'.$user->username.'</td>
            </tr> <tr>
                <td>Email</td>
                <td>'.$user->email.'</td>
            </tr> <tr>
                <td>Full name</td>
                <td>'.$user->full_name.'</td>
            </tr> <tr>
                <td>Facebook</td>
                <td>'.$user->facebook.'</td>
            </tr> <tr>
                <td>Twitter</td>
                <td>'.$user->twitter.'</td>
            </tr> <tr>
                <td>Google Plus</td>
                <td>'.$user->googleplus.'</td>
            </tr>
            <tr>
                <td>Email status</td>
                <td><span class="badge badge-'.($user->is_email_verified()?'success">Verified':'danger">Not yet verified').'</span></td>
            </tr>
            <tr>
                <td>Profile Verification status</td>
                <td><span class="badge badge-'.($user->is_verified()?'success">Verified':'danger">Not yet verified').'</span></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="badge badge-'.($user->is_active()?'success">Active':'danger">Disabled').'</span></td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td><textarea name="remarks" id="remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup">'.$user->userlog->remarks.'</textarea></td>
            </tr> </table></div>';
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

    public function update(Request $request, User $user)
    {
        if(!$request->hasAny('user_status','delete_picture','upload_picture','verified')){
            $this->validate($request, [
                'username' => ['sometimes','required', 'string', 'max:255',Rule::unique('users')->ignore($user)],
                'email' => ['sometimes','required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
                'current_password' => ['sometimes','exclude_if:password,null','required_with:password','password:web'],
                'password' => ['nullable','min:6','different:current_password'],
                'password_confirmation' => ['sometimes','exclude_if:password,null','required_with:password','same:password'],
                'profile_image'=>['nullable','image','mimes:jpg,jpeg,png,bmp,tiff' ,'max:4096'],
                 ]);
        }
        $id=auth()->id();
        if(!$request->user()->is_editor() && !$user->is_same_user($id)){
          return;
        }
        if($request->hasFile('profile_image')){
            $storepath=$request->file('profile_image')->store('public/images/user_images/');
            $this->fields['profile_image']=basename($storepath);
            $this->imageName=config('app.storage_url').$storepath;
            $this->button='<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> <span class="d-none d-md-inline-block">Delete</span></button>';
        }
        if($request->filled('password')){
            $this->fields['last_password_change']=Helper::get_datetime();
        }
        $user->update(array_merge(array_filter($request->all()), $this->fields));

        if($request->filled('password') && $user->is_same_user($id)){
            Helper:: activitylogs($id,'You updated your ','update','password',$id);
        }
        if($request->has('delete_picture')){
            $imagename=basename($request->old_image);
            if($imagename!='user_profile.png')
                File::delete(config('app.user_images_path').$imagename);
            $this->imageName=$user->profile_image;
        }
        $user->userlog->update(array_merge(array_filter($request->all()), $this->fields));
        return response()->json(array('response'=>'<div class="alert alert-success">The user data was updated!</div>',
        'image'=>$this->imageName,'button'=>$this->button));
    }


    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->activitylogs->each->delete();
        $user->alerts->each->delete();
       $user->alertlogs->each->delete();
        $user->ratings->each->delete();
       $user->followers->each->delete();
        $user->messages->each->delete();
        if($user->messagelog)
        $user->messagelog->delete();
        $user->posts->comments->each->delete();
        $user->posts->replies->each->delete();
        $user->posts->each->delete();
        $user->userlog->delete();
        $user->delete();
        return response()->json(array('response'=>'<div class="alert alert-success">The user was deleted!</div>'));
    }
}
