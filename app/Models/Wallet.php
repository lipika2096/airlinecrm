<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;	


class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
    
    public function agent()
    {
        return $this->hasOne(User::class, 'id', 'agent_id');
    }

    public function book(){
        return $this->hasOne(Book::class, 'book_id', 'description');

    }
}
