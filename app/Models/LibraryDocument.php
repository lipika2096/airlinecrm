<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryDocument extends Model
{

    use HasFactory;

    protected $fillable = ['airline_id', 'library_id', 'file_path'];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }
}
