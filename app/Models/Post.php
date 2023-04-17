<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Carbon\Carbon;
class Post extends Model
{
    use HasFactory;

    use PowerJoins;

    protected $perPage = 10;

    protected $fillable = ['user_id','title','slug','views','image','body','post_status','anonymous'];

    protected $casts = ['created_at' => 'datetime','updated_at' => 'datetime','published' => 'boolean',];

    protected $dates = ['created_at','updated_at'];

    protected $hidden = ['password','remember_token'];

    public function scopeOrdergroup($query){
        return $query->orderBy('id')->groupBy('id');
    }

    public function scopeUser_id($query, $id){
        return $query->where('user_id', $id);
    }

    public function scopePublished($query){
        return $query->where('post_status', '1')->orWhere('post_status', 'active');
    }

    public function scopeMostviewed($query){
        return $query->orderBy('views','desc');
    }

    public function scopeWithUserData($query)
    {
        $query->leftjoin('users','users.id', 'posts.user_id')
            ->addSelect('posts.*','users.username','users.profile_image','users.first_name','users.last_name');
    }
    public function getCreatedAtAttribute($value){
        return date('Y-m-d ', strtotime($value));
    }

    public function getTitleAttribute($value){
        return ucfirst($value);
    }

    public function getFullNameAttribute(){
       return ucwords($this->first_name) . ' ' . ucwords($this->last_name);
    }

    public function getUsernameAttribute($value){
        return ucwords($value);
    }

    public function getFirstNameAttribute($value){
        return ucwords($value);
    }

    public function getLastNameAttribute($value){
        return ucwords($value);
    }

    public function getNameAttribute()
    {
        $author="Anonymous";
        if($this->is_anonymous())
            return $author;
        elseif (!empty($this->first_name)|| !empty($this->last_name))
            $author=$this->first_name.' '.$this->last_name;
        else if (!empty($this->username))
            $author=$this->username;
        return '<a class="hover:text-yellow-800" href="'.route('user.profileview',$this->user_id).'">'.ucwords($author).'</a>';
    }
    public function getPostUpdateAttribute($value){

        //human-friendly and readable timestamp difference
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        if($value=='')
            return $value;
        else
            return date('Y-m-d H:i', strtotime($value));
    }

    public function getProfileImageAttribute($value){
        //if post creator is marked as anonymous return default profile image
        if($this->is_anonymous())
                return config('app.user_images_url').'user_profile.png';
        if(is_dir(config('app.user_images_path').$value)
        ||  !file_exists(config('app.user_images_path').$value))
        //retun the base directory for user images plus image name
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$value;
    }

    public function getImageAttribute($value){
        if(is_dir(config('app.post_images_path').$value)
        ||  !file_exists(config('app.post_images_path').$value))
        //retun the base directory for user images plus image name
                return config('app.post_images_url').'no thumbnail.png';
        else
                return config('app.post_images_url').$value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Comment::class);
    }

    public function topic()
    {
        return $this->hasOneThrough(Topic::class, PostTopic::class,'post_id','id','id','topic_id');
    }

    public function posttopic()
    {
        return $this->hasOne(PostTopic::class);
    }

    function is_published(){
        return $this->post_status==1 ? true : ($this->post_status=='active'?true:false);
    }
    function is_anonymous(){
        return $this->anonymous=='yes' ? true : ($this->anonymous=='active'?true:false);
    }


    //automatically define the user_id column attribute when model is loaded
    protected static function booted()
    {
        static::creating(function ($info) {
            $info->user_id=auth()->id();
        });
    }


}
