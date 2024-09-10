<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'date',
        'category_id',
        'delay_duration',
        'description',
    ];
    public function category()
    {
        return $this->belongsTo(DelayCodeCategory::class, 'category_id'); // Assuming you have a 'category_id' column in delay_codes table
    }
}
