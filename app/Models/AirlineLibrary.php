<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirlineLibrary extends Model
{

    protected $table = 'airline_libraries';
    protected $guarded = ['id'];


    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
    public function documents()
    {
        return $this->hasMany(LibraryDocument::class, 'library_id');
    }
}
