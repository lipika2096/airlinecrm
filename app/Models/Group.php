<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $guarded = ['id'];
  public function airline()
  {
    return $this->belongsTo(Airline::class, 'airline_id', 'id');
  }
  public function agent()
  {
    return $this->belongsTo(User::class, 'agent_id', 'clientid');
  }
}
