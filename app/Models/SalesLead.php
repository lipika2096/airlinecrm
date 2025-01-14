<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLead extends Model
{
  protected $guarded = ['id'];

  public function statusId(){
    return $this->belongsTo(EventStatus::class, 'status', 'id');
}
}
