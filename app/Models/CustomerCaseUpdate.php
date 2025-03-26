<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCaseUpdate extends Model
{
    protected $fillable = [
        'case_id',
        'update_date',
        'updated_by',
        'comments',
        'status',
    ];

    public function case()
    {
        return $this->belongsTo(CustomerCaseHistory::class);
    }
}
