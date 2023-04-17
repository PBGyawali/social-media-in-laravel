<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTopic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['topic_id','post_id'];

    protected $table='post_topic';

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }


}
