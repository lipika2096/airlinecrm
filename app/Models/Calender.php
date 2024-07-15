<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    use HasFactory;


    protected $fillable = ['event_name', 'event_date', 'category'];
}
