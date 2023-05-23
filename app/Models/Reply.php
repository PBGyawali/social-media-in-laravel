<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\File;
use App\Traits\UserTrait;
class Reply extends Model
{
    use HasFactory;
    
    use UserTrait;

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

    

    public function getBodyAttribute($value){
        return htmlspecialchars($value);
    }
}
