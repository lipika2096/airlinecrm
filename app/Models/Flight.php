<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flight_no',
        'flight_name',
        'airline_id',
        'origin_id',
        'destination_id',
        'departure_time',
        'arrival_time',
        'available_seats',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function origin()
    {
        return $this->belongsTo(Sector::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Sector::class, 'destination_id');
    }
}
