<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Support extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='support';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['subject','message','email','full_name','read_by_user','important'];


    public function getCreatedAtAttribute($value){        

            $timestamp = Carbon::parse($value);
            if ($timestamp->isToday()) {
                $formatted_date = $timestamp->format('H:i');
            } elseif ($timestamp->isCurrentYear()) {
                $formatted_date = $timestamp->format('d M');
            } else {
                $formatted_date = $timestamp->format('m/d/Y');
            }

            return $formatted_date;
    }

    public function is_read(){        
        return in_array($this->read_by_user,['yes','active']);
    }
    public function is_important(){        
        return in_array($this->important,['yes','active']);
    }

    public function scopeUnread($query)
    {
        return $query->where('read_by_user','no');
    }
    
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->find($value);
        

        return parent::resolveRouteBinding($value, $field);
    }
}
