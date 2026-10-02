<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class B2CPassenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'b2c_passengers';


    protected $fillable = [
        'b2c_customer_id',
        'passenger_type',
        'title',
        'first_name',
        'last_name',
        'date_of_birth',
        'passport_number',
        'nationality',
        'frequent_flyer_number',
        'created_by',
        'created_by_type',
        'updated_by',
        'updated_by_type',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function customer()
    {
        return $this->belongsTo(B2CCustomer::class, 'b2c_customer_id');
    }

    public function createdBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(User::class, 'created_by');
        }
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        if ($this->updated_by_type === 'staff') {
            return $this->belongsTo(User::class, 'updated_by');
        }
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
