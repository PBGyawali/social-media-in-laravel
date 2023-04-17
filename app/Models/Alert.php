<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Alert extends Model
{
    use HasFactory;
    use PowerJoins;

    //defining default pagination value when not defined
    protected $perPage = 10;

    public $timestamps = false;

    protected $fillable = ['user_id','alert','type','read_by_user','alert_name','alert_value'];

    //defining the column name in the table of created_at
    CONST CREATED_AT='alert_date';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRead($query)
    {
        return $query->where('read_by_user','no');
    }

    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function getAlertDateAttribute($value){
            return date('Y-m-d H:i', strtotime($value));
    }
    public function getIconClassAttribute(){
        $type=$this->type;
        $iconclass=' text-primary ';
        $alerttypes=array("comment","reply","money","update","delete","warning",
        "unfollow","follow","dislike","like","reset",'other');
        $icontype=array("comment","comments","donate","sync","trash","exclamation-triangle","user-minus",
        "user-plus","thumbs-down","thumbs-up","reply",'file-alt' );
        if     (in_array($type,(array_slice($alerttypes,0,2)))) $iconclass=' text-info ';
        elseif (in_array($type,(array_slice($alerttypes,2,2)))) $iconclass=' text-success ';
        elseif (in_array($type,(array_slice($alerttypes,4,2)))) $iconclass=' text-danger ';
        elseif (in_array($type,(array_slice($alerttypes,6,1)))) $iconclass=' text-secondary ';
        foreach($alerttypes as $key=> $alerttype)
            if($type== $alerttype)
                break;
        return $icontype[$key].$iconclass;
    }

}
