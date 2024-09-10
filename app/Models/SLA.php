<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLA extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'slas';

    protected $fillable = [
        'airline_id',
        'title',
        'category',
        'content',
        'document',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
