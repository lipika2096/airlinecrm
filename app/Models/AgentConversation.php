<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentConversation extends Model
{
  protected $guarded = ['id'];

  public function user(){
    return $this->belongsTo(User:: class,'from','id');
  }

  public function admin(){
    return $this->belongsTo(Admin:: class,'from','id');
  }

}
