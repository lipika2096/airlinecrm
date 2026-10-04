<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SalesPackage;
use Carbon\Carbon;

class AdminDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    

    protected $casts = [
        'package_activation_date' => 'date',
        'subscription_modules' => 'array',
        'monthly_charge' => 'decimal:2',
        'annual_charge' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'permissions' => 'array',
    ];

    protected $appends = ['package_activation_date_formatted'];

    public function salesPackage()
    {
        return $this->belongsTo(SalesPackage::class, 'subscription_type', 'id');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function getPackageActivationDateFormattedAttribute()
    {
        return $this->package_activation_date ? Carbon::parse($this->package_activation_date)->format('F j, Y') : '-';
    }
}
