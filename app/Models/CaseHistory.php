<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseHistory extends Model
{
    protected $table = 'cases';
  protected $guarded = ['id'];
  public function updates()
  {
      return $this->hasMany(CaseUpdate::class,'case_id', 'id');
  }
  public function airline()
  {
    return $this->belongsTo(Airline::class,'airline_id', 'id');
  }
}
