<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
  protected $guarded = ['id'];
  
   public function user()
  {
    return $this->belongsTo(User::class, 'employee_id', 'clientid');
  }
  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }
}
