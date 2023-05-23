<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Traits\UserTrait;

class OfflineMessage extends Model
{
    use HasFactory;
    
    use UserTrait;


    protected $fillable = ['user_id','sender_id','message','read_by_user','notfication','conversation_id'];
    
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

    public function getSentOnAttribute($name)
    {
        return Carbon::parse($name)->diffForHumans();
    }
}
