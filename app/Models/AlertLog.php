<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class AlertLog extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $primaryKey='user_id';

    public $timestamps = false;

    public $incrementing = false;
    
    protected $fillable = ['user_id','notification','type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
