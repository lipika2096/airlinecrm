<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2BPartnerDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'b2_b_partner_documents';

    protected $fillable = [
        'b2b_partner_id',
        'file_name',
        'file_type',
        'document_type',
        'file_path',
        'created_by',
        'created_by_type',
        'updated_by',
        'updated_by_type',
    ];

    public function partner()
    {
        return $this->belongsTo(B2BPartner::class, 'b2b_partner_id');
    }

    public function createdBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(User::class, 'created_by');
        }
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        if ($this->updated_by_type === 'staff') {
            return $this->belongsTo(User::class, 'updated_by');
        }
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
