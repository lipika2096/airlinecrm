<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FareConditions extends Model
{
    use HasFactory;
    protected $fillable = [
        'fare_condition_details',
        'cancellation_policy',
        'date_change_policy',
        'updated_by',
        'effective_from_date',
        'valid_till_date',
    ];
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
