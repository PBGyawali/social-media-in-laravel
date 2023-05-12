<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\UserTrait;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    

    use UserTrait;

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

    public function getLastLogoutAttribute($value){
        return date("d-m-Y H:i",strtotime($value));
    }

    public function getLastPasswordChangeAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
    public function getLastActiveAttribute(){
        return date("d-m-Y H:i", strtotime(max($this->last_logout, $this->last_login_attempt)));
    }

    public function getCreatedAtAttribute($value){
        return date("d-m-Y ",strtotime($value));
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
        return in_array(strtolower($this->userlog->user_status), ['enable','active']);
    }
    function is_verified(){
        return in_array(strtolower($this->userlog->verified), ['yes','active']);
    }
    function is_email_verified(){
        return strtolower($this->email_status)=='active';
    }

    function is_user(){
        return strtolower($this->user_type)=='user';
    }
    function is_editor()	{
        return in_array(strtolower($this->user_type), ['editor','owner', 'admin', 'master']);
	}

    function is_admin()	{
        return in_array(strtolower($this->user_type), ['owner', 'admin', 'master']);
	}

    function is_owner()	{
        return $this->user_type=='owner';
    }

    function is_master()	{
        return in_array(strtolower($this->user_type), ['master']);
	}

    public function isAdmin()
    {
        return $this->is_admin();
    }

    function is_master_admin()	{
        return $this->is_master();
    }

    function is_same_user($data){
        if ($data instanceof Model) {
            return $this->is($data);
        }
        return $data==$this->id;
    }

    function has_no_image()	{
        return basename($this->profile_image)=='user_profile.png';
    }





}
