<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class B2CCustomerNote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'b2c_customer_notes';


    protected $fillable = [
        'b2c_customer_id',
        'note',
        'created_by',
        'created_by_type',
    ];

    public function customer()
    {
        return $this->belongsTo(B2CCustomer::class, 'b2c_customer_id');
    }

    public function createdBy()
    {
        if ($this->created_by_type === 'staff') {
            return $this->belongsTo(User::class, 'created_by');
        }
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
