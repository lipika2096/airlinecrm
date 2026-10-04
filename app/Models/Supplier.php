<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_code',
        'name',
        'category',
        'contact_person',
        'email',
        'phone',
        'status',
        'website',
        'description',
        'payment_terms',
        'currency',
        'tax_id',
        'address',
        'logo_path',
        'logo_name',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function accounts()
    {
        return $this->hasMany(SupplierAccount::class);
    }

    public function ledger()
    {
        return $this->hasMany(SupplierLedger::class);
    }
}
