<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\B2BPartnerActivity;

class B2BPartner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'b2_b_partners';

    protected $fillable = [
        'partner_code',
        'partner_name',
        'partner_type',
        'iata_tids_no',
        'country',
        'email',
        'phone',
        'website',
        'remarks',
        'status',
        'responsible_person',
        'region',
        'airline_responsibility',
        'product_responsibility',
        'tsa_status',
        'total_bookings',
        'total_passengers',
        'revenue',
        'created_by',
        'created_by_type',
        'updated_by',
    ];

    public function contacts()
    {
        return $this->hasMany(B2BPartnerContact::class, 'b2b_partner_id');
    }

    public function airlines()
    {
        return $this->hasMany(B2BPartnerAirline::class, 'b2b_partner_id');
    }

    public function products()
    {
        return $this->hasMany(B2BPartnerProduct::class, 'b2b_partner_id');
    }

    public function documents()
    {
        return $this->hasMany(B2BPartnerDocument::class, 'b2b_partner_id');
    }

    public function notes()
    {
        return $this->hasMany(B2BPartnerNote::class, 'b2b_partner_id');
    }

    public function activities()
    {
        return $this->hasMany(B2BPartnerActivity::class, 'b2b_partner_id')->latest();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'b2b_partner_id');
    }

    public function getTotalBookingsAttribute()
    {
        return \App\Models\Booking::where('b2b_partner_id', $this->id)->count();
    }

    public function getTotalPassengersAttribute()
    {
        $bookingIds = \App\Models\Booking::where('b2b_partner_id', $this->id)->pluck('id');
        return \App\Models\BookingPassenger::whereIn('booking_id', $bookingIds)->count();
    }

    public function getRevenueAttribute()
    {
        return \App\Models\Booking::where('b2b_partner_id', $this->id)->sum('total_sell');
    }

    public function createdBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(\App\Models\User::class, 'created_by');
        }
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(\App\Models\User::class, 'updated_by');
        }
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
