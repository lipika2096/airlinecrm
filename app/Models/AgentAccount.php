<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAccount extends Model
{

  protected $guarded = [
    'id'
  ];

  protected $casts = [
    'tr_date' => 'datetime',
  ];

  public function agent()
  {
    return $this->belongsTo(Agent::class, 'agent_id', 'id');
  }
}
