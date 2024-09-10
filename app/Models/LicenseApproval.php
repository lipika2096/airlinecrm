<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'file',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
