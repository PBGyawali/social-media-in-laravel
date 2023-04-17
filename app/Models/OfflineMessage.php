<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
class OfflineMessage extends Model
{
    use HasFactory;
    use PowerJoins;


    protected $fillable = ['user_id','sender_id','message','read_by_user','notfication'];
    
    protected $hidden = ['password','remember_token'];

    protected $perPage = 10;

    CONST CREATED_AT='sent_on';

    CONST UPDATED_AT=null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }


    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeSender_id($query, $id)
    {
        return $query->where('sender_id', $id);
    }

    public function scopeRead($query)
    {
        return $query->where('read_by_user','no');
    }
    public function getUsernameAttribute($name){
        return ucwords($name);
    }
    public function getFirstNameAttribute($name){
        return ucwords($name);
    }
    public function getLastNameAttribute($name){
        return ucwords($name);
    }
    public function getFullNameAttribute()
    {
       return ucwords($this->first_name) . ' ' . ucwords($this->last_name);
    }

    public function getSentOnAttribute($name)
    {
        return Carbon::parse($name)->diffForHumans();
       //return Carbon::createFromTimestamp(strtotime($name))->diffForHumans();
    }
    public function getProfileImageAttribute($name){
        if(is_dir(config('app.user_images_path').$name)
        ||  !File::exists(config('app.user_images_path').$name))
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$name;
    }
}
