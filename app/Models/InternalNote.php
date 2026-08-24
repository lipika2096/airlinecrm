<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalNote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'note',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
