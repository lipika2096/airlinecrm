<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffReadSign extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
