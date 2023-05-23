<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravolt\Avatar\Facade as Avatar;
trait UserTrait
{
    
    public function getProfileImageAttribute($value){
        // image is a remote url return it
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        } else {
            $url_parts = parse_url($value);
            if (method_exists($this, 'is_anonymous') && $this->is_anonymous()) {
                return config('app.user_images_url').'user_profile.png';
            } 
            else if (isset($url_parts['scheme']) && isset($url_parts['host'])) {
                return $value;
            } 
            elseif(!$value){
                // return a default image if the file does not exist
                return Avatar::create($this->full_name)->toBase64();
                //return Storage::url('user_profile.png');
            }
            elseif(is_dir(config('app.user_images_path').$value)
                || !file_exists(config('app.user_images_path').$value)                
            ){
                // return a default image if the file does not exist
                return config('app.user_images_url').'user_profile.png';
                //return Storage::url('user_profile.png');
            }
            else {
                // return the URL to the file using the storage facade
                return config('app.user_images_url').$value;
            // return Storage::url($value);
            }
        }

    }

    

    public function getFullNameAttribute()
    {
        if($this->first_name ||$this->last_name)
       return $this->first_name . ' ' . $this->last_name;
       else{
        return $this->username;
       }
    }

    public function getFirstNameAttribute($value){
        return ucwords($value);
    }

    public function getLastNameAttribute($value){
        return ucwords($value);
    }


    public function username(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }


}
