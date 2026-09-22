<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'updated_by',
    ];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function passengers()
    {
        return $this->hasMany(B2CPassenger::class);
    }

    public function notes()
    {
        return $this->hasMany(B2CCustomerNote::class);
    }

    public function documents()
    {
        return $this->hasMany(B2CCustomerDocument::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'b2c_customer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
