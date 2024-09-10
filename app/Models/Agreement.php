<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

   
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
