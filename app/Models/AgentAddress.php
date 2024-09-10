<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAddress extends Model
{
  protected $guarded = ['id'];

  public function agent()
  {
      return $this->hasOne(Agent::class, 'agent_id', 'id');
  }
}
