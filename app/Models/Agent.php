<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
  protected $guarded = ['id'];

  public function specialFare()
  {
      return $this->hasOne(SpecialFare::class, 'agent_id');
  }
}
