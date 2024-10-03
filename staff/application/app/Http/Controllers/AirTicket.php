<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'ticket_number',
        'emd',
        'mco',
        'date_change',
        'refund',
        'ticket_issued_from',
        'ticket_issued_to',
        'departure_date',
        'return_date',
        'airline_id',
        'base_fare',
        'taxes',
        'amount_paid_to_airlines',
        'amount_charged_from_pax',
        'status'
    ];
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

}
