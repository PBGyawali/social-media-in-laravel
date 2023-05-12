<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Select;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class WebsiteInfo extends Model
{
    use HasFactory;

    protected $fillable =
     [ 'website_name','website_email','website_timezone','website_tagline',
        'user_target','website_address','owner_address','owner_contact_no','owner_country',
        'website_theme','website_contact_no','website_logo','owner_email','owner_postal_code',
        'secret_password','owner_name',
    ];

    public $timestamps = false;

    protected $hidden = ['secret_password','password'];

    protected $primaryKey='website_id';

    public function websitename(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }

    public function ownername(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }

    public function ownerAddress(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => ucwords($value),
        );
    }

    public function setWebsiteAddressAttribute($name){
        $this->attributes['website_address'] =ucwords($name);
    }

    public function setSecretPasswordAttribute($password){
        $this->attributes['secret_password'] = Hash::make($password);
    }

    public function getWebsiteLogoAttribute($name){
        if(is_dir(config('app.logo_path').$name)
        ||  !File::exists(config('app.logo_path').$name))
                return config('app.logo_url').'nothumbnail.png';
        else
                return config('app.logo_url').$name;
    }

    public function getOwnerImageAttribute($name){
        if(is_dir(config('app.user_images_path').$name)
        ||  !File::exists(config('app.user_images_path').$name))
                return config('app.user_images_url').'user_profile.png';
        else
                return config('app.user_images_url').$name;
    }

}
