<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadOfficeContactDetail extends Model
{
    use HasFactory;

    protected $table = 'head_office_contact_details';
    protected $guarded = ['id'];
}
