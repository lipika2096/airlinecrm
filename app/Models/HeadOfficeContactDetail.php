<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadOfficeContactDetail extends Model
{
    use HasFactory;

    protected $table = 'head_office_contact_details';
    protected $fillable = [
        'airline_id',
        'title',
        'position',
        'last_name',
        'email_address',
        'phone_number',
        'first_name',
        'department',
        'last_updated_on',
        'last_updated_by',
        'agent_id'

    ];
}
