<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
  protected $guarded = ['id'];
  
  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id', 'id');
  }
  
   public function user()
  {
    return $this->belongsTo(User::class, 'employee_id', 'id');
  }
}
