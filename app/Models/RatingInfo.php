<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class RatingInfo extends Model
{
    use HasFactory;
    use PowerJoins;

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['user_id','post_id','rating_action'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRated($query, $id)
    {
        return $query->where('rating_action', $id);
    }

    public function scopeUser_id($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeSender($query, $id)
    {
        return $query->where('sender_id', $id);
    }

    public function scopePosts($query, $id)
    {
        return $query->where('post_id', $id);
    }

    protected static function booted()
    {
        static::creating(function ($info) {
            $info->user_id=auth()->id();
        });
    }
}
