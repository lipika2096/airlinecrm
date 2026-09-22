<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2BPartnerContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'b2_b_partner_contacts';

    protected $fillable = [
        'b2b_partner_id',
        'name',
        'designation',
        'phone',
        'email',
        'role',
        'created_by',
        'updated_by',
    ];

    public function partner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
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
