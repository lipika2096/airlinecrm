<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentLibrary extends Model
{

    protected $guarded = ['id'];


    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'uploaded_by','id');
    }
}
