<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients'; // Specify the table name if different from the model name
    protected $primaryKey = 'client_id'; // Specify the primary key field
    public $timestamps = false; // Disable Laravel's default timestamp handling

    protected $guarded = ['client_id']; // Specify guarded fields

    // Optionally define additional relationships or properties here.
    
    
   public function user()
  {
    return $this->belongsTo(User::class, 'client_id', 'clientid');
  }
}
