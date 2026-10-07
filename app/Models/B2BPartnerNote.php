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

    protected $appends = ['creator_name', 'updater_name'];

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

    public function getCreatorNameAttribute()
    {
        if ($this->created_by_type === 'staff') {
            return $this->createdByUser ? $this->createdByUser->full_name : 'Unknown';
        } elseif ($this->created_by_type === 'customer') {
            return $this->createdByUser ? $this->createdByUser->name : 'Unknown';
        } else {
            return $this->createdByAdmin ? $this->createdByAdmin->name : 'Unknown';
        }
    }

    public function getUpdaterNameAttribute()
    {
        if ($this->updated_by_type === 'staff') {
            return $this->updatedByUser ? $this->updatedByUser->full_name : 'Unknown';
        } elseif ($this->updated_by_type === 'customer') {
            return $this->updatedByUser ? $this->updatedByUser->name : 'Unknown';
        } else {
            return $this->updatedByAdmin ? $this->updatedByAdmin->name : 'Unknown';
        }
    }
}
