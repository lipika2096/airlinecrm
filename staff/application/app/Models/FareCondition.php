<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FareCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'fare_condition_details', 'cancellation_policy', 'date_change_policy',
        'effective_from_date', 'valid_till_date', 'agent_id', 'updated_by'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
