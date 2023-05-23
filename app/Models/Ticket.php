<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\UserTrait;
class Ticket extends Model
{
    use HasFactory;
    
    use UserTrait;

    protected $fillable = ['title','email','status','msg'];


    //define attribute to be automatically added to newly created model
    protected $appends = ['status_class'];

    public function getCreatedAtAttribute($value){
       return  date('Y-m-d, G:i a', strtotime($value));
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function getStatusClassAttribute(){
        $status = $this->status;
        $status_class_map = [
            "resolved" => "success",
            "on-hold" => "warning",
            "pending" => "danger",
            "closed" => "secondary",
            "open" => "primary",
        ];
        return 'text-' . $status_class_map[$status];
    }

    public function getStatusIconAttribute(){
        $status_icon_map = [
            "open" => "envelope",
            "pending" => "clock",
            "on-hold" => "pause-circle",
            "resolved" => "check",
            "closed" => "times",            
        ];
        $status=$this->status;
        $icon=$status_icon_map[$status];
        $class=$this->status_class;
        return view('status_icon',compact('class','status','icon'))->render();
    }


}
