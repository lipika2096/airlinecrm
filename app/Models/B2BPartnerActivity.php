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
        'performed_by_type',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    protected $with = ['performedByAdmin', 'performedByUser'];

    public function partner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
    }

    public function performedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'performed_by');
    }

    public function performedByUser()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function getPerformedByAttribute()
    {
        if ($this->performed_by_type === 'customer') {
            return $this->performedByUser;
        } else {
            return $this->performedByAdmin;
        }
    }
}
