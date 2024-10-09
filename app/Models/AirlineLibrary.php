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
    public function user()
    {
        return $this->belongsTo(User::class,'uploaded_by','id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'uploaded_by','id');
    }
    public function userUpdated()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function adminUpdated()
    {
        return $this->belongsTo(Admin::class,'updated_by','id');
    }
}
