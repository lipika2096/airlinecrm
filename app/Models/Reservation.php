<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id', 'id');
    }

    public function flightDetail()
    {
        return $this->belongsTo(FlightDetail::class, 'flight_detail_id', 'id');
    }
    
    public function pnr()
    {
        return $this->belongsTo(Pnr::class, 'pnr_id', 'id');
    }
}
