<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirlineDiscount extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function faretype()
    {
        return $this->belongsTo(FareType::class,'fare_type','fare_type_name');
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
