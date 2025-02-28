<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHeadOfficeContactDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'last_updated_by', 'id');
    }
}
