<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadModal extends Model
{
    protected $table = 'detail_leads'; // Specify the table name if different from the default (optional)

    protected $fillable = [
        'name', 'email', 'phone', 'project', 'company',
    ];

    // Optionally, you can define additional attributes or methods here as needed
}
