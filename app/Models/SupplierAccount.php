<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'bank_name',
        'account_number',
        'account_name',
        'account_type',
        'currency',
        'swift_code',
        'iban',
        'routing_number',
        'bank_address',
        'is_primary',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
