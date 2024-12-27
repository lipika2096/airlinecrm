<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    public function statusId(){
        return $this->belongsTo(EventStatus::class, 'status', 'id');
    }
}
