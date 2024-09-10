<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirlineDetail extends Model
{
  protected $guarded = ['id'];

  public function airline()
  {
      return $this->belongsTo(Airline::class, 'airline_id');
  }
}
