<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
  use HasFactory, HasRoles;

  protected $table = 'employees';
  protected $guarded = ['id'];

  protected $guard_name = 'employee';

  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }
  public function designation()
  {
    return $this->belongsTo(Designation::class);
  }
}
