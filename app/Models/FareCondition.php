<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FareCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'fare_condition_details',
        'cancellation_policy',
        'date_change_policy',
        'updated_by',
        'agent_id',
        'effective_from_date',
        'valid_till_date',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
