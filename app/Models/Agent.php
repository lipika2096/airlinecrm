<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
  protected $guarded = ['id'];

  public function specialFare()
  {
      return $this->belongsTo(SpecialFare::class, 'agent_id');
  }

  public function agent_addresses(){
    return $this->hasOne(AgentAddress::class, 'agent_id');
  }

  public function head_office(){
    return $this->hasOne(HeadOfficeContactDetail::class, 'agent_id');
  }
  public function agentProductTypes(){
    return $this->hasMany(AgentProductsType::class, 'agent_id');
  }

  public function cases(){
    return $this->hasMany(CaseHistory::class, 'agent_id');
  }
}
