<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentRight extends Model
{
  protected $guarded = ['id'];
  
  
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    
    
    public function duty()
    {
        return $this->belongsTo(Duty::class, 'duties_id', 'id');
    }
}
