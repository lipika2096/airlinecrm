<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'infant_id',
        'origin_id',
        'destination_id',
        'airline_id',
        'p_no',
        'name',
        'departure_date_from',
        'departure_time',
        'terminal',
        'departure_date_to',
        'arrival_time',
        'arrival_terminal',
        'return_date',
        'return_time',
        'ret_terminal',
        'ret_flight_no',
        'flight_no',
        'availabilty',
        'seat',
        'sales_stop_date',
        'term',
        'base_fair',
        'tax',
        'p_tax',
        'rate_type',
        'charges',

    ];


    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'origin_id', 'id')->withDefault();
    }
    public function origin()
    {
        return $this->belongsTo(Sector::class, 'origin_id', 'id')->withDefault();
    }

    public function destination()
    {
        return $this->belongsTo(Sector::class, 'destination_id', 'id')->withDefault();
    }
}