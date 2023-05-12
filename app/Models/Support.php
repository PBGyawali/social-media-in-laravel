<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table='support';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['subject','message','email','full_name'];


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
}
