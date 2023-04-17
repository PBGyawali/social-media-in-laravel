<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Support\Facades\File;
class Comment extends Model
{
    use HasFactory;
    use PowerJoins;


    protected $fillable = ['user_id','post_id','body','status'];

    protected $hidden = ['password','remember_token'];



    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopePosts($query, $id)
    {
        return $query->where('post_id', $id);
    }

    public function scopeWithUserData($query)
    {
        $query->leftjoin('users','users.id', 'comments.user_id')
            ->addSelect('comments.*','users.username','users.profile_image','users.first_name','users.last_name');
    }

    public function getCreatedAtAttribute($value){
        return date("F j, Y ", strtotime($value));
    }

    public function getUsernameAttribute($value){
        return ucwords($value);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getProfileImageAttribute($value){
        if(is_dir(config('app.user_images_path').$value)
        ||  !File::exists(config('app.user_images_path').$value))
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$value;
    }

    public function getBodyAttribute($value){
        return htmlspecialchars($value);
    }


     //automatically define the user_id column attribute when model is loaded
     protected static function booted()
     {
         static::creating(function ($info) {
             $info->user_id=auth()->id();
         });
     }

}
