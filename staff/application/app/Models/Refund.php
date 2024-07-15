<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'passenger_id', // Ensure this matches your actual field name in the database
        'refund_amount',
        'refund_status', // Ensure this matches your actual field name in the database
        'request_date',
        'processed_date',
        'reason',
        'agent_id', // Add this field to the fillable array
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
