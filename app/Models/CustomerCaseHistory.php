<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCaseHistory extends Model
{
  protected $guarded = ['id'];
  public function updates()
  {
      return $this->hasMany(CustomerCaseUpdate::class,'case_id', 'id');
  }
}
