<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use PowerJoins;

    protected $fillable = ['username','email','password','sex',
    'profile_image','user_type','facebook','first_name','last_name','twitter','googleplus'];

    protected $hidden = ['password','remember_token'];

    public $timestamps=false;

    //always cast created as datetime object
    protected $casts = ['created_at' => 'datetime'];

    protected $dates = ['created_at'];

    public function setPasswordAttribute($password)
    {
        // Check if the given password is already hashed
        if (Hash::needsRehash($password)) {
                // If it is not hashed, hash it before setting the attribute
                $this->attributes['password'] = Hash::make($password);
        } else {
            // If it is already hashed, don't hash it again
            $this->attributes['password'] = $password;
        }
    }

 
    public function getFacebookAttribute($value){
        return htmlspecialchars($value);
    }
    public function getTwitterAttribute($value){
        return htmlspecialchars($value);
    }
    public function getGoogleplusAttribute($value){
        return htmlspecialchars($value);
    }


    public function username(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }


    public function getFirstNameAttribute($value){
        return ucwords($value);
    }
    public function getLastNameAttribute($value){
        return ucwords($value);
    }
    public function getFullNameAttribute()
    {
       return ucwords($this->first_name) . ' ' . ucwords($this->last_name);
    }
    public function getLastLogoutAttribute($value){
        return date("d-m-Y H:i",strtotime($value));
    }

    public function getLastPasswordChangeAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
    public function getLastActiveAttribute(){
        return date("d-m-Y H:i",strtotime($this->last_logout>$this->last_login_attempt?$this->last_logout:$this->last_login_attempt));
    }

    public function getCreatedAtAttribute($value){
        return date("d-m-Y ",strtotime($value));
    }

    public function getProfileImageAttribute($value){
        if(is_dir(config('app.user_images_path').$value)
        ||  !file_exists(config('app.user_images_path').$value))
        //retun the base directory for user images plus image name
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$value;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function alertlogs()
    {
        return $this->hasMany(AlertLog::class);
    }
    public function activitylogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class,'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(OfflineMessage::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function userlog()
    {
        return $this->hasOne(Userlog::class);
    }

    function is_active(){
        return $this->userlog->user_status=='Enable' ? true : ($this->userlog->user_status=='active'?true:false);
    }
    function is_verified(){
        return $this->userlog->verified=='yes' ? true : ($this->userlog->verified=='active'?true:false);
    }
    function is_email_verified(){
        return $this->userlog->email_status=='active' ? true : false;
    }

    function is_user(){
        return $this->user_type=='user' ? true : false;
    }
    function is_editor()	{
        return $this->user_type=='editor'?true:($this->user_type=='admin'?true:($this->user_type=='owner'?true:false) ) ;
	}
	 function is_admin()	{
        return $this->user_type=='admin'?true:($this->user_type=='owner'?true:false) ;
    }

    function is_owner()	{
        return $this->user_type=='owner'?true:false;
    }
    function is_same_user($data)	{
        return $data==$this->id ? true : false;
    }

    function has_no_image()	{
        return basename($this->profile_image)=='user_profile.png'? true :false;
    }

    public function isAdmin()
    {
        return $this->is_admin();
    }

    function is_master_admin()	{
        return $this->is_admin();
    }



}
