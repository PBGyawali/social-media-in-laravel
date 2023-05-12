<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;
trait UserTrait
{
    
    public function getProfileImageAttribute($value){
        // image is a remote url return it
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        } else {
            $url_parts = parse_url($value);
            if (isset($url_parts['scheme']) && isset($url_parts['host'])) {
                return $value;
            } elseif(
                !$value
                || is_dir(config('app.user_images_path').$value)
                || !file_exists(config('app.user_images_path').$value)
                //|| !Storage::exists($value)
            ){
                // return a default image if the file does not exist
                return config('app.user_images_url').'user_profile.png';
                //return Storage::url('user_profile.png');
            }else {
                // return the URL to the file using the storage facade
                return config('app.user_images_url').$value;
            // return Storage::url($value);
            }
        }

    }

    public function getFullNameAttribute()
    {
       return ucwords($this->first_name) . ' ' . ucwords($this->last_name);
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
