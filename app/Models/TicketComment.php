<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class TicketComment extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $fillable = ['ticket_id','msg'];

    protected $table='tickets_comments';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getCreatedAtAttribute($name){
        return  date('Y-m-d, G:i a', strtotime($name));
     }


    public function scopeWithUserData($query)
    {
        $query->leftjoin('users','users.id', 'ticket_comments.user_id')
            ->addSelect('ticket_comments.*','users.username','users.profile_image','users.first_name','users.last_name');
    }



     public function getProfileImageAttribute($value){
        if(is_dir(config('app.user_images_path').$value)
        ||  !file_exists(config('app.user_images_path').$value))
        //retun the base directory for user images plus image name
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     //automatically define the user_id column attribute when model is loaded
     protected static function booted()
     {
         static::creating(function ($info) {
             $info->user_id=auth()->id();
         });
     }
}
