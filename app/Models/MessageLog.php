<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class MessageLog extends Model
{
    use HasFactory;
    use PowerJoins;


    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
