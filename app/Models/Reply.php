<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Support\Facades\File;
class Reply extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $fillable = ['user_id','comment_id','body','status'];

    protected $hidden = ['password','remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }
    public function scopeComments($query, $id)
    {
        return $query->where('comment_id', $id);
    }

    public function scopeWithUserData($query)
    {
        $query->leftjoin('users','users.id', 'replies.user_id')
            ->addSelect('replies.*','users.profile_image','users.username','users.first_name','users.last_name');
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
}
