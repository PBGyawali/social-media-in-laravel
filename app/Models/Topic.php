<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;


class Topic extends Model
{
    use HasFactory;
    

    public $timestamps = false;

    protected $fillable = ['name','slug'];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }
    public function scopeWithUserData($query)
    {
        $query->leftjoin('users','users.id','posts.user_id')
            ->addSelect('users.*','posts.*', 'post_topic.topic_id');
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, PostTopic::class,'topic_id','id','id','post_id');
    }

}
