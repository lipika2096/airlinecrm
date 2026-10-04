<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'annual_discount' => 'decimal:2',
        'proration_first_month' => 'boolean',
        'is_active' => 'boolean',
    ];
}
