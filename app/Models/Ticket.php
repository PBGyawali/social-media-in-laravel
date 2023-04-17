<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Ticket extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $fillable = ['title','email','status','msg'];

    public function getCreatedAtAttribute($value){
       return  date('Y-m-d, G:i a', strtotime($value));
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function getStatusClassAttribute(){
        $status_class=array('success','warning','danger','secondary','primary');
        $status_types=array('resolved','on-hold','pending','closed','open');
        $status=$this->status;
        foreach($status_types as $key=> $status_type)
            if($status_type== $status)
                break;
        return 'text-'.$status_class[$key];
    }

    public function getProfileImageAttribute($value){
        if(is_dir(config('app.user_images_path').$value)
        ||  !file_exists(config('app.user_images_path').$value))
        //retun the base directory for user images plus image name
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$value;
    }


}
