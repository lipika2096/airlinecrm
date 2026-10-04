<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'department',
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
