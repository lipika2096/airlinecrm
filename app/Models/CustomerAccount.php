<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{

  protected $guarded = [
    'id'
  ];

  protected $casts = [
    'tr_date' => 'datetime',
    'allocated_at' => 'datetime',
  ];

  // public function admin()
  // {
  //   return $this->belongsTo(Admin::class, 'admin_id', 'id');
  // }

  public function admin()
  {
    return $this->belongsTo(Admin::class, 'customer_id', 'id');
  }

  public function allocatedToCustomerAccount()
  {
    return $this->belongsTo(CustomerAccount::class, 'allocated_to_customer_account_id');
  }

  public function scopeUnallocated($query)
  {
    return $query->where('payment_pool', '!=', 'allocated')->orWhereNull('payment_pool');
  }

  public function scopeAllocated($query)
  {
    return $query->where('payment_pool', 'allocated');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (empty($model->invoice_no)) {
        $model->invoice_no = self::generateInvoiceNo();
      }
    });
  }

  public static function generateInvoiceNo()
  {
    $prefix = 'INV';
    $date = now()->format('Ymd');
    
    $lastInvoice = self::where('invoice_no', 'like', $prefix . $date . '%')
      ->orderBy('id', 'desc')
      ->first();

    if ($lastInvoice) {
      $lastSequence = intval(substr($lastInvoice->invoice_no, -4));
      $newSequence = $lastSequence + 1;
    } else {
      $newSequence = 1;
    }

    return $prefix . $date . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
  }
}
