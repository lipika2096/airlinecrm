<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayCodeCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function delayCodes()
    {
        return $this->hasMany(DelayCode::class, 'category_id');
    }
}
