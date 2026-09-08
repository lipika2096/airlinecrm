<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPassenger extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'dob' => 'date',
    ];

    // Accessor for full name (backward compatibility)
    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }

    // Mutator for name (if someone tries to set name directly)
    public function setNameAttribute($value)
    {
        $parts = explode(' ', $value, 2);
        $this->attributes['first_name'] = $parts[0] ?? '';
        $this->attributes['last_name'] = $parts[1] ?? null;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
