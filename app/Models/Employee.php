<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
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
  public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class, 'employee_id', 'id');
    }
}
