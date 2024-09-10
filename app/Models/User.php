<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $guarded = ['id'];

public function client()
{
    return $this->belongsTo(Client::class, 'clientid', 'client_id');
}

public function wallets()
{
    return $this->hasMany(Wallet::class, 'agent_id');
}
}
