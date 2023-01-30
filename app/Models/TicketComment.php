<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class TicketComment extends Model
{
    use HasFactory;
    use PowerJoins;

    protected $fillable = ['ticket_id','msg'];

    protected $table='tickets_comments';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getCreatedAtAttribute($name){
        return  date('Y-m-d, G:i a', strtotime($name));
     }

}
