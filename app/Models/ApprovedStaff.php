<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedStaff extends Model
{
    use HasFactory;
    protected $table = 'approved_staffs';
    protected $guarded = ['id'];
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function staff()
  {
      return $this->belongsTo(User::class, 'staff_id');
  }
}
