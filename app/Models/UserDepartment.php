<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    protected $table = 'user_department';

    protected $fillable = [
        'user_id',
        'department_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
