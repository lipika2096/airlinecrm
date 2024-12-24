<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignLeadStaff extends Model
{
    use HasFactory;
    protected $table = 'assign_lead_staffs';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
