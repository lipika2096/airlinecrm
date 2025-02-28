<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{

  protected $guarded = [
    'id'
  ];

  public function admin()
  {
    return $this->belongsTo(Admin::class, 'admin_id', 'id');
  }
}
