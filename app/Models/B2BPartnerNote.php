<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2BPartnerNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'b2_b_partner_notes';

    protected $fillable = [
        'b2b_partner_id',
        'note',
        'created_by',
        'created_by_type',
        'updated_by',
        'updated_by_type',
    ];

    protected $with = ['createdByAdmin', 'createdByUser', 'updatedByAdmin', 'updatedByUser'];

    public function partner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
    }

    public function createdByAdmin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedByAttribute()
    {
        if ($this->created_by_type === 'superadmin' || $this->created_by_type === 'staff') {
            return $this->createdByAdmin;
        } elseif ($this->created_by_type === 'customer') {
            return $this->createdByUser;
        }
        return null;
    }

    public function getUpdatedByAttribute()
    {
        if ($this->updated_by_type === 'superadmin' || $this->updated_by_type === 'staff') {
            return $this->updatedByAdmin;
        } elseif ($this->updated_by_type === 'customer') {
            return $this->updatedByUser;
        }
        return null;
    }
}
