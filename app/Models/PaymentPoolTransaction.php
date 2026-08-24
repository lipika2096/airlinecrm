<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPoolTransaction extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'balance' => 'decimal:2',
        'allocated_at' => 'datetime',
    ];

    public function allocatedToCustomerAccount()
    {
        return $this->belongsTo(CustomerAccount::class, 'allocated_to_customer_account_id');
    }

    public function scopeUnallocated($query)
    {
        return $query->where('status', 'unallocated');
    }

    public function scopeAllocated($query)
    {
        return $query->where('status', 'allocated');
    }
}
