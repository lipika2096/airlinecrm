<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialFare extends Model
{
    use HasFactory;

    protected $guarded = ['id'];



    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
