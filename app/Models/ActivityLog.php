<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ActivityLog extends Model
{
    use HasFactory;

    protected $perPage = 20;

    public $timestamps = false;

    protected $fillable = ['user_id', 'text','type','activity_object','parent_activity_id',
        'parent_activity_text','child_activity_text'];

    CONST CREATED_AT='activity_performed';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOld($query)
    {
        return $query->whereRaw('activity_performed < (NOW() - INTERVAL 30 DAY)');
    }
    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function getIconClassAttribute(){
        $type=$this->type;
        $iconclass=' text-primary ';
        $activitytypes=array("comment","reply","money","update","delete","warning","logout","unfollow",
        "undislike","unlike","follow","dislike","like","reset","login","register","other");
        $icontype=array("comment","comments","donate","sync","trash","exclamation-triangle","sign-out-alt","user-minus",
        "thumbs-down","thumbs-up","user-plus","thumbs-down","thumbs-up","reply","sign-in-alt","user-graduate","file-alt");
        if     (in_array($type,(array_slice($activitytypes,0,2)))) $iconclass=' text-info ';
        elseif (in_array($type,(array_slice($activitytypes,2,2)))) $iconclass=' text-success ';
        elseif (in_array($type,(array_slice($activitytypes,4,2)))) $iconclass=' text-danger ';
        elseif (in_array($type,(array_slice($activitytypes,6,4)))) $iconclass=' text-secondary ';
        $key = array_search($type, $activitytypes);
        return $icontype[$key].$iconclass;
    }



}



