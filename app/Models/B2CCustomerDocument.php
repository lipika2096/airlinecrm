<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2CCustomerDocument extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
        protected $table = 'b2c_customer_documents';


    protected $fillable = [
        'b2c_customer_id',
        'document_type',
        'file_path',
        'file_name',
        'description',
        'created_by',
    ];

    public function customer()
    {
        return $this->belongsTo(B2CCustomer::class, 'b2c_customer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
