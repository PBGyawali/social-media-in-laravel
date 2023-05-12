<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
class Userlog extends Model
{
    use HasFactory;
    

    protected $primaryKey='user_id';

    public $timestamps = false;

    public $incrementing = false;


    protected $fillable = ['user_id','login_status','last_login_attempt','last_logout','last_password_change',
    'hash_method','user_status','verified','login','remarks'];


    protected $casts = ['last_login_attempt' => 'datetime',
                        'last_password_change'=>'datetime',
                        'last_logout'=>'datetime'
                       ];

    protected $dates = ['last_login_attempt','last_logout','last_password_change'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function getLastActiveAttribute(){
        return date("d-m-Y H:i", strtotime(max($this->last_logout, $this->last_login_attempt)));
    }
    public function getLastLogoutAttribute($name){
        return date("d-m-Y H:i",strtotime($name));
    }

    public function getLastPasswordChangeAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }
}
