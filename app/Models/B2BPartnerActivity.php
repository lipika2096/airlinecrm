<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2BPartnerActivity extends Model
{
    use HasFactory;

    protected $table = 'b2b_partner_activities';

    protected $fillable = [
        'b2b_partner_id',
        'activity_type',
        'description',
        'old_values',
        'new_values',
        'performed_by',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function partner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(Admin::class, 'performed_by');
    }
}
