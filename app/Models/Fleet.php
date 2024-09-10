<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;
    protected $table = 'fleets';
    protected $guarded = ['id'];
    public function airline()
  {
      return $this->belongsTo(Airline::class, 'airline_id');
  }
}
