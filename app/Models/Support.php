<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table='support';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['subject','message','email','full_name'];
}
