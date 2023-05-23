<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    

    public $timestamps = false;

    protected $fillable = ['follow_id','sender_id','receiver_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSender($query, $id)
    {
        return $query->where('sender_id', $id);
    }

    public function scopeReceiver($query, $id)
    {
        return $query->where('receiver_id', $id);
    }

   
}
