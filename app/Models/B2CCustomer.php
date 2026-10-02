<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class B2CCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
        protected $table = 'b2c_customers';


    protected $fillable = [
        'customer_type',
        'salutation',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'country',
        'status',
        'preferred_airline',
        'preferred_class',
        'meal_preference',
        'seat_preference',
        'special_requests',
        'created_by',
        'created_by_type',
        'updated_by',
        'updated_by_type',
    ];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function passengers()
    {
        return $this->hasMany(B2CPassenger::class, 'b2c_customer_id');
    }

    public function notes()
    {
        return $this->hasMany(B2CCustomerNote::class, 'b2c_customer_id');
    }

    public function documents()
    {
        return $this->hasMany(B2CCustomerDocument::class, 'b2c_customer_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'b2c_customer_id');
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
