<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'passenger_id',
        'booking_number',
        'origin',
        'airline_name',
        'destination',
        'passenger_name',
        'booking_reference',
        'booking_date',
        'total_amount',
        'status'
    ];
}
