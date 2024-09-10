<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentProductsType extends Model
{
  protected $guarded = ['id'];

  public function agent()
  {
    return $this->belongsTo(Agent::class, 'agent_id', 'id');
  }
}
