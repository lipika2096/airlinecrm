<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
  protected $guarded = ['id'];

  public function admin()
  {
      return $this->hasOne(Admin::class, 'admin_id', 'id');
  }
}
