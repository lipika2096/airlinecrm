<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designations';
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'position', 'id');
    }

    public function scopeForStaff($query, $staffId = null)
    {
        if ($staffId) {
            return $query->where('staff_id', $staffId);
        }
        return $query->whereNull('staff_id');
    }
}
