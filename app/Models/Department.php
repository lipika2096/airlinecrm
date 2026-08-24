<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $guarded = ['id'];

  public function staff()
  {
      return $this->belongsTo(User::class, 'staff_id');
  }

  public function scopeForStaff($query, $staffId = null)
  {
      if ($staffId) {
          return $query->where('staff_id', $staffId);
      }
      return $query->whereNull('staff_id');
  }
}
